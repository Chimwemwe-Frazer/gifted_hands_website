<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentRequestPendingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $reference;

    public string $clientName;

    public string $serviceName;

    public string $preferredAt;

    public function __construct(Appointment $appointment)
    {
        $appointment->loadMissing('service');

        $this->reference = sprintf('GHPC-%06d', (int) $appointment->getKey());
        $this->clientName = trim((string) $appointment->client_name);
        $this->serviceName = $appointment->service?->name ?? 'the requested service';
        $this->preferredAt = $appointment->preferred_at
            ? $appointment->preferred_at
                ->copy()
                ->timezone((string) config('app.timezone'))
                ->format('l, j F Y \a\t g:i A T')
            : 'No preferred date or time was provided';

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
            ->subject('We received your appointment request '.$this->reference)
            ->greeting('Hello '.$name.',')
            ->line('Thank you for requesting an appointment with '.config('app.name').'.')
            ->line('Your request is pending while our reception team reviews availability.')
            ->line('Reference: '.$this->reference)
            ->line('Service: '.$this->serviceName)
            ->line('Preferred time: '.$this->preferredAt)
            ->line('We will email you again as soon as your request has been approved or rejected.')
            ->line('If your need is urgent, please contact the clinic directly.')
            ->salutation('Warm regards, '.config('app.name'));
    }
}
