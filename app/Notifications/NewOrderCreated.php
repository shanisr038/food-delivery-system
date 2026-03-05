<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
  public function __construct(public \App\Models\Order $order)
{
    // Using PHP 8.1+ property promotion to keep it clean
}

public function via(object $notifiable): array
{
    return ['mail'];
}

public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject("[{$this->order->restaurant->name}] New Order #{$this->order->id}")
        ->markdown('mail.order.new-order-created', [
            'order' => $this->order,
        ]);
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
