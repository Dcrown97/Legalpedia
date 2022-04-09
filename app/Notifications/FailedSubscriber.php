<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FailedSubscriber extends Notification
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
                    ->subject('Transaction Failed')
                    ->line('Hi, '. $this->user->name)
                    ->line('Sorry your payment could not be verified, please contact support at support@legalpediaresources.com')
                    ->line('Package: '. $this->transaction_message->package)
                    ->line('Amount: ₦'. number_format($this->transaction_message->amount, 2))
                    ->line('Payment Reference ID'. $this->transaction_message->reference)
                    ->action('Sign in', url('admin/dashboard'));
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
