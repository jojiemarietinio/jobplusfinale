<?php
namespace App\Jobify\Webhook;
use Illuminate\Http\Request;
use App\Jobify\Webhook\Messaging;

class Entry{
    
 
    private $time;
    private $id;
    private $messagings;
    private function __construct(array $data){
        $this->id = $data["id"];
        $this->time = $data["time"];
        $this->messagings = [];
        foreach ($data["messaging"] as $datum) {
            $this->messagings[] = new Messaging($datum);
        }
    }
    
    //extracts entries from a Messenger callback
    public static function getEntries(Request $request){
        $entries = [];
        $data = $request->input("entry");
        foreach ((array) $data as $datum) {
            $entries[] = new Entry($datum);
        }
        return $entries;
    }
    public function getTime(){
        return $this->time;
    }
    public function getId(){
        return $this->id;
    }
    public function getMessagings(){
        return $this->messagings;
    }
}