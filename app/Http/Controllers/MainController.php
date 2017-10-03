<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Jobify\Webhook\Entry;
use App\Jobs\BotHandler;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    /*
        Author: Kennette J. Canales
        Applications: GoCentral ChatBot
        Company: GoCentral Software Solutions
        Website: www.gocentralph.com/gcssc
        Email: kennettecanales@gmail.com
        Date: Aug. 3, 2017
        
        All Rights Reserved!
    */

    public function receive(Request $request){
        $entries = Entry::getEntries($request);
        Log::info(print_r($entries, true));
        foreach ($entries as $entry) {
            $messagings = $entry->getMessagings();
            foreach ($messagings as $messaging) {
                dispatch(new BotHandler($messaging));
            }
        }
        //print_r($entries);
        return response("", 200);
    }
}
