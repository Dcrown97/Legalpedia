<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamRequest extends Notification
{
    use Queueable;
    protected $user_request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_request)
    {
        $this->user_request = $user_request;
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
                    ->subject('New team member')
                    ->line('Hi Team Admin, this user '. $this->user_request->email .' is requesting to join your Team')
                    ->action('Approve user', url('admin/teams/member/approve'));

        // return (new MailMessage)->view(
        //     'emails.welcomeOnboard', ['user'=> $this->user]
        // )->subject('Welcome to Legalpedia');
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
