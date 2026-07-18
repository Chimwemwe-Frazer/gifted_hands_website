<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use LogicException;

class AppointmentApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $reference;

    public string $clientName;

    public string $serviceName;

    public string $appointmentAt;

    public function __construct(Appointment $appointment)
    {
        $appointment->loadMissing('service');

        if (! $appointment->appointment_at) {
            throw new LogicException('An approved appointment must have an appointment date and time.');
        }

        $this->reference = sprintf('GHPC-%06d', (int) $appointment->getKey());
        $this->clientName = trim((string) $appointment->client_name);
        $this->serviceName = $appointment->service?->name ?? 'the requested service';
        $this->appointmentAt = $appointment->appointment_at
            ->copy()
            ->timezone((string) config('app.timezone'))
            ->format('l, j F Y \a\t g:i A T');

        $this->afterCommit();
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $name = $this->clientName !== '' ? $this->clientName : 'there';

        return (new MailMessage)
            ->subject('Your appointment request has been approved '.$this->reference)
            ->greeting('Hello '.$name.',')
            ->line('We are pleased to let you know that your appointment request has been approved.')
            ->line('Reference: '.$this->reference)
            ->line('Service: '.$this->serviceName)
            ->line('Confirmed appointment: '.$this->appointmentAt)
            ->line('Please arrive a little early and contact the clinic if you need help or can no longer attend at this time.')
            ->line('We look forward to welcoming you.')
            ->salutation('Warm regards, '.config('app.name'));
    }
}
