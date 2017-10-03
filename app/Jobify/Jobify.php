<?php
namespace App\Jobify;
use Illuminate\Support\Facades\Cache;
use App\Jobify\ServiceProvider;
use App\Jobify\Webhook\Messaging;
use App\Jobify\User;
use App\Jobify\Facebook\QuickReplyTemplate;
use App\Jobify\Facebook\QuickReplyElement;
use App\Jobify\Facebook\ButtonTemplate;
use App\Jobify\Facebook\ButtonElement;
use App\Jobify\Facebook\GenericTemplate;
use App\Jobify\Facebook\GenericElement;


/*
    @Models
*/
use App\BotTempStorage as TSTORAGE;
use App\Job_Cancelled as CJOB;
use App\Works;
use App\Status;
use App\Jobs;
use App\Job_Address as JADDRESS;

use Carbon\Carbon;

class Jobify{
     
     
    
    public  $GET_STARTED      = "@start";
    public  $CANCEL           = "@cancellation";
    public  $INQUIRE          = "@job_inquire";
    public  $ERROR            = "I'm sorry but I can't do what you want me to do :'(";
    private $user;
    private $messaging;
    private $serviceProvider;
    
    public function __construct(Messaging $messaging){
        $this->messaging = $messaging;
        $this->serviceProvider = new ServiceProvider();
        
    }   
    public function user(){
        $user = $this->serviceProvider->getUser($this->messaging->getSenderId());
        $this->user = new User($this->messaging->getSenderId(), $user['first_name'], $user['last_name']);
    }
    public function start(){
        $this->user();
        return "Hi ".$this->user->getFirstName()."! I'm Jobify, I can help you to cancel your Job transactions. Just follow my instructions and you will be good to go!";
    }
    
    public function cancelButton(){
        $buttons[] = ButtonElement::title('Job Inquiry')->type('postback')->payload('@job_inquire')->toArray();
        $buttons[] = ButtonElement::title('Job Cancellation')->type('postback')->payload('@cancellation')->toArray();
        $response = ButtonTemplate::toArray("Choose the options below:", $buttons);
        return $response;
    }
    
    public function inquire(){
        $quickReplies[] = QuickReplyElement::title('My Job Status')->contentType('text')->payload('inquire@job_status');
        $quickReplies[] = QuickReplyElement::title('New Jobs Posted')->contentType('text')->payload('inquire@job_posted');
        $quickReplies[] = QuickReplyElement::title('Search by Location')->contentType('text')->payload('inquire@job_location');

        return QuickReplyTemplate::toArray('Select options for inquires:', $quickReplies);
    }
    
    
    public function askJobsLocation(){
        return "Enter Jobs Location:";
    }
    public function askJobId(){
        return "Enter your Job ID:";
    }
    
    public function askUserId($value){
        $this->tempSave("job_id", $value);
        return "Enter your User ID:";
    }
    
    public function askReason($value){
        $this->tempSave("user_id", $value);
        return "Enter your Reason:";
    }
    
    public function endConversation($value){
        $this->tempSave("reason", $value);
    }
    
    public function saveTempForQR($tracker){
        $tempStorage = new TSTORAGE();
        $tempStorage->tracker = $tracker;
        $tempStorage->facebook_id = $this->messaging->getSenderId();
        $tempStorage->save();
    }
    
    public function jobStatus($value){
        $tempStorage = new TSTORAGE();
        $data = array("user_id" => $value);
        $facebookId = $this->messaging->getSenderId();
        $tempStorage->where('facebook_id', $facebookId)->update($data);
        
        
        $jobId = null;
        $userId = null;
        
        $fields = TSTORAGE::where("facebook_id", $facebookId)->orderBy('created_at')
                    ->limit(1)->get();
            
        if($fields){
            foreach($fields as $field){
                $jobId  = $field['job_id'];
                $userId = $field['user_id'];
            }
             
            $result = $this->workStatus($jobId, $userId);
            $this->deleteTempStorage($facebookId, $jobId, $userId);  
            return ($result == null)? "Work not Found!": "Your Work Status: ".$result;
        }
        else{
            return "Job ID:".$jobId." with User ID: ".$userId." was was not found!";
        }
        
    }
    
    public function tempSave($field, $value){
        $tempStorage = new TSTORAGE();
        $sender = $this->messaging->getSenderId();
        $pageId = '1901675456825024';
        if($field == "job_id" && $sender != $pageId){
            $data = array("job_id" => $value);
            $tempStorage->where('facebook_id', $this->messaging->getSenderId())->update($data);
        }
        else if($field == "user_id" && $sender != $pageId){
            $data = array("user_id" => $value);
            $tempStorage->where('facebook_id', $this->messaging->getSenderId())->update($data);
        }
        else if($field == "reason" && $sender != $pageId){
            $data = array("reason" => $value);
            $tempStorage->where('facebook_id', $this->messaging->getSenderId())->update($data);
        }
        
    }
    
    public function cancelThisJob(){
        $facebookId = $this->messaging->getSenderId();
        $jobId = null;
        $userId = null;
        $reason = null;
        
        $fields = TSTORAGE::where("facebook_id", $facebookId)->orderBy('created_at','asc')
                    ->limit(1)->get();
                    
        if($fields){
            foreach($fields as $field){
                $jobId  = $field['job_id'];
                $userId = $field['user_id'];
                $reason = $field['reason'];
            }
        }
        $this->deleteTempStorage($facebookId, $jobId, $userId);
        $result =  $this->deleteWork($jobId, $userId);
        if($result == '1'){
            $cJob = new CJOB();
            $cJob->job_id = $jobId;
            $cJob->user_id = $userId;
            $cJob->reason = $reason;
            $cJob->save();
            return "Job ID:".$jobId." with User ID: ".$userId." was successfully cancelled!";
        }
        else{
            return "Job ID:".$jobId." with User ID: ".$userId." was not found!";
        }
    }
    
    public function deleteWork($jobId, $userId){
        $work = new Works();
        $condition = array(
            "job_id"    => $jobId,
            "user_id"   => $userId
        );
        $result = $work
        ->where("job_id","=",$jobId)
        ->where("user_id","=",$userId)
        ->delete();
        return $result;
    }
    
    public function workStatus($jobId, $userId){
        $work = Works::select('status')
                      ->where("job_id",'=', $jobId)
                      ->where('user_id','=', $userId)
                      ->limit(1)
                      ->get();
        $status = null;
        if($work){
            $intStatus = null;
            foreach($work as $row){
                $intStatus = $row['status'];
            }
            
            $workStatus = Status::select('name')
                            ->where("status_id", '=', $intStatus)
                            ->get();
            if($workStatus){
                foreach($workStatus as $row){
                    $status = $row['name'];
                }  
            }
        }
        return $status;
    }
    
    public function deleteTempStorage($facebookId, $jobId, $userId){
           $tempStorage = new TSTORAGE();
           $result = $tempStorage
           ->where("facebook_id","=",$facebookId)
           ->where("job_id","=",$jobId)
           ->where("user_id","=",$userId)
           ->delete();
    }
    
    public function updateTracker($facebookId, $tracker){
         $tempStorage = new TSTORAGE();
         $data = array("tracker" => $tracker);
         $tempStorage->where('facebook_id', $this->messaging->getSenderId())->update($data);
    }
    
    public function newJobs(){
         $jobs =  Jobs::orderBy('date_posted',"asc")->limit(10)->get();
         return $this->manageJobsResult($jobs);
    }

    public function search($value){
        $result = JADDRESS::where('locality', 'like', '%'.$value.'%')->limit(1)->get();
        $tempStorage = new TSTORAGE();
        $data = array("custom_field" => $value, 'deleted_at' => Carbon::now());
        $tempStorage->where('facebook_id', $this->messaging->getSenderId())->update($data);
        if($result){
            $address_id = null;
            foreach($result as $row){
                $address_id = $row['id'];
            }
            $jobs = Jobs::where('address_id', '=',$address_id)->orderBy('date_posted',"asc")->limit(10)->get();
            return $this->manageJobsResult($jobs);
        }
        else{
            return ["text" => "No Jobs found in this location! :'( "];
        }
    }
    
    public function manageJobsResult($jobs){
         $imgUrl = "http://www.gocentralph.com/gcssc/wp-content/uploads/2017/04/Services.png";
         $buttonUrl = "https://jobplus1-cloned-mikent13.c9users.io";
         $buttons = [];
         $elements = [];
         $response = null;
         if($jobs){
             foreach($jobs as $job){
                $buttons[] = ButtonElement::title("Apply Now!")
                            ->type('web_url')
                            ->url($buttonUrl)
                            ->toArray();
                $elements[] = GenericElement::title($job['title']." for Php ".$job['salary'].".00")
                        ->imageUrl($imgUrl)
                        ->subtitle($job['description'])
                        ->buttons($buttons)
                        ->toArray();
                $buttons = null;
             }
            
             $response =  GenericTemplate::toArray($elements);
         }
         else{
             $response =  ["text" => "No Jobs Posted!"];
         }
         return $response;
    }

}