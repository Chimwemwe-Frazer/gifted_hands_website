<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AppointmentsController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly AppointmentNotifier $notifier,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:list appointments', only: ['index', 'show']),
            new Middleware('permission:add appointment', only: ['create', 'store']),
            new Middleware('permission:update appointment', only: ['edit', 'update', 'decision']),
            new Middleware('permission:delete appointment', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $requestedStatus = $request->string('status')->toString();
        $activeStatus = in_array($requestedStatus, Appointment::STATUSES, true)
            ? $requestedStatus
            : null;

        $statusCounts = array_fill_keys(Appointment::STATUSES, 0);

        Appointment::query()
            ->whereIn('status', Appointment::STATUSES)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->each(function (int $count, string $status) use (&$statusCounts): void {
                $statusCounts[$status] = $count;
            });

        $statusCounts = ['All' => Appointment::count()] + $statusCounts;

        $appointments = Appointment::with(['service', 'practitioner', 'reviewedBy'])
            ->when($activeStatus, fn ($query) => $query->where('status', $activeStatus))
            ->orderByRaw('CASE WHEN status = ? THEN 0 ELSE 1 END', [Appointment::STATUS_PENDING])
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('backend.appointments.index', compact(
            'appointments',
            'statusCounts',
            'activeStatus',
        ));
    }

    public function create(): View
    {
        return view('backend.appointments.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $appointment = Appointment::create(
            $this->validatedData($request, creating: true) + [
                'status' => Appointment::STATUS_PENDING,
            ]
        );

        $this->notifier->requestReceived($appointment);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'The appointment request was saved as pending and the email notifications were queued.');
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['service', 'practitioner', 'reviewedBy']);

        return view('backend.appointments.show', [
            'appointment' => $appointment,
            'practitioners' => User::query()
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function edit(Appointment $appointment): View
    {
        return view('backend.appointments.create', $this->formData() + compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($this->validatedData($request));

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'The appointment request details were successfully updated.');
    }

    public function decision(Request $request, Appointment $appointment): RedirectResponse
    {
        if (! $appointment->client_email) {
            throw ValidationException::withMessages([
                'client_email' => 'Add the requester’s email address before making a decision so they can be notified.',
            ]);
        }

        $requestedStatus = $request->string('status')->toString();

        $data = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    Appointment::STATUS_APPROVED,
                    Appointment::STATUS_REJECTED,
                ]),
            ],
            'appointment_at' => [
                Rule::excludeIf($requestedStatus !== Appointment::STATUS_APPROVED),
                'required',
                'date',
                'after:now',
            ],
            'practitioner_id' => [
                Rule::excludeIf($requestedStatus !== Appointment::STATUS_APPROVED),
                'nullable',
                Rule::exists('users', 'id')->where('status', 'Active'),
            ],
            'rejection_reason' => [
                Rule::excludeIf($requestedStatus !== Appointment::STATUS_REJECTED),
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $appointment = DB::transaction(function () use ($appointment, $data, $request): Appointment {
            $lockedAppointment = Appointment::query()
                ->lockForUpdate()
                ->findOrFail($appointment->getKey());

            if ($lockedAppointment->status !== Appointment::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'status' => 'This appointment request has already been reviewed and cannot be decided again.',
                ]);
            }

            $lockedAppointment->fill([
                'status' => $data['status'],
                'appointment_at' => $data['status'] === Appointment::STATUS_APPROVED
                    ? $data['appointment_at']
                    : null,
                'practitioner_id' => $data['status'] === Appointment::STATUS_APPROVED
                    ? ($data['practitioner_id'] ?? null)
                    : null,
                'rejection_reason' => $data['status'] === Appointment::STATUS_REJECTED
                    ? $data['rejection_reason']
                    : null,
                'reviewed_by' => $request->user()->getKey(),
                'reviewed_at' => now(),
            ])->save();

            return $lockedAppointment->load(['service', 'practitioner', 'reviewedBy']);
        });

        $this->notifier->decisionMade($appointment);

        $message = $appointment->status === Appointment::STATUS_APPROVED
            ? 'The appointment was approved and the confirmed date and time were emailed to the requester.'
            : 'The request was declined and a polite response with the reason was emailed to the requester.';

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', $message);
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment successfully deleted');
    }

    private function formData(): array
    {
        return [
            'services' => Service::active()->orderBy('name')->get(),
            'practitioners' => User::query()
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(),
        ];
    }

    private function validatedData(Request $request, bool $creating = false): array
    {
        return $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:50'],
            'client_email' => ['required', 'email', 'max:255'],
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where('status', 'Active'),
            ],
            'practitioner_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('status', 'Active'),
            ],
            'preferred_at' => [
                'nullable',
                'date',
                ...($creating ? ['after:now'] : []),
            ],
            'request_message' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}
