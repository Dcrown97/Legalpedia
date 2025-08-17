<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AiBankSubSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mainContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mainContent)
    {
        $this->mainContent = $mainContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription Successful!')
            ->view('emails.aibanksub_success')
            ->with([
                'mainContent' => $this->mainContent
            ]);
    }
}
