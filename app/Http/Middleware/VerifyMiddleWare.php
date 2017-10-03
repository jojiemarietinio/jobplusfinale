<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;


class VerifyMiddleWare
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

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $facebookVerification = "Jobify@GoCentral2017ByKennetteCanales";
        if ($request->input("hub_mode") === "subscribe" && $request->input("hub_verify_token") === $facebookVerification){
            return response($request->input("hub_challenge"), 200);
        }
        return $next($request);
    }
}
