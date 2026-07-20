<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AppointmentApprovedNotification;
use App\Notifications\AppointmentRejectedNotification;
use App\Notifications\AppointmentRequestPendingNotification;
use App\Notifications\NewAppointmentRequestNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AppointmentsWorkflowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.timezone' => 'Africa/Blantyre',
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        date_default_timezone_set('Africa/Blantyre');

        DB::purge();
        DB::reconnect();

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_04_02_065725_create_permission_tables.php',
            '2026_07_11_000002_create_services_table.php',
            '2026_07_11_000003_create_appointments_table.php',
            '2026_07_18_000013_add_decision_workflow_to_appointments_table.php',
        ] as $migrationFile) {
            $migration = require database_path('migrations/'.$migrationFile);
            $migration->up();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->travelTo(now()->startOfMinute());
    }

    protected function tearDown(): void
    {
        $this->travelBack();

        parent::tearDown();
    }

    public function test_public_submission_creates_a_protected_pending_request_and_sends_the_required_notifications(): void
    {
        Notification::fake();

        $service = $this->service();
        $administrator = User::factory()->create([
            'name' => 'Clinic Administrator',
            'email' => 'administrator@example.com',
        ]);
        $receptionist = User::factory()->create([
            'name' => 'Clinic Receptionist',
            'email' => 'receptionist@example.com',
        ]);
        $suspendedStaff = User::factory()->create([
            'name' => 'Suspended Staff Member',
            'email' => 'suspended@example.com',
            'status' => 'Suspended',
        ]);
        $preferredAt = now()->addDays(2)->setTime(9, 30);

        $this
            ->post(route('appointments.request'), $this->publicPayload($service, [
                'preferred_at' => $preferredAt->toDateTimeString(),
                'status' => Appointment::STATUS_APPROVED,
                'appointment_at' => now()->addDays(3)->toDateTimeString(),
                'practitioner_id' => $receptionist->id,
                'rejection_reason' => 'This must not be accepted from the public form.',
                'reviewed_by' => $administrator->id,
                'reviewed_at' => now()->toDateTimeString(),
                'notes' => 'This must remain an internal-only field.',
            ]))
            ->assertRedirect(route('home').'#book-appointment')
            ->assertSessionHas('success');

        $appointment = Appointment::where('client_email', 'visitor@example.com')->firstOrFail();

        $this->assertSame(Appointment::STATUS_PENDING, $appointment->status);
        $this->assertSame('I would prefer a morning consultation.', $appointment->request_message);
        $this->assertTrue($appointment->preferred_at->equalTo($preferredAt));
        $this->assertNull($appointment->appointment_at);
        $this->assertNull($appointment->practitioner_id);
        $this->assertNull($appointment->rejection_reason);
        $this->assertNull($appointment->reviewed_by);
        $this->assertNull($appointment->reviewed_at);
        $this->assertNull($appointment->notes);

        Notification::assertSentTo(
            [$administrator, $receptionist],
            NewAppointmentRequestNotification::class,
            fn ($notification, array $channels): bool => $channels === ['mail']
        );
        Notification::assertNotSentTo(
            $suspendedStaff,
            NewAppointmentRequestNotification::class
        );
        Notification::assertSentTimes(NewAppointmentRequestNotification::class, 2);
        Notification::assertSentOnDemand(
            AppointmentRequestPendingNotification::class,
            fn (
                $notification,
                array $channels,
                AnonymousNotifiable $notifiable
            ): bool => $channels === ['mail']
                && $this->routesTo($notifiable, $appointment->client_email)
        );
        Notification::assertSentOnDemandTimes(AppointmentRequestPendingNotification::class);
        Notification::assertCount(3);
    }

    public function test_public_submission_rejects_an_invalid_email_and_an_inactive_service_without_side_effects(): void
    {
        Notification::fake();

        $activeService = $this->service();
        $inactiveService = $this->service([
            'name' => 'Unavailable Service',
            'status' => 'Inactive',
        ]);

        $this
            ->post(route('appointments.request'), $this->publicPayload($activeService, [
                'client_email' => 'not-an-email',
            ]))
            ->assertSessionHasErrors('client_email');

        $this
            ->post(route('appointments.request'), $this->publicPayload($inactiveService))
            ->assertSessionHasErrors('service_id');

        $this->assertDatabaseCount('appointments', 0);
        Notification::assertNothingSent();
    }

    public function test_notification_copy_clearly_describes_each_appointment_state(): void
    {
        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $staff = User::factory()->create(['name' => 'Clinic Receptionist']);

        $staffMail = (new NewAppointmentRequestNotification($appointment))->toMail($staff);
        $pendingMail = (new AppointmentRequestPendingNotification($appointment))
            ->toMail(new AnonymousNotifiable);

        $appointmentAt = now()->addDays(3)->setTime(10, 15);
        $appointment->forceFill([
            'status' => Appointment::STATUS_APPROVED,
            'appointment_at' => $appointmentAt,
        ])->save();

        $approvedMail = (new AppointmentApprovedNotification($appointment->fresh()))
            ->toMail(new AnonymousNotifiable);

        $rejectionReason = 'The requested service is unavailable on that day.';
        $appointment->forceFill([
            'status' => Appointment::STATUS_REJECTED,
            'appointment_at' => null,
            'rejection_reason' => $rejectionReason,
        ])->save();

        $rejectedMail = (new AppointmentRejectedNotification($appointment->fresh()))
            ->toMail(new AnonymousNotifiable);

        $this->assertSame(
            route('admin.appointments.show', $appointment),
            $staffMail->actionUrl,
        );
        $this->assertStringContainsString('ready for review', implode(' ', $staffMail->introLines));
        $this->assertStringContainsString('pending', strtolower(implode(' ', $pendingMail->introLines)));
        $this->assertStringContainsString('approved', strtolower(implode(' ', $approvedMail->introLines)));
        $this->assertStringContainsString(
            $appointmentAt->format('l, j F Y'),
            implode(' ', $approvedMail->introLines),
        );
        $this->assertStringContainsString(
            'unable to approve',
            strtolower(implode(' ', $rejectedMail->introLines)),
        );
        $this->assertStringContainsString($rejectionReason, implode(' ', $rejectedMail->introLines));
    }

    public function test_a_pending_public_request_is_visible_on_the_admin_appointments_page(): void
    {
        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $staff = $this->staffWithPermission('list appointments');

        $this
            ->actingAs($staff)
            ->get(route('admin.appointments.index'))
            ->assertOk()
            ->assertSee('data-mobile-appointment-card', false)
            ->assertDontSee('admin-table-scroll', false)
            ->assertSee($appointment->client_name)
            ->assertSee($appointment->client_email)
            ->assertSee($service->name)
            ->assertSee(Appointment::STATUS_PENDING);
    }

    public function test_staff_dashboard_renders_upcoming_appointments_as_responsive_cards(): void
    {
        $service = $this->service();
        $appointment = $this->pendingAppointment($service, [
            'status' => Appointment::STATUS_APPROVED,
            'appointment_at' => now()->addDays(3)->setTime(10, 30),
        ]);
        $staff = User::factory()->create();

        $this
            ->actingAs($staff)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('data-mobile-upcoming-appointment-card', false)
            ->assertDontSee('admin-table-scroll', false)
            ->assertSee($appointment->client_name)
            ->assertSee($service->name);
    }

    public function test_an_authorised_staff_member_can_approve_a_pending_request_and_notify_the_requester(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $reviewer = $this->staffWithPermission('update appointment');
        $practitioner = User::factory()->create([
            'name' => 'Dr. Chirwa',
            'email' => 'doctor@example.com',
        ]);
        $appointmentAt = now()->addDays(4)->setTime(10, 30);

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_APPROVED,
                'appointment_at' => $appointmentAt->toDateTimeString(),
                'practitioner_id' => $practitioner->id,
            ])
            ->assertRedirect(route('admin.appointments.show', $appointment))
            ->assertSessionHas('success');

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_APPROVED, $appointment->status);
        $this->assertTrue($appointment->appointment_at->equalTo($appointmentAt));
        $this->assertSame($practitioner->id, $appointment->practitioner_id);
        $this->assertSame($reviewer->id, $appointment->reviewed_by);
        $this->assertTrue($appointment->reviewed_at->equalTo(now()));
        $this->assertNull($appointment->rejection_reason);
        $this->assertSame('I would prefer a morning consultation.', $appointment->request_message);

        Notification::assertSentOnDemand(
            AppointmentApprovedNotification::class,
            fn (
                $notification,
                array $channels,
                AnonymousNotifiable $notifiable
            ): bool => $channels === ['mail']
                && $this->routesTo($notifiable, $appointment->client_email)
        );
        Notification::assertSentOnDemandTimes(AppointmentApprovedNotification::class);
        Notification::assertCount(1);
    }

    public function test_approval_requires_a_future_appointment_date(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $reviewer = $this->staffWithPermission('update appointment');

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_APPROVED,
            ])
            ->assertSessionHasErrors('appointment_at');

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_APPROVED,
                'appointment_at' => now()->subMinute()->toDateTimeString(),
            ])
            ->assertSessionHasErrors('appointment_at');

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_PENDING, $appointment->status);
        $this->assertNull($appointment->appointment_at);
        $this->assertNull($appointment->reviewed_by);
        $this->assertNull($appointment->reviewed_at);
        Notification::assertNothingSent();
    }

    public function test_an_authorised_staff_member_can_reject_a_pending_request_without_losing_its_message(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $reviewer = $this->staffWithPermission('update appointment');
        $rejectionReason = 'The requested specialist is unavailable on the preferred day.';

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_REJECTED,
                'rejection_reason' => $rejectionReason,
                'appointment_at' => now()->addDays(3)->toDateTimeString(),
                'practitioner_id' => $reviewer->id,
            ])
            ->assertRedirect(route('admin.appointments.show', $appointment))
            ->assertSessionHas('success');

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_REJECTED, $appointment->status);
        $this->assertSame($rejectionReason, $appointment->rejection_reason);
        $this->assertSame('I would prefer a morning consultation.', $appointment->request_message);
        $this->assertNull($appointment->appointment_at);
        $this->assertNull($appointment->practitioner_id);
        $this->assertSame($reviewer->id, $appointment->reviewed_by);
        $this->assertTrue($appointment->reviewed_at->equalTo(now()));

        Notification::assertSentOnDemand(
            AppointmentRejectedNotification::class,
            fn (
                $notification,
                array $channels,
                AnonymousNotifiable $notifiable
            ): bool => $channels === ['mail']
                && $this->routesTo($notifiable, $appointment->client_email)
        );
        Notification::assertSentOnDemandTimes(AppointmentRejectedNotification::class);
        Notification::assertCount(1);
    }

    public function test_rejection_requires_a_reason_and_does_not_change_the_request_on_failure(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $reviewer = $this->staffWithPermission('update appointment');

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_REJECTED,
                'rejection_reason' => '',
            ])
            ->assertSessionHasErrors('rejection_reason');

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_PENDING, $appointment->status);
        $this->assertSame('I would prefer a morning consultation.', $appointment->request_message);
        $this->assertNull($appointment->rejection_reason);
        $this->assertNull($appointment->reviewed_by);
        $this->assertNull($appointment->reviewed_at);
        Notification::assertNothingSent();
    }

    public function test_guests_and_staff_without_permission_cannot_decide_a_request(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $appointmentAt = now()->addDays(3)->setTime(11, 0);
        $payload = [
            'status' => Appointment::STATUS_APPROVED,
            'appointment_at' => $appointmentAt->toDateTimeString(),
        ];

        $this
            ->patch(route('admin.appointments.decision', $appointment), $payload)
            ->assertRedirect(route('login'));

        $staffWithoutPermission = User::factory()->create();

        $this
            ->actingAs($staffWithoutPermission)
            ->patch(route('admin.appointments.decision', $appointment), $payload)
            ->assertForbidden();

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_PENDING, $appointment->status);
        $this->assertNull($appointment->appointment_at);
        $this->assertNull($appointment->reviewed_by);
        Notification::assertNothingSent();
    }

    public function test_a_request_can_only_be_decided_once_and_a_second_attempt_sends_no_email(): void
    {
        Notification::fake();

        $service = $this->service();
        $appointment = $this->pendingAppointment($service);
        $reviewer = $this->staffWithPermission('update appointment');
        $appointmentAt = now()->addDays(3)->setTime(14, 15);

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_APPROVED,
                'appointment_at' => $appointmentAt->toDateTimeString(),
            ])
            ->assertRedirect(route('admin.appointments.show', $appointment));

        Notification::assertSentOnDemandTimes(AppointmentApprovedNotification::class);

        $appointment->refresh();
        $firstReviewedAt = $appointment->reviewed_at->copy();

        Notification::fake();

        $this
            ->actingAs($reviewer)
            ->patch(route('admin.appointments.decision', $appointment), [
                'status' => Appointment::STATUS_REJECTED,
                'rejection_reason' => 'A second decision must not replace the first one.',
            ])
            ->assertSessionHasErrors('status');

        $appointment->refresh();

        $this->assertSame(Appointment::STATUS_APPROVED, $appointment->status);
        $this->assertTrue($appointment->appointment_at->equalTo($appointmentAt));
        $this->assertSame($reviewer->id, $appointment->reviewed_by);
        $this->assertTrue($appointment->reviewed_at->equalTo($firstReviewedAt));
        $this->assertNull($appointment->rejection_reason);
        Notification::assertNothingSent();
    }

    private function service(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'name' => 'General Consultation',
            'description' => 'A general medical consultation.',
            'duration_minutes' => 30,
            'fee' => 0,
            'status' => 'Active',
        ], $overrides));
    }

    private function publicPayload(Service $service, array $overrides = []): array
    {
        return array_merge([
            'client_name' => 'Mary Banda',
            'client_phone' => '+265 999 123 456',
            'client_email' => 'visitor@example.com',
            'service_id' => $service->id,
            'preferred_at' => now()->addDays(2)->setTime(9, 30)->toDateTimeString(),
            'request_message' => 'I would prefer a morning consultation.',
        ], $overrides);
    }

    private function pendingAppointment(Service $service, array $overrides = []): Appointment
    {
        return Appointment::create(array_merge([
            'client_name' => 'Mary Banda',
            'client_phone' => '+265 999 123 456',
            'client_email' => 'visitor@example.com',
            'service_id' => $service->id,
            'preferred_at' => now()->addDays(2)->setTime(9, 30),
            'request_message' => 'I would prefer a morning consultation.',
            'status' => Appointment::STATUS_PENDING,
        ], $overrides));
    }

    private function staffWithPermission(string $permissionName): User
    {
        $staff = User::factory()->create();
        $staff->givePermissionTo(Permission::findOrCreate($permissionName));

        return $staff;
    }

    private function routesTo(AnonymousNotifiable $notifiable, string $email): bool
    {
        $route = $notifiable->routeNotificationFor('mail');

        if (is_array($route)) {
            return array_key_exists($email, $route) || in_array($email, $route, true);
        }

        return $route === $email;
    }
}
