<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use App\Schedules;
use App\Jobs\Notify as JobNotify;

class Notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify per 30 Minutes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
        
    public function handle()
    {
        /*
            1. Get Schedules
        */
        $sched = new Schedules();
        $timeStart  = Carbon::now()->addMinutes(31); 
        $timeEnd    = Carbon::now()->addMinutes(90); // Change 90 to 31
        $results = $sched->whereBetween('start', [$timeStart, $timeEnd])->where('notify','=','0')->orderBy('start','asc')->get();
        echo $timeStart.' ----- '.$timeEnd; 
        if(sizeof($results) > 0){
            dispatch(new JobNotify($results));
        }
        
        
        
        
         
    }
}
