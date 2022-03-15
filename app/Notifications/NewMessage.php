<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;
    protected $message_sent, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message_sent, $user)
    {
        $this->message_sent = $message_sent;
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

        // return (new MailMessage)
        //             ->subject($this->message_sent->subject)
        //             ->line('Hi, '. $notifiable->name)
        //             ->line($this->message_sent->subject)
        //             ->line(strip_tags($this->message_sent->body))
        //             ->action('Get started', url('admin/dashboard'));

        return (new MailMessage)->view(
            'emails.newMessage', ['user'=> $notifiable->name, 'subject'=> $this->message_sent->subject, 'body' => $this->message_sent->body]
        )->subject($this->message_sent->subject);
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
