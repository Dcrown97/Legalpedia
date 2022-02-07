<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseCredentials extends Notification
{
    use Queueable;
    protected $license_creds, $license_user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($license_creds, $license_user)
    {
        $this->license_creds = $license_creds;
        $this->license_user = $license_user;
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
                        ->subject('License Credentials')
                        ->line('Hi '. $this->license_user->name .' You now have access to Legalpedia resources. Below are your License credentials to sign in')
                        ->line('Licensed Email: '. $this->license_user->email)
                        ->line('License Code: '. $this->license_creds->license_code)
                        ->action('Sign in', url('/login'));
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
