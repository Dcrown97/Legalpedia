<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInvite extends Notification
{
    use Queueable;

    use Queueable;
    protected $notification_url, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification_url, $user)
    {
        $this->notification_url = $notification_url;
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
                    ->line('Hi there, ' . $this->user->name . ' is inviting you to join his team.')
                    ->action('Join Team', $this->notification_url)
                    ->line('Thank you for joining!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
