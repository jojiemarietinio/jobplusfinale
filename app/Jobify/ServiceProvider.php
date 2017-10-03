<?php

namespace App\Jobify;
use App\Jobify\Http\Curl;

class ServiceProvider{
 

  protected $curl;
  function __construct(){
    $this->curl = new Curl();
  }
  public function getUser($userId){
    $url = "https://graph.facebook.com/v2.6/".$userId."?fields=first_name,last_name,profile_pic,locale,timezone,gender";
    return $this->curl->get($url, true);
  }
  public function send($recipientId, $message){
    $parameter = [
        "recipient" => [
            "id" => $recipientId
        ],
        "message" => $message
    ];
    $url = 'https://graph.facebook.com/v2.6/me/messages';
    $this->curl->post($url,$parameter);
  }
}