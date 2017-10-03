<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job_Cancelled as CJOB;
use App\Works;
use App\Profiles;
use App\Status;
use App\Jobs;
use App\Job_Address as JADDRESS;
use App\Jobs\SendChikka;

class ChikkaSmsController extends Controller
{
    
    /**
     * [__construct description]
     * @param [type] $clientId  [description]
     * @param [type] $secretKey [description]
     * @param [type] $shortCode [description]
     */
 
   
    private $clientId = 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0';
    private $secretKey = 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612';
    private $shortCode = '292902017';
    private $sslVerify = false;
    
    //Chikka's default URI for sending SMS
    private $chikkaSendUrl = 'https://post.chikka.com/smsapi/request';
    //Based from Chikka's price breakdown
    
    protected $receiveData;

    protected $message;

    protected $flag;
    
    public function send($recipientNumber, $message){
        /*
            1. Configure data
            2. Send
            3. Verify confirmation
        */
        $messageId = $this->generateCode35(32);
        $sendData = array(
            'message_type'      => "SEND",
            'mobile_number'     => $recipientNumber,
            'shortcode'         => $this->shortCode,
            'message_id'        => $messageId,
            'message'           => $message
            );
        
        $result = $this->sendApiRequest($sendData);
        /*
            1. Validate Response
            status, message, request_type = SEND
        */
    }
    public function receive(Request $request) {
        $flag = false;
        $data = $request->all();
        if($data){
            //echo json_encode($data);
            $this->receiveData = $data;
            $this->extractMessage($data['message'], $data['mobile_number']);
            if($this->flag == false){
                $result = $this->reply($data, $this->message);
                if($result->status == 400 || $result->status == '400')
                    $this->send($data['mobile_number'], $this->message);
            }
            return "Accepted";
        }else{
            return "Error";
        }
 
    }
    
    public function notify(Request $request){
        $data = $request->all();
        echo json_encode($data);
    }
    
    public function reply($receiveData, $message){
         $messageId = $this->generateCode35(32);
         $sendData = array(
            'message_type'      => "REPLY",
            'mobile_number'     => $receiveData['mobile_number'],
            'shortcode'         => $this->shortCode,
            'request_id'        => $receiveData['request_id'],
            'message_id'        => $messageId,
            'message'           => $message,
            'request_cost'      => 'FREE'
            );
        //echo json_encode($sendData);
        $result = $this->sendApiRequest($sendData);

        echo json_encode($result);
        return $result;
    }
    
    /**
     * Reply - ability to send reply message  
     *
     * @param [String] [requestID] [The requestID supplied by Chikka SMS]
     * @param [String] [messageID] [Unique identifier]
     * @param [String] [to] [mobile number starint 63]
     * @param [String] [cost] [Amount to charge: Free, 1, 2.50, 5, 10, 15]
     * @param [String] [message] [UTF-8 string]
     */
    public function generateCode35($length){
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, $length);
    }
    

    public function testExtract(Request $request){
         $data = $request->all();
         $this->extractMessage($data['message'], $data['mobile_number']);
    }
    public function extractMessage($message, $contactNumber){
        $message = explode(', ', $message);
        $userId = $this->getUserId($contactNumber);
        /*
            1. Create Code Arrangement
            2. Set Priorities
            3. Manage Message
        */
        $data = array();
        switch (strtolower($message[0])) {
            //Reschedule
            //Ratings
            case 'cancel':
                # code...
                if(sizeof($message) == 3){
                    $data = array(
                        "action"    => $message[0],
                        "job_id"    => $message[1],
                        "reason"    => $message[2],
                        "mobile_number" => $contactNumber
                    );
                    $this->cancel($data, $userId);
                }
                else{
                    $this->message =  'Format for Job Cancellation: cancel, job_id, reason';
                }
                break;
            case 'job_status':
                # code...
                if(sizeof($message) == 2){
                    $data = array(
                        "action"    => $message[0],
                        "job_id"    => $message[1],
                        "mobile_number" => $contactNumber
                    );   
                    $this->status($data, $userId);
                }
                else{
                    $this->message = 'Format for Check Job Status: status, job_id';
                }
                break;
            case 'posted':
                # code...
                if(sizeof($message) == 2){
                    $data = array(
                        "action"    => $message[0],
                        "location"    => $message[1],
                        "mobile_number" => $contactNumber
                    );   
                    $this->search($data);
                }
                else{
                    $this->message = 'Format for Checking Job Posted: posted, location';
                }
                break;
            default:
                $this->message = 'Format for Checking Job Posted: posted, location';
            break;
        }
    }

    public function cancel($data, $userId){
        $result = $this->deleteWork($data['job_id'], $userId);
        $response = '';
        if($result == '1'){
            $cJob = new CJOB();
            $cJob->job_id = $data['job_id'];
            $cJob->user_id = $userId;
            $cJob->reason = $data['reason'];
            $cJob->save();
            $response =  "Job ID:".$data['job_id']." with User ID: ".$userId." was successfully cancelled!";
            $this->notifyEmployer($data['job_id'], $userId);
        }
        else{
            $response = "Job ID:".$data['job_id']." with User ID: ".$userId." was not found!";
        }
        $this->message = $response;
    }
    
    public function notifyEmployer($jobId, $userId){
        $cJob = new CJOB();
        
        $result = $cJob->where('job_id', '=', $jobId)->get();
        
        if(sizeof($result) > 0){
            $employerNumber = $this->getProfileNumber($result[0]['user_id']);
            $message =  "The Job ID: ".$jobId." was cancelled by ".$this->getUserCompleteName($userId).'.'.PHP_EOL;
            $this->send($employerNumber, $message);
        }
    }
    
    public function getProfileNumber($userId){
        $profile = new Profiles();
        $result = $profile->where('user_id', $userId)->get();

        if(sizeof($result) > 0){
            return $result[0]['mobile'];
        }
        else
            return null;
    }

    public function status($data, $userId){
        $work = Works::select('status')
                      ->where("job_id",'=', $data['job_id'])
                      ->where('user_id','=', $userId)
                      ->limit(1)
                      ->get();
        $status = null;
        if(sizeof($work) > 0){
            if($work[0]['status'] > 0){
                $workStatus = Status::select('name')
                          ->where("status_id", '=', $work[0]['status'])
                          ->get();
                $status = 'The Status of Job ID:'.$data['job_id'].' with User ID:'.$userId.' is '.$workStatus[0]['name'];
            }
        }
        else{
            $status = "Job not found!";
        }
        $this->message = $status;
    }

    public function deleteWork($jobId, $userId){
        $work = new Works();
        $result = $work
        ->where("job_id","=",$jobId)
        ->where("user_id","=",$userId)
        ->delete();
        return $result;
    }

    public function getUserId($contactNumber){
        $profile = new Profiles();
        $result = $profile->where('mobile', $contactNumber)->get();

        if(sizeof($result) > 0){
            return $result[0]['user_id'];
        }
        else
            return null;
    }
    
    public function getUserCompleteName($userId){
        $profile = new Profiles();
        $result = $profile->where('user_id', $userId)->get();

        if(sizeof($result) > 0){
            return $result[0]['lname'].', '.$result[0]['fname'];
        }
        else
            return null;
    }

    public function search($data){
        $result = JADDRESS::where('locality', 'like', '%'.$data['location'].'%')->limit(1)->get();
        
        if(sizeof($result) > 0){
            $jobs = Jobs::select('title','description','start_date','end_date','salary')
            ->where('address_id', '=',$result[0]['id'])
            ->orderBy('date_posted',"asc")
            ->limit(10)
            ->get();
            $this->sendMultiple($jobs);
            
        }
        else{
            $this->message = "No Jobs found in this location.".PHP_EOL;
        }
    }

    public function sendMultiple($jobs){
        $i = 0;
        $this->flag = true;
        if(sizeof($jobs) >= 1){
            dispatch(new SendChikka($this->receiveData,$jobs));
        }
    }
    public function receiveNotifications() {
        $fromChikka = $_POST;
        
        if (count(array_diff_key($this->expectedChikkaResponse, $fromChikka)) != 0) {
            $fromChikka = null;
        }
        return $fromChikka;
    }
    /**
     * sendApiRequest - the functionality that sends request to Chikka API endpoint
     * @param  [array] $data post params 
     * @return [object]       
     */
    private function sendApiRequest($data){
        $data = array_merge($data, array('client_id'=>$this->clientId, 'secret_key' => $this->secretKey));
        //  build a request query from arrays of data 
        $post = http_build_query($data);
        // If available, use CURL
        if (function_exists('curl_version')) {
            $to_chikka = curl_init( $this->chikkaSendUrl );
            curl_setopt( $to_chikka, CURLOPT_POST, true );
            curl_setopt( $to_chikka, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $to_chikka, CURLOPT_POSTFIELDS, $post );
            if (!$this->sslVerify) {
                curl_setopt( $to_chikka, CURLOPT_SSL_VERIFYPEER, false);
            }
            $from_chikka = curl_exec( $to_chikka );
            curl_close ( $to_chikka );
        } elseif (ini_get('allow_url_fopen')) {
            // No CURL available so try the awesome file_get_contents
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $post
                )
            );
            $context = stream_context_create($opts);
            $from_chikka = file_get_contents($this->chikkaSendUrl, false, $context);
        } else {
            // No way of sending a HTTP post :(
            return false;
        }
        return $this->parseApiResponse($from_chikka, $data['message_type']);
    }
    /**
     * parseApiResponse - process and handle Chikka api responses
     * @param  [array] $response    Response from Chikka API
     * @param  [string] $requestType This is the message type of the sms 
     * @return [type]              
     */
    private function parseApiResponse($response, $requestType = null){
        $response = json_decode($response,true);
        if($requestType){
            $response['request_type'] = $requestType;
        }
        
        return json_decode(json_encode($response));;
    }
}
