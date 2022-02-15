<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FirstRenewalNotice extends Notification
{
    use Queueable;
    protected $user, $package;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $package)
    {
        $this->user = $user;
        $this->package = $package;
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
                        ->subject('Package Renewal Notice')
                        ->line('Hi '. $notifiable->name .' Your Legalpedia package '. $this->package->name .' will expire in 14 days. To renew your subscription package with uninterrupted access to Legalpedia resources, Click the button below')
                        ->line('Package: '. $this->package->name)
                        ->line('Price: ₦'. number_format($this->package->amount))
                        ->action('Renew Package', url('/admin/pricing'));
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
