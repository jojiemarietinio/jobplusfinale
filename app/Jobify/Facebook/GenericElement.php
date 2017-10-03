<?php


namespace App\Jobify\Facebook;

class GenericElement{

  /*
    @String
    @R
  */
  protected $title;
  /*
    @String
    @NR
  */
  protected $subtitle;

  /*
    @String
    @NR
  */
  protected $imageUrl;

  /*
    @Object
    @NR
  */
  protected $defaultAction;

  /*
    @Array of Buttons
    @NR
  */
  protected $buttons;

  function __construct($title){
    $this->title = $title;
  }

  public static function title($title){
    return new static($title);
  }

  public function subtitle($subtitle){
    $this->subtitle = $subtitle;
    return $this;
  }

  public function imageUrl($imageUrl){
    $this->imageUrl = $imageUrl;
    return $this;
  }

  public function defaultAction($defaultAction){
    $this->defaultAction = $defaultAction;
    return $this;
  }

  public function buttons($buttons){
    $this->buttons = $buttons;
    return $this;
  }

  public function toArray(){
    $response ["title"] = $this->title;

    if($this->defaultAction){
      $response["default_action"]  = $this->defaultAction;
    }
    if($this->buttons){
      $response["buttons"]  = $this->buttons;
    }
    if($this->subtitle){
      $response["subtitle"]  = $this->subtitle;
    }
    if($this->imageUrl){
      $response["image_url"]  = $this->imageUrl;
    }
    return $response;
  }
}