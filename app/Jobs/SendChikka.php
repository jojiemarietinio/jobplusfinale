<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendChikka extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $clientId = 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0';
    private $secretKey = 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612';
    private $shortCode = '292902017';
    private $sslVerify = false;
    
    //Chikka's default URI for sending SMS
    private $chikkaSendUrl = 'https://post.chikka.com/smsapi/request';
    protected $jobs;
    protected $data;
    public function __construct($data, $jobs)
    {
        //
        $this->jobs = $jobs;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jobs = $this->jobs;
        if(sizeof($jobs) > 0){
            $i = 0;
            foreach ($jobs as $job) {
                $title = $job['title'];
                $description = $job['description'];
                $salary = 'Php '.$job['salary'].'.00';
                $message = 'Title: '.$title.PHP_EOL.PHP_EOL.'Description: '.$description.PHP_EOL.PHP_EOL.'Salary: '.$salary.PHP_EOL;
                if($i >= 1){
                    $this->send($this->data['mobile_number'], $message);
                }
                else{
                    $result = $this->reply($this->data, $message);
                    if($result->status == 400 || $result->status == '400')
                        $this->send($this->data['mobile_number'], $message);
                }
                $i++;
            }
        }
    }

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
        $result = $this->sendApiRequest($sendData);
        echo json_encode($result);
        return $result;
    }

    public function generateCode35($length){
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, $length);
    }
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
