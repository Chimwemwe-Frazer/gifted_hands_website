<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $appointmentId;

    public string $reference;

    public string $clientName;

    public string $clientPhone;

    public string $clientEmail;

    public string $serviceName;

    public string $preferredAt;

    public function __construct(Appointment $appointment)
    {
        $appointment->loadMissing('service');

        $this->appointmentId = (int) $appointment->getKey();
        $this->reference = sprintf('GHPC-%06d', $this->appointmentId);
        $this->clientName = trim((string) $appointment->client_name);
        $this->clientPhone = trim((string) $appointment->client_phone);
        $this->clientEmail = trim((string) $appointment->client_email);
        $this->serviceName = $appointment->service?->name ?? 'Not specified';
        $this->preferredAt = $appointment->preferred_at
            ? $appointment->preferred_at
                ->copy()
                ->timezone((string) config('app.timezone'))
                ->format('l, j F Y \a\t g:i A T')
            : 'No preferred date or time provided';

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
        return (new MailMessage)
            ->subject('New appointment request '.$this->reference)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('A new appointment request has been received and is ready for review.')
            ->line('Reference: '.$this->reference)
            ->line('Requester: '.$this->clientName)
            ->line('Phone: '.($this->clientPhone !== '' ? $this->clientPhone : 'Not provided'))
            ->line('Email: '.($this->clientEmail !== '' ? $this->clientEmail : 'Not provided'))
            ->line('Service: '.$this->serviceName)
            ->line('Preferred time: '.$this->preferredAt)
            ->action('Review appointment request', route('admin.appointments.show', $this->appointmentId))
            ->line('Please review the request and record an approval or rejection as soon as practical.');
    }
}
