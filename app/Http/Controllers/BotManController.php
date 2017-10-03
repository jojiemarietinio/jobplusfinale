<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use Mpociot\BotMan\BotMan;
use Mpociot\BotMan\Messages\Message;
use Mpociot\BotMan\Facebook\ElementButton;
use Mpociot\BotMan\Facebook\ButtonTemplate;

class BotManController extends Controller
{
    public function handler(){
        $ilinya = app('botman');
        $ilinya->verifyServices('GoCentral123456789ekennCKdashJobify2017143143leadUsLord');
        /*
                    Actions Here
        */
        // Persistent Menus
        $ilinya->hears('@start', function (BotMan $bot) {$this->welcomeMessage($bot);});
        // start listening
        $ilinya->listen();
    }
    public function welcomeMessage(Botman $jobify){
        $jobify->reply('Hi');
    }
}
