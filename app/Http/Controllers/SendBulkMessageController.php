<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\User;
use App\Models\Message;
use App\Models\MailMessage;
use Illuminate\Http\Request;
use App\Jobs\SendBulkQueueEmail;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendBulkMessageController extends Controller
{

    public function sendBulk(Request $request) {
        $message = MailMessage::orderBy('created_at', 'DESC')->first();
        $subject = json_decode($message->content);
        $body = json_decode($message->content);
        $users = json_decode($message->users);

        $details = [
            'subject' => $subject[1],
            'body' => $body[2]
        ];

        // send all mail in the queue.
        $job = (new SendBulkQueueEmail($details, $users))
            ->delay(
                now()
                ->addSeconds(1)
            );
        $job_count = DB::table('jobs')->count();
        if($job_count < 1) {
            dispatch($job);
            // $get_job = DB::table('jobs')->first();
            // $get_job->attempts = 1;
            // $get_job->reserved_at = $get_job->available_at + 1;
            // DB::table('jobs')->where('attempts', 0)->update(['attempts' => 1, 'reserved_at' => $get_job->reserved_at]);
        }

        // echo "Bulk mail send successfully in the background...";

        return view('messageSent');

    }
}
