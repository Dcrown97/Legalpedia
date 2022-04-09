<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewBankSubscriber extends Notification
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
                    ->subject('Purchase Successful')
                    ->line('Hi, '. $this->user->name)
                    ->line('You have just purchased '. $this->transaction_message->package . ' Legalpedia package')
                    ->line('To confirm your payment and activate your package, send a receipt of payment issued from your bank to legalpediaonline@gmail.com alongside your payment reference ID')
                    ->line('Your purchase details are below')
                    ->line('Payment reference ID: '. $this->transaction_message->reference)
                    ->line('Subscribed Package: '. $this->transaction_message->package)
                    ->line('Amount to pay: ₦'. number_format($this->transaction_message->amount, 2))
                    ->line('Purchase date: '. Carbon::parse($this->transaction_message->created_at)->toFormattedDateString())
                    ->line('Name: '. $this->transaction_message->name)
                    ->line('Email: '. $this->transaction_message->email)
                    ->line('Haven\'t made payment yet? Make your payment to Legalpedia account details below')
                    ->line('Account Number: 0223904739')
                    ->line('Account Name: Akpan Emmanuel')
                    ->line('Bank: GTBANK')
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
