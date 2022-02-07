<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriber extends Notification
{
    use Queueable;
    protected $transaction_message, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction_message, $user)
    {
        $this->transaction_message = $transaction_message;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Subscriber')
                    ->line('Hi, '. $this->user->name)
                    ->line('You have subscribed to '. $this->transaction_message->package . 'Legalpedia package')
                    ->line('Amount: ₦'. number_format($this->transaction_message->amount, 2))
                    ->line('Package: '. $this->transaction_message->package)
                    ->line('You can now sign in and get access to Legalpedia resources')
                    ->action('sign in', url('admin/dashboard'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
