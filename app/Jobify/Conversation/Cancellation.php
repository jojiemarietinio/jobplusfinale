<?php

namespace App\Jobify\Conversation;

use App\Jobify\Bot;
use App\Jobify\Webhook\Messaging;

class Cancellation{
    protected $bot;
    
    function __construct(Messaging $messaging){
        $bot = new Bot($messaging);
    }

    public function jobId(){
        $this->bot->reply("Enter Job ID:", true);
    }
    
    public function userId(){
        $this->bot->reply("Enter Job ID:", true);
    }
}