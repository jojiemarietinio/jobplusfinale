<?php

namespace App\Jobify\Facebook;

class GenericTemplate{

  public static function toArray(array $elements){
    /*
        @ Requires Array of GenericElement
      
    */
    $response =  [
      "attachment"  => [
        "type"      => 'template',
        "payload"   =>  [
          "template_type" => "generic",
          "elements"       => []
        ]
      ]
    ];

    foreach ($elements as $element) {
      $response['attachment']['payload']['elements'][] = $element;
    }

    return $response;
  }

}
