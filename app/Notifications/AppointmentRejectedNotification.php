<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use LogicException;

class AppointmentRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $reference;

    public string $clientName;

    public string $serviceName;

    public string $rejectionReason;

    public function __construct(Appointment $appointment)
    {
        $appointment->loadMissing('service');

        $rejectionReason = trim((string) $appointment->rejection_reason);

        if ($rejectionReason === '') {
            throw new LogicException('A rejected appointment must have a rejection reason.');
        }

        $this->reference = sprintf('GHPC-%06d', (int) $appointment->getKey());
        $this->clientName = trim((string) $appointment->client_name);
        $this->serviceName = $appointment->service?->name ?? 'the requested service';
        $this->rejectionReason = $rejectionReason;

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
            ->subject('Update on your appointment request '.$this->reference)
            ->greeting('Hello '.$name.',')
            ->line('Thank you for giving us the opportunity to review your appointment request.')
            ->line('We are sorry that we are unable to approve this request at this time.')
            ->line('Reference: '.$this->reference)
            ->line('Service: '.$this->serviceName)
            ->line('Reason: '.$this->rejectionReason)
            ->line('You are very welcome to submit another request for a different time or contact the clinic so our team can discuss other options with you.')
            ->salutation('Warm regards, '.config('app.name'));
    }
}
