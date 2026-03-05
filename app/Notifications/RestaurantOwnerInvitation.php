<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class RestaurantOwnerInvitation extends Notification
{
    use Queueable;

    public function __construct(public string $restaurantName)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // This generates a secure temporary link for the user to set their password
        $url = route('password.reset', [
            'token' => Password::createToken($notifiable),
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject("Invitation to manage {$this->restaurantName}")
            ->line("An account has been created for you to manage the restaurant: {$this->restaurantName}.")
            ->line("Since this is a new account, you need to set your own password.")
            ->action('Set Your Password', $url)
            ->line('If you did not expect this invitation, no further action is required.');
    }
}