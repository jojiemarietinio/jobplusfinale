@extends('masters.AppPrimary')

@section('body')

<?php

namespace App;

use App\Works;
use App\Jobs;
use App\Schedules;
use Auth;
use Carbon\Carbon;
class FindJobs{
	
	public $result;

	public function __construct(){
		$this->result = null;
	}

	public function activeJob(){

		$current = Carbon::now();
		$curr = $current->format('g:i:s A');

		// $db = $current->copy()->subMinutes(31);
		// $two = $db->format('g:i:s A');
		
		// $nice = strtotime($two) - strtotime($curr);

		// /* Within 30mins */
		// if($nice <=0 && $nice >= -1800){
		// $t ='within 30 mins.';
		// 	dd($t);
		// }
		// /* Within 40 mins */
		// if($nice <=0 && $nice >= -2400){
		// $t ='within 40 mins.';
		// 	dd($t);
		// }

		// if($nice <= 0 && $nice >= -3600)
		// {
		// 	$t = 'within 1 hour';
		// 	dd($t);		
		// }

	


	
		// if(count($postsched) > 0){
		// 	foreach($postsched as $psched){

		// 	}
		// }


		$id = Auth::user()->id;
		$sched = Schedules::all();

		 if(count($sched) > 0){
		 	foreach($sched as $sch){

	 			$current 	= Carbon::now();
		 		$start 		= Carbon::parse($sch->start);
		 		$end 		= Carbon::parse($sch->end);
		 		
				$curr 		= $current->format('g:i:s A');
		 		$newstart 	= $start->copy()->format('g:i:s A');

		 		$nice = strtotime($newstart) - strtotime($curr);
				
/* Time Validation */
			 	if($nice <= 0 && $nice >= -3600){

/* Status Validation */
		 		$valwork = Works::where('job_id',$sch->job_id)
		 					 ->where('user_id', $id)
		 					 ->whereNotIn('status',[0,3])
		 					 ->first();

				if(count($valwork) > 0){
			 		$work = Works::where('job_id',$sch->job_id)
			 					 ->where('user_id', $id)
			 					 ->first();
			 		$work->status = 1;
			 		$work->save();

			 		return $sch->schedule_id;
			 		}
			 		return null;
			 		
			 	}
		 	}
		 }
		 return null;
	}

	public function ongoingJob(){
		$id = Auth::user()->id;
	 	return	$ongoing  = Works::where('user_id', $id)
						          ->where('is_start', 0)
						          ->where('status', 1)
						          ->get();
	}

	public function calendarJob(){
		$id = Auth::user()->id;
		return Works::where('user_id', $id)
	                  ->whereIn('status', [1,2])
	                  ->get();
	}

}