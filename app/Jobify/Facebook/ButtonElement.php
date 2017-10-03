<?php

namespace App\Jobify\Facebook;

class ButtonElement{

  /*
    @Enum
    @R
  */
  protected $type;

  /*
    @String
    @R
  */
  protected $title;
  
  /*
    @String
    @R  
  */
  protected $url;
 
  /*
    @String
    @R
  */
  protected $payload;

  /*
    @Object
    @NR
  */
  protected $shareContents;

  /*
    @Enum
    @NR
    @Default = Full
  */
  protected $webviewHeightRatio;

  /*
    @String
    @NR
  */

  protected $fallbackUrl;

  /*
    @String
    @NR
  */
  protected $webviewShareButton;


  function __construct($title){
    $this->title = $title;
  }

  public function type($type){
    $this->type = $type;
    return $this;
  }
  
  public static function title($title){
    return new static($title);
  }

  public function url($url){
    $this->url = $url;
    return $this;
  }

  public function shareContents($shareContents){
    $this->shareContents = $shareContents;
    return $this;
  }

  public function payload($payload){
    $this->payload = $payload;
    return $this;
  }

  public function ratio($webviewHeightRatio){
    $this->webviewHeightRatio = $webviewHeightRatio;
    return $this;
  }

  public function fallbackUrl($fallbackUrl){
    $this->fallbackUrl = $fallbackUrl;
    return $this;
  }

  public function shareButtons($webviewShareButton){
    $this->webviewShareButton = $webviewShareButton;
    return $this;
  }

  public function toArray(){
    $response["type"] = $this->type;

    if($this->type == "web_url"){
      $response["url"] = $this->url;
      if($this->webviewHeightRatio != null)
        $response["webview_height_ratio"] = $this->webviewHeightRatio;
      //if($this->fallbackUrl != null)  
      //  $response["messenger_extensions"] = false;
      if($this->fallbackUrl != null)
        $response["fallback_url"] = $this->fallbackUrl;
      if($this->webviewShareButton != null)
        $response["webview_share_button"] = $this->webviewShareButton;
    }
    else{
      $response["payload"] = $this->payload;
    }
    
    if($this->title != null){
      $response['title'] = $this->title;
    }
    return $response;
  }

}