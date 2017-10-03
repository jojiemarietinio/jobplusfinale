<?php

namespace App\Jobs;

use App\Jobify\Bot;
use App\Jobify\Jobify;
use App\Jobify\Webhook\Messaging;
use App\Jobify\Conversation\Cancellation;


use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\BotTempStorage as TSTORAGE;

class BotHandler extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
     protected $messaging;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
     
    public function handle()
    {
        $bot = new Bot($this->messaging);
        $jobify = new Jobify($this->messaging);
        $custom = $bot->extractData();
        if($custom['type'] == "postback"){
            list($priority, $category) = explode('@', $custom['payload']);
            if($custom['payload'] == $jobify->GET_STARTED){
                $bot->reply($jobify->start(), true);
                $bot->reply($jobify->cancelButton(), false);
            }
            else if($custom['payload'] == $jobify->CANCEL){
                $jobify->saveTempForQR(1);
                $bot->reply($jobify->askJobId(), true);
            }
            else if($custom['payload'] == $jobify->INQUIRE){
                $bot->reply($jobify->inquire(), false);
            }
            else{
                $bot->reply($jobify->ERROR, true);
            }
        }
        else if($custom['type'] == "message"){
            if($custom['quick_reply']){
                $this->quickReply($custom, $bot, $jobify);
            }
            else if($custom['attachments']){
                //            
            }
            else{
                $this->conversation($custom, $bot, $jobify);
            }

        }
        else{
             $bot->reply($jobify->askUserId($custom['text']), true);
        }
                
    }
        
    public function conversation($custom, Bot $bot, Jobify $jobify){
        $facebookId = $this->messaging->getSenderId();
        $temp = TSTORAGE::where("facebook_id", $facebookId)->limit(1)->get();
        $tracker = 0;
        $fb = null;
        if($temp){
            foreach($temp as $field){
                $tracker = $field['tracker'];
            }
            switch($tracker){
                case 1: 
                    $bot->reply($jobify->askUserId($custom['text']), true);
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    break;
                case 2: 
                    $bot->reply($jobify->askReason($custom['text']), true);
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    break;
                case 3:
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    $jobify->endConversation($custom['text']);
                    $bot->reply($jobify->cancelThisJob(), true);
                    break;
                case 10: 
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    $bot->reply($jobify->askUserId($custom['text']), true);
                    break;
                case 11:
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    $bot->reply($jobify->jobStatus($custom['text']), true);
                    break;
                case 20:
                    $tracker++;
                    $jobify->updateTracker($facebookId, $tracker);
                    $bot->reply($jobify->search($custom['text']), false);
            }
        }
    
    }
    
    public function quickReply($custom, Bot $bot, Jobify $jobify){
        $postback = $custom['quick_reply']['payload'];
        if($postback == "inquire@job_status"){
          $jobify->saveTempForQR(10);
          $bot->reply($jobify->askJobId(), true);
        }
        else if($postback == "inquire@job_posted"){
          $bot->reply($jobify->newJobs(), false);
        }
        else if($postback == "inquire@job_location"){
            $jobify->saveTempForQR(20);
            $bot->reply($jobify->askJobsLocation(), true);
        }
        else{
    
        }
    }
}