<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReport extends Notification
{
    use Queueable;
    protected $report_message, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($report_message, $user)
    {
        $this->report_message = $report_message;
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
                        ->subject('New Report')
                        ->line('Hi Admin, You have a new report from '. $this->user->name )
                        ->line('Name: '. $this->user->name)
                        ->line('Email: '. $this->user->email)
                        ->line('Report Type: '. $this->report_message->report_type)
                        ->line('Report Message: '. $this->report_message->report_message)
                        ->line($this->report_message->other_message);

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
