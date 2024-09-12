<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TesttingNotificationMail extends Notification implements ShouldQueue
{
    use Queueable;
    private $bill;
    private $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($bill, $user)
    {
        $this->bill = $bill;
        $this->user = $user;
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
            ->subject('Thank You For Your Purchase!')
            ->line('You just have ordered in SellphoneS Shop.')
            ->line('Date order: ' . $this->bill->created_at)
            ->line('Order Price: ' . $this->bill->total)
            ->line('Phone Number: ' . $this->user->phone_number)
            ->line('Address Receive: ' . $this->user->address)
            ->action('View Order', url('/auth/dashboard'))
            ->line('Thank you for using our service!');
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
