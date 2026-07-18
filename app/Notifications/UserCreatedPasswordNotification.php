<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello!, '.$notifiable->name)
            ->line('You have been registered on '.config('app.name').' as a '.$notifiable->roles->first()?->name)
            ->line('Your email is: '.$notifiable->email)
            ->line('Your password is: '.$this->password)
            ->line('Please change your password after logging in')
            ->action('Login', route('login'))
            ->line('Thank you for using our application!');
    }
}
