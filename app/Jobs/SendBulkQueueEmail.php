<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details, $users;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $users)
    {
        $this->details = $details;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = User::whereIn('email', $this->users)->get();
        $input['subject'] = $this->details['subject'];
        $input['body'] = $this->details['body'];

        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['name'] = $value->name;
            Mail::send('emails.newMessage', ['subject'=> $input['subject'], 'body' => $input['body'], 'user' => $input['name']], function($message) use($input){
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });
        }
        info(['bulk_email_dispatch_executed' => now()->toDayDateTimeString()]);
    }
}
