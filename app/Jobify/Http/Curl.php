<?php
namespace App\Jobify\Http;

use Symfony\Component\HttpFoundation\Response;

class Curl{
    
   
    
    public function post($url, $parameter){
     $request = $this->prepare($url, false);
      curl_setopt($request, CURLOPT_POST, count($parameter));
      curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($parameter));
      return $this->execute($request);
    }
    public function get($url, $flag){
      $request = $this->prepare($url, $flag);
      return $this->executeBody($request);
    }
    public function prepare($url, $flag){
      $request = curl_init();
      $page_access_token = "access_token=EAAbusgReFvsBAC0bu80b7K189qZCZCYdzhQU8qXN15aBJy6eqZBKp7n8YjDOFBt4EvNn5R5EpnfDVL5ZBE4iJQqzKNCJXbtnrZAUMzg52PH6GlpAZCOFXLFLJXnfWtlHxbZAGJIJepPNzuX7kWBsP9CDO98TF75xeuGQMZAuwmXMwgZDZD";
      $url .= ($flag == false)? '?'.$page_access_token:'&'.$page_access_token;  
        
      curl_setopt($request, CURLOPT_URL, $url);
      curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($request, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
      curl_setopt($request, CURLINFO_HEADER_OUT, true);
      curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);
      return $request;
    }
    public function execute($request){  
      $body = curl_exec($request);
      $info = curl_getinfo($request);
      curl_close($request);
      $statusCode = $info['http_code'] === 0 ? 500 : $info['http_code'];
      return new Response((string) $body, $statusCode, []);
    }
    public function executeBody($request){
      return json_decode(curl_exec($request),true);
    }
}