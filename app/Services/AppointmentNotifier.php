<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentApprovedNotification;
use App\Notifications\AppointmentRejectedNotification;
use App\Notifications\AppointmentRequestPendingNotification;
use App\Notifications\NewAppointmentRequestNotification;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Notification;
use LogicException;

class AppointmentNotifier
{
    /**
     * Notify clinic staff and acknowledge a newly received request.
     */
    public function requestReceived(Appointment $appointment): void
    {
        $appointment->loadMissing('service');

        $staff = User::query()
            ->where('status', 'Active')
            ->whereNotNull('email')
            ->whereRaw("TRIM(email) <> ''")
            ->get();

        if ($staff->isNotEmpty()) {
            Notification::send(
                $staff,
                new NewAppointmentRequestNotification($appointment),
            );
        }

        $this->notifyRequester(
            $appointment,
            new AppointmentRequestPendingNotification($appointment),
        );
    }

    /**
     * Notify the requester about the recorded appointment decision.
     */
    public function decisionMade(Appointment $appointment): void
    {
        $appointment->loadMissing('service');

        $notification = match ($appointment->status) {
            Appointment::STATUS_APPROVED => new AppointmentApprovedNotification($appointment),
            Appointment::STATUS_REJECTED => new AppointmentRejectedNotification($appointment),
            default => throw new LogicException('Only approved or rejected appointments can trigger a decision notification.'),
        };

        $this->notifyRequester($appointment, $notification);
    }

    private function notifyRequester(Appointment $appointment, BaseNotification $notification): void
    {
        $email = trim((string) $appointment->client_email);

        if ($email === '') {
            return;
        }

        $name = trim((string) $appointment->client_name);

        Notification::route('mail', [
            $email => $name !== '' ? $name : 'Clinic visitor',
        ])->notify($notification);
    }
}
