<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AiPaystackSubSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $package_name;
    public $package_price;
    public $billing_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $package_name, $package_price, $billing_type)
    {
        $this->user = $user;
        $this->package_name = $package_name;
        $this->package_price = $package_price;
        $this->billing_type = $billing_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription Successful!')
            ->view('emails.aipaystacksub_success');
    }
}
