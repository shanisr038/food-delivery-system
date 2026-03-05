<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class RestaurantStaffInvitation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $restaurantName)
    {
        // Property promotion handles the assignment
    }

    /**
     * Get the notification's delivery channels.
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
            ->subject(__("You have been invited to join :restaurant staff", [
                'restaurant' => $this->restaurantName,
            ]))
            ->markdown('mail.restaurant.staff-invitation', [
                'setUrl'        => $this->resetUrl($notifiable),
                'restaurant'    => $this->restaurantName,
                'requestNewUrl' => route('password.request'),
            ]);
    }

    /**
     * Generate the password reset/set URL.
     */
    protected function resetUrl($notifiable)
    {
        return url(route('password.reset', [
            'token' => Password::createToken($notifiable),
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}