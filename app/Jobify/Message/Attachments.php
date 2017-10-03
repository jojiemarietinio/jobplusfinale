<?php


namespace App\Jobify\Message;

class Attachments{
    private $type;
    private $payload;


    //@Type is Location
    private $coordinates;
    private $lat;
    private $long;


    //@Type is either Audio, File, Image, Video
    private $url;

    //@Type is FallBack
    private $title;



    function __construct(array $data){
      $otherType = array("audio", "file", "image", "video");
      $this->type     = $data[0]['type'];
      $this->payload  = $data[0]['payload'];

      if($this->type == "location"){
        $this->coordinates($data[0]['payload']['coordinates']);
      }
      else if(in_array($this->type, $otherType)){
        $this->url = $data[0]['payload']['url'];
      }
      else if($this->type == "fallback"){
        $this->title    = $data[0]['title'];
        $this->payload  = null;
        $this->url      = $data[0]['url'];  
      }
    }

    public function getType(){
      return $this->type;
    }

    public function getPayload(){
      return $this->payload;
    }

    public function coordinates($coordinates){
      $this->coordinates = $coordinates;
      $this->lat = $coordinates['lat'];
      $this->long = $coordinates['long'];
    }

    public function getLat(){
      return $this->lat;
    }

    public function getLong(){
      return $this->long;
    }

    public function getUrl(){
      return $this->url;
    }

    public function getTitle(){
      return $this->title;
    }
}

