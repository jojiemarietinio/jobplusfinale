<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ChikkaSms;

class SendController extends Controller
{
    //
    protected $clientId = 'xxxxx';
    protected $secretKey = 'xxxxxx';
    protected $shortCode = 'xxxxxx';
    
    function __construct(){
            $chikkaAPI = new ChikkaSMS($clientId,$secretKey,$shortCode);
            $response = $chikkaAPI->sendText('UNIQUEMESSAGEID', 'MOBILENUMBER', 'Welcome to Jobify');
    }
}
