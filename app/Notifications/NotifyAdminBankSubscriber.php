<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyAdminBankSubscriber extends Notification
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
                    ->line('Hi, Admin')
                    ->line('This user '. $this->user->name . ' ' .$this->user->surname. ' has just subscribed to '. $this->transaction_message->package)
                    ->line('The payment method is Bank Transfer, please update this user\'s transaction status upon receival of valid payment receipt to activate user\'s package')
                    ->line('The transaction details are below')
                    ->line('Payment reference ID: '. $this->transaction_message->reference)
                    ->line('Subscribed Package: '. $this->transaction_message->package)
                    ->line('Amount to be paid: ₦'. number_format($this->transaction_message->amount, 2))
                    ->line('Purchase date: '. Carbon::parse($this->transaction_message->created_at)->toFormattedDateString())
                    ->line('Name: '. $this->transaction_message->name)
                    ->line('Email: '. $this->transaction_message->email)
                    ->action('Update transaction status', url('admin/transactions'));
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
