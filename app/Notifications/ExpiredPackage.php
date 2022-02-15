<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiredPackage extends Notification
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
                    ->subject('Expired Package')
                    ->line('Hi '. $notifiable->name .', sorry your Legalpedia package '. $this->package->name .' has now expired and you no longer have access to Legalpedia resources.')
                    ->line('To regain access to the resources, please renew your subscription package. Click the button below to renew')
                    ->line('Package: '. $this->package->name)
                    ->line('Price: ₦'. number_format($this->package->price))
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
