<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Log;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    private $message;
    private $subject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$subject,$message)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template =  $this->message;
        $return_message = "Message has been sent successfully";
        $username = "923078881628";///Your Username
        $password = "1385";///Your Password
        $sender = "SenderID";
         
        ////sending sms
         
        $post = "sender=".urlencode($sender)."&mobile=".urlencode($this->user->phone)."&message=".urlencode($template)."";
        $url = "https://sendpk.com/api/sms.php?username=".$username."&password=".$password."";
        $ch = curl_init();
        $timeout = 10; // set to zero for no timeout
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch); 
        // $body = sprintf($template, $this->user->name);
        // $data = Message::create(
        //     [
        //         'msg_from' => config('twilio.phone_number'),
        //         'msg_to' => $body
        //     ]
        // );
        Log::info("Queue is working...". $result);
    }
}
