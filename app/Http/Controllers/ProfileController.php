<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Reviews;
use App\Profiles;
use App\Skills;
use App\Prof_Skill;
use App\Paytypes;
use App\Degrees;
use App\Attainment;
use App\Field_study;
use App\Education;
use App\Experiences;
use App\Prof_Edu;
use App\Prof_Exp;
use App\Jobs;
use App\Works;
use App\Job_Skill;
use App\Job_Address;
use App\Job_nearby;
use App\Job_recommended;
use App\Job_feeds;
use App\Schedules;
use App\Categories;
use App\Prof_mobile;
use App\JobRank;
use Borla\Chikka\Chikka;

class ProfileController extends Controller
{
	public function getSkill(){
		$id = Auth::user()->id;
		$profile = Profiles::where('user_id',$id)->first();
		$pskill = Prof_Skill::where('profile_id',$profile->profile_id)->get();
		$skid = [];

		if(count($pskill) > 0){
			foreach($pskill as $ps){
				$skid[] = $ps->skill_id;
			}

			$data['pskill'] = $skid;
		}
		else{
			$data['pskill'] = 0;
		}


		$housekeeping = Skills::where('category_id',1)->get();
		$construction = Skills::where('category_id',2)->get();
		$personel = Skills::where('category_id',3)->get();
		$maintenance = Skills::where('category_id',4)->get();

		$data['house'] = $housekeeping;
		$data['cons'] = $construction;
		$data['pers'] = $personel;
		$data['main'] = $maintenance;
		
		return response()->json($data);
	}

	public function updateSkill(Request $req){
		$userid = Auth::user()->id;
		$prof = Profiles::where('user_id',$userid)->first();

		$updateRecom = Job_recommended::where('user_id',$userid)->get();
		if(count($updateRecom) > 0){
			foreach($updateRecom as $update){
				$update->delete();
			}
		}

		$updateNearby = Job_nearby::where('user_id',$userid)->get();
		if(count($updateNearby) > 0){
			foreach($updateNearby as $update){
				$update->delete();
			}
		}

		$updateFeeds = Job_feeds::where('user_id',$userid)->get();
		if(count($updateFeeds) > 0){
			foreach($updateFeeds as $update){
				$update->delete();
			}
		}


		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prof->address).'&sensor=false';
		$json = @file_get_contents($url);
		$orig = json_decode($json);

		$lat1 = $orig->results[0]->geometry->location->lat;
		$long1 = $orig->results[0]->geometry->location->lng;

		$finalnearbyID = [];
		$ranker = new JobRank;
		$works = Works::where('applicant_id',$userid)->whereIn('status',[1,2,3])->get();
		if(count($works) > 0){ 
			foreach($works as $w){
				$wID[] = $w->schedules->job_id;
			}
			$job = Jobs::whereNotIn('job_id',$wID)->where('slot','!=',0)->get();
  // $job = Jobs::whereIn('job_id',$jskillID)->where('slot','!=',0)->get();
		}
		else{
			$job = Jobs::where('slot','!=',0)->get();
		}

		if(count($job) == 0){
			$data['status'] = 400;
		}
		else{

			foreach($job as $jb){   
				$jobID[] = $jb->job_id;
				$jfeed = Job_feeds::where('job_id',$jb->job_id)->where('user_id',$userid)->first();

				if(count($jfeed) == 0){
					$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$jb->address->lat.",".$jb->address->lng."&mode=transit&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places";
					$json = @file_get_contents($url);
					$location_datas = json_decode($json);
					$distance = $location_datas->rows[0]->elements[0]->distance->value;

      // $debug[] = ['jobid' => $jb->job_id,'distance' => $location_datas->rows[0]->elements[0]->distance->value,'origin' => $location_datas->origin_addresses[0],'destination' =>$location_datas->destination_addresses[0] ];
					$jobfeeds = new Job_feeds;
					$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
					$jobfeeds->job_id = $jb->job_id;
					$jobfeeds->user_id = $userid;
					$jobfeeds->save();

					$jobfeeds = new Job_recommended;
					$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
					$jobfeeds->job_id = $jb->job_id;
					$jobfeeds->user_id = $userid;
					$jobfeeds->save();
					if($distance <= 5000){
						$finalnearbyID[] = $jb->job_id;
						$jobfeeds = new Job_nearby;
						$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
						$jobfeeds->job_id = $jb->job_id;
						$jobfeeds->user_id = $userid;
						$jobfeeds->save();
					}
				}
			} 
			$this->setJobNearby($finalnearbyID);
			$this->setJobRecommended($jobID);
			$this->setJobFeeds($jobID);


		$skills = [];
		$skills[] = $req->skills;

		$id = Auth::user()->id;
		$profile = Profiles::where('user_id',$id)->first();
		$pskill = Prof_Skill::where('profile_id',$profile->profile_id)->get();

		if(count($pskill)>0){
			foreach($pskill as $ps){
				$ps->delete();
			}
		}

		$size = 0;
		foreach($skills as $sk){
			$size += count($sk);
		}
		if($size > 0){
			for($i=0; $i<$size; $i++){
				$prof_sk = new Prof_Skill;
				$prof_sk->profile_id = $profile->profile_id;
				$prof_sk->skill_id = $skills[0][$i];
				$prof_sk->save();
			}
			$data['skill'] = 1;
		}
		else{
			$data['skill'] = 0;
		}
		$data['status'] = 1;
		return response()->json($data);
	}
}

	function setJobNearby($jobID){
		$location_arr = [];
		$loc_points = 0;
		$skill_points = 0;
		$history_arr = [];
		$history_points = 0;

		$ranker = new JobRank;
		$nearby_criteria = ['loc' => 0.5, 'skill' => 0.3, 'history' => 0.2];

		$job = Jobs::whereIn('job_id',$jobID)->get();
		$userid = Auth::user()->id;
		$profile = Profiles::where('user_id',$userid)->first();
		$userskills = Prof_Skill::where('profile_id',$profile->profile_id)->get();
		$userskill = [];

		if(count($userskills) > 0){
			$skill    = Prof_Skill::where('profile_id',$profile->profile_id)->get();      
			foreach($userskills as $usk){
				$userskill[] = $usk->skill_id; 
			}
		}

		foreach($job as $jb){
			$jobnearby = Job_nearby::where('user_id',$userid)
			->where('job_id',$jb->job_id)->first();

			$skill_pts = $jobnearby->skill_points;
			if($skill_pts == 0){
				$loc_pts = $jobnearby->location_points * $nearby_criteria['loc'];
				$skill_pts = $ranker->getSkillPoints($userskill,$jb->job_id)  * $nearby_criteria['skill'];
				$history_pts = $ranker->getHistory($jb->job_id,$userid) * $nearby_criteria['history'];

				$jobnearby->location_points = $loc_pts;
				$jobnearby->skill_points = $skill_pts;
				$jobnearby->history_points = $history_pts;
				$jobnearby->result = ($loc_pts + $skill_pts + $history_pts) / 3;
				$jobnearby->save();
			}
		}
	}

	function setJobRecommended($jobID){
		$location_arr = [];
		$loc_points = 0;
		$skill_points = 0;
		$history_arr = [];
		$history_points = 0;

		$ranker = new JobRank;
		$recom_criteria = ['loc' => 0.3, 'skill' => 0.5, 'history' => 0.2];
		$userid = Auth::user()->id;
		$profile = Profiles::where('user_id',$userid)->first();
		$userskills = Prof_Skill::where('profile_id',$profile->profile_id)->get();
		$userskill = [];

		if(count($userskills) > 0){
   // $skill    = Prof_Skill::where('profile_id',$profile->profile_id)->get();      
			foreach($userskills as $usk){
				$userskill[] = $usk->skill_id; 
			}
		}

// job already filtered based from profile skill
		$job_skill = Job_Skill::whereIn('skill_id',$userskill)->get();
		$jskillID = [];

		foreach($job_skill as $jskill){
			$jskillID[] = $jskill->job_id;
		}
// get job where jobskill

		$finaljob = Jobs::whereIn('job_id',$jskillID)->get();
		$trial = ['user_skill' => $userskill, 'job_skill' => $job_skill,'job_id' => $jskillID];
// dd($trial);
		$filterJobRecom = Job_recommended::whereNotIn('job_id',$jskillID)->get();

//delete jobids nga di compatible ang skills sa profile skill
		foreach($filterJobRecom as $filter){
			$filter->delete();
		}

		$cleanJob = Job_recommended::all();

		$job = Jobs::whereIn('job_id',$jskillID)->get();
 //foreach($job as $jb){
		foreach($cleanJob as $jb){
			$jobrecom = Job_recommended::where('user_id',$userid)
			->where('job_id',$jb->job_id)->first();

			$skill_pts = $jobrecom->skill_points;
			if($skill_pts == 0){
				$loc_pts = $jobrecom->location_points * $recom_criteria['loc'];
				$skill_pts = $ranker->getSkillPoints($userskill,$jb->job_id)  * $recom_criteria['skill'];
				$history_pts = $ranker->getHistory($jb->job_id,$userid) * $recom_criteria['history'];

				$jobrecom->location_points = $loc_pts;
				$jobrecom->skill_points = $skill_pts;
				$jobrecom->history_points = $history_pts;
				$jobrecom->result = ($loc_pts + $skill_pts + $history_pts) / 3;
				$jobrecom->save();
			}
		}
	}

	function setJobFeeds($jobID){
		$location_arr = [];
		$loc_points = 0;
		$skill_points = 0;
		$history_arr = [];
		$history_points = 0;
		$ranker = new JobRank;
		$feed_criteria = ['loc' => 0.2, 'skill' => 0.3, 'history' => 0.5];
		$job = Jobs::whereIn('job_id',$jobID)->get();
		$userid = Auth::user()->id;
		$profile = Profiles::where('user_id',$userid)->first();
		$userskills = Prof_Skill::where('profile_id',$profile->profile_id)->get();
		$userskill = [];

		if(count($userskills) > 0){
			$skill    = Prof_Skill::where('profile_id',$profile->profile_id)->get();      
			foreach($userskills as $usk){
				$userskill[] = $usk->skill_id; 
			}
		}

		$tempIDS = [];
		foreach($job as $jb){
			$jobfeed = Job_feeds::where('user_id',$userid)->where('job_id',$jb->job_id)->first();
			$skill_pts = $jobfeed->skill_points;
			if($skill_pts == 0){
				$tempIDS = ['jobids' => $jb->job_id];
				$loc_pts = $jobfeed->location_points * $feed_criteria['loc'];
				$skill_pts = $ranker->getSkillPoints($userskill,$jb->job_id)  * $feed_criteria['skill'];
				$history_pts = $ranker->getHistory($jb->job_id,$userid) * $feed_criteria['history'];

				$jobfeed->location_points = $loc_pts;
				$jobfeed->skill_points = $skill_pts;
				$jobfeed->history_points = $history_pts;
				$jobfeed->result = ($loc_pts + $skill_pts + $history_pts) / 3;
				$jobfeed->save();
			}
		}
	}


	public function setName(Request $req){
		$fname = $req->fname;
		$lname = $req->lname;
		$address = $req->address;
		$userid = Auth::user()->id;

		$profile = Profiles::where('user_id',$userid)->first();	
		$profile->fname = $fname;
		$profile->lname = $lname;
		$profile->address = $address;
		$profile->save();

		$updateRecom = Job_recommended::where('user_id',$userid)->get();
		if(count($updateRecom) > 0){
			foreach($updateRecom as $update){
				$update->delete();
			}
		}

		$updateNearby = Job_nearby::where('user_id',$userid)->get();
		if(count($updateNearby) > 0){
			foreach($updateNearby as $update){
				$update->delete();
			}
		}

		$updateFeeds = Job_feeds::where('user_id',$userid)->get();
		if(count($updateFeeds) > 0){
			foreach($updateFeeds as $update){
				$update->delete();
			}
		}


		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false';
		$json = @file_get_contents($url);
		$orig = json_decode($json);

		$lat1 = $orig->results[0]->geometry->location->lat;
		$long1 = $orig->results[0]->geometry->location->lng;

		$finalnearbyID = [];
		$ranker = new JobRank;
		$works = Works::where('applicant_id',$userid)->whereIn('status',[1,2,3])->get();
		if(count($works) > 0){ 
			foreach($works as $w){
				$wID[] = $w->schedules->job_id;
			}
			$job = Jobs::whereNotIn('job_id',$wID)->where('slot','!=',0)->get();
  // $job = Jobs::whereIn('job_id',$jskillID)->where('slot','!=',0)->get();
		}
		else{
			$job = Jobs::where('slot','!=',0)->get();
		}

		if(count($job) == 0){
			$data['status'] = 400;
		}
		else{

			foreach($job as $jb){   
				$jobID[] = $jb->job_id;
				$jfeed = Job_feeds::where('job_id',$jb->job_id)->where('user_id',$userid)->first();

				if(count($jfeed) == 0){
					$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$jb->address->lat.",".$jb->address->lng."&mode=transit&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places";
					$json = @file_get_contents($url);
					$location_datas = json_decode($json);
					$distance = $location_datas->rows[0]->elements[0]->distance->value;

      // $debug[] = ['jobid' => $jb->job_id,'distance' => $location_datas->rows[0]->elements[0]->distance->value,'origin' => $location_datas->origin_addresses[0],'destination' =>$location_datas->destination_addresses[0] ];
					$jobfeeds = new Job_feeds;
					$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
					$jobfeeds->job_id = $jb->job_id;
					$jobfeeds->user_id = $userid;
					$jobfeeds->save();

					$jobfeeds = new Job_recommended;
					$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
					$jobfeeds->job_id = $jb->job_id;
					$jobfeeds->user_id = $userid;
					$jobfeeds->save();
					if($distance <= 5000){
						$finalnearbyID[] = $jb->job_id;
						$jobfeeds = new Job_nearby;
						$jobfeeds->location_points = $ranker->getLocationPoints($location_datas->rows[0]->elements[0]->distance->value);
						$jobfeeds->job_id = $jb->job_id;
						$jobfeeds->user_id = $userid;
						$jobfeeds->save();
					}
				}
			} 
			$this->setJobNearby($finalnearbyID);
			$this->setJobRecommended($jobID);
			$this->setJobFeeds($jobID);


			$data['status'] = 1;
			return response()->json($data);	
		}
	}

		public function setoverview(Request $req){
			$overview = $req->overview;
			$id = Auth::user()->id;
			$profile = Profiles::where('user_id',$id)->first();	
			$profile->biography = $overview;
			$profile->save();
			$data['status'] = 1;
			return response()->json($data);	
		}

		public function getHistory(){
			$userid = Auth::user()->id;
			$review = Reviews::where('reviewed_id',$userid)->get();
			$reviewID = [];

			if(count($review) > 0){
				foreach($review as $rev){
					$reviewID[] = [
					'review' => $rev,
					'employer' => $rev->employer->profile,
					'job' => $rev->work->schedules->jobs
					];
				}
				$response = [
				'reviews' => $reviewID,
				'status' => 200];
			}
			else{
				$response = [
				'status' => 400];
			}
			return response()->json($response);
		}

	}
