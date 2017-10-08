<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Jobs;
use Auth;
use Session;
use App\FindJobs;
use App\Works;
use App\Schedules;
use App\Categories;
use App\Skills;
use App\Prof_Skill;
use App\Reviews;
use App\Paytypes;
use App\Profiles;
use App\Job_Skill;
use App\Job_Address;
use App\Work_Reviewed;
use Carbon\Carbon;
use App\Application;
use App\Work_Logs;
use App\Work_Summary;
use DateTime;
use DateInterval;
use App\JobRank;
use App\Job_nearby;
use App\Job_recommended;
use App\Job_feeds;
use Illuminate\Support\Facades\Input;
class ApplicantController extends Controller
{
  public function getrank(){
    $rank = new JobRank();
    return response()->json($rank);
  }
  public function getAdmin(){
    return view('masters.appPrimary');
  }
  public function getDashboard()
  {
    return view('applicant.dashboard');
  }
  public function getSkills(Request $req){
    $sk = $req->cat;
    if($req->cat == 0){
      $data['skills'] = Skills::all();
    }
    else{
      $data['skills'] = Skills::where('category_id',$sk)->get();
    }
    return response()->json($data);
  }
  function getPrevJobLocation(){
    $today = new DateTime();
    $today = $today->format('ymd');
    // $job = new DateTime('2017-02-28');
    // $job = $job->format('ymd');
    // dd(($today == $job));
    $id = Auth::user()->id;
    $workschedID = [];
    $work = Works::where('applicant_id',$id)->where('status',4)->get();
    if(count($work)>0){
      foreach($work as $wk){
        $wkend = new DateTime($wk->end_time);
        $wkend = $wkend->format('ymd');
        if(($today == $wkend) == true){
          $workschedID[] = $wk->sched_id;
        }
      }
      if(count($workschedID) == 0){
        return null;
      }
      $sched = Schedules::orderBy('start','DESC')->whereIn('schedule_id',$workschedID)->first();
      $finalwork = Works::where('sched_id',$sched->schedule_id)->first();
      return $finalwork;
    }
    else{
      return null;
    }
  }
  public function getActive(){
   $userid = Auth::user()->id;
   $prof = Profiles::where('user_id',$userid)->first();
   $response = [];
   $origin = [];
   $prevwork = $this->getPrevJobLocation();
   $active = Works::where('status',1)->where('applicant_id',$userid)->first();
   if($prevwork == null){
      // Convert user address to lat and long
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prof->address).'&sensor=false';
    $json = @file_get_contents($url);
    $orig = json_decode($json);
    $origlat = $orig->results[0]->geometry->location->lat;
    $origlng = $orig->results[0]->geometry->location->lng;
    $origin = ['lat' => ''.$origlat,'lng' => ''.$origlng];
    $orig_address = $prof->address;
  }
  else{
   $origlat = $prevwork->schedules->jobs->address->lat;
   $origlng = $prevwork->schedules->jobs->address->lng;
   $origin = ['lat' => ''.$origlat,'lng' => ''.$origlng];
   // Convert user coordinates to string address
   $origurl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode($origlat).','.urlencode($origlng).'&sensor=false';
   $origjson = @file_get_contents($origurl);
   $orginss = json_decode($origjson);
   $orig_address = $orginss->results[0]->formatted_address;
 }
 if(count($active) > 0){
   $data['active'] = 1;
   $destlat = $active->schedules->jobs->address->lat;
   $destlng = $active->schedules->jobs->address->lng; 
   $destination = ['lat' => ''.$destlat, 'lng' => ''.$destlng];
   // Convert job coordinates to string address
   $disturl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode($destlat).','.urlencode($destlng).'&sensor=false';
   $distjson = @file_get_contents($disturl);
   $destin = json_decode($distjson);
   $dest_address = $destin->results[0]->formatted_address;
   $address = ['destination' => $dest_address, 'origin' => $orig_address];
    // Get the Distance from User address to work address
   $disturl = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&travelMode=DRIVING&avoidHighways=false&avoidTolls=false&origins='.urlencode($orig_address).'&destinations='.urlencode($dest_address).'&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places';
   $distjson = @file_get_contents($disturl);
   $distdata = json_decode($distjson);
   $distance = $distdata->rows[0]->elements[0]->distance->text;
   $duration = $distdata->rows[0]->elements[0]->duration->text;
   $distobj = ['distance' => $distance, 'duration' => $duration];
   $latadd = ['origin' => $origin, 'destination' => $destination];
   $response[]= [
   'work' => $active,
   'job' => $active->schedules->jobs,
   'paytype' => $active->schedules->jobs->paytypes->name,
   'schedule' => $active->schedules,
   'employer' =>$active->schedules->jobs->users->profile,
   'string_address' => $address,
   'distandtime' => $distobj,
   'coord_address' => $latadd
   ];
 }  
 else{
  $data['active'] = 0;
  $upwork = Works::where('applicant_id', $userid)->where('status',2)->get();
  if(count($upwork) > 0){
    $data['status'] = 1;
    $schedid = [];
    foreach($upwork as $upw){
      $schedid[] = $upw->sched_id;
    }
    $sched = Schedules::orderBy('start','ASC')->whereIn('schedule_id',$schedid)->first();
    $now = new DateTime;
    $start = new DateTime($sched->start); 
    $data['start'] = $start;
    $result = $now->diff($start);
    $rhour = $result->format('%h');
    if($rhour == 0){
        // $data['min'] = '30 min';
      $work = Works::where('sched_id',$sched->schedule_id)->first();
      $work->status = 1;
      $work->save();
      $destlat = $work->schedules->jobs->address->lat;
      $destlng = $work->schedules->jobs->address->lng; 
      $destination = ['lat' => ''.$destlat, 'lng' => ''.$destlng];
      // Convert job coordinates to string address
      $disturl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode($destlat).','.urlencode($destlng).'&sensor=false';
      $distjson = @file_get_contents($disturl);
      $destin = json_decode($distjson);
      $dest_address = $destin->results[0]->formatted_address;
      $address = ['destination' => $dest_address, 'origin' => $orig_address];
    // Get the Distance from User address to work address
      $disturl = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&travelMode=DRIVING&avoidHighways=false&avoidTolls=false&origins='.urlencode($orig_address).'&destinations='.urlencode($dest_address).'&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places';
      $distjson = @file_get_contents($disturl);
      $distdata = json_decode($distjson);
      $distance = $distdata->rows[0]->elements[0]->distance->text;
      $duration = $distdata->rows[0]->elements[0]->duration->text;
      $distobj = ['distance' => $distance, 'duration' => $duration];
      $latadd = ['origin' => $origin, 'destination' => $destination];
      $response[]= [
      'work' => $work,
      'job' => $work->schedules->jobs,
      'paytype' => $work->schedules->jobs->paytypes->name,
      'schedule' => $work->schedules,
      'employer' =>$work->schedules->jobs->users->profile,
      'string_address' => $address,
      'distandtime' => $distobj,
      'coord_address' => $latadd
      ];
    }
    $data['result'] = $result;
  }
  else{
    $data['status'] = 0;
  }
    // code here
}
$data['response'] = $response;
return response()->json($data);
}
public function getUpcoming(){
  $userid = Auth::user()->id;
  $work = Works::where('applicant_id',$userid)
  ->where('status',3)
  ->get();
  if(count($work) > 0){
    $data['ongoing'] = 'success';
    $schedid = [];
    foreach($work as $w){
      $schedid[] = $w->sched_id;
    }
      //--------------Converting Ongoing Jobs to Upcoming --------------//
    $now = new DateTime;
    $sched = Schedules::whereIn('schedule_id',$schedid)->get();
    $startid = [];
    foreach($sched as $sch){
      $starts = new DateTime($sch->start);
      $ends = new DateTime($sch->end);
      if($starts > $now){
        $startid[] = $sch->schedule_id;
      }
    }
    $work = Works::whereIn('sched_id',$startid)->get();
    foreach($work as $w){
      $w->status = 2;
      $w->save();
    }
  }
  else{
   $data['ongoing'] = 'none';
 }
  //-------------- Getting the Upcoming Jobs --------------//
 $upcoming = Works::where('status',2)
 ->where('applicant_id',$userid)
 ->get();
 if(count($upcoming) > 0){
  $data['status'] = 1;
  $upschedid  = [];
  foreach($upcoming as $up){
    $upschedid[] = $up->sched_id;
  }
  $upsched = Schedules::orderBy('start','ASC')
  ->whereIn('schedule_id',$upschedid)
  ->get();
  $jobid = [];
  foreach($upsched as $upsch){
    $jobid[] = $upsch->job_id;
  }
  $job = Jobs::whereIn('job_id',$jobid)->get();
  $userid = [];
  foreach($job as $j){
    $userid[] = $j->user_id;
  }
  $profile = Profiles::whereIn('user_id',$userid)->get();
  $data['work'] = $upcoming;
  $data['profile'] = $profile;
  $data['job'] = $job;
  $data['sched'] = $upsched;
}
else{
  $data['status'] = 0;
}
return response()->json($data);
}
public function getOngoing(){
  $userid = Auth::user()->id;
  $jobid = [];
  $works = Works::where('user_id', $userid)
  ->where('status', 4)
  ->get();
  if(count($works) > 0){
    foreach($works as $work){
      $jobid[] = $work->job_id;
    }
    $job = Jobs::whereIn('job_id',$jobid)->get();
    $data['workids'] = $jobid;
    $data['status'] = 1;
  } 
  else{
    $data['status'] = 0;
  }
  $data['response'] = 'okay';
  return response()->json($data);
}
public function getNotification(){
}
public function getSeemore(Request $req){
  $workid = $req->workid;
  $data['status'] = 1;
  $work = Works::where('work_id',$workid)->first();
  $response = [
  'work' => $work,
  'job' => $work->schedules->jobs,
  'schedule' => $work->schedules,
  'employer' => $work->schedules->jobs->users->profile,
  'address' => $work->schedules->jobs->address,
  'paytype' => $work->schedules->jobs->paytypes->name
  ];
  return response()->json($response); 
}
public function getJobSearch(Request $req){
  $skill = [];
  $loc      = $req->location;
  $cat      = $req->cat;
  $salary   = $req->salary;
  $paytype  = $req->ptype;
  $skill = [];
  $firstids = [];
  $addids = [];
  $newskid = [];
  $jskid = [];
  $profid = [];
  $jobaddid =[];
  $userid = Auth::user()->id;
  $wkID = [];
  $ctr[] = $req->skill;
  if( count($ctr) > 0){
    foreach($ctr as $sk){
      if($sk == ""){
        $skill = null;
      }else{
        $skill[] = $sk;
      }
    }
  }
  $work = Works::where('applicant_id',$userid)->whereIn('status',[1,2])->get();
  if(count($work) > 0){
    foreach($work as $wk){
      $wkID[] = $wk->schedules->jobs->job_id;
    }
  }
  $jadd = Jobs::whereNotIn('job_id',$wkID)->get();
  if($skill != null ){
    $newsk = Skills::whereIn('skill_id',$skill)->get();
    foreach($newsk as $newerskill){
      $newskid[] = $newerskill->skill_id;
    }
    $jskill = Job_Skill::whereIn('skill_id',$newskid)->whereNotIn('job_id',$wkID)->get();
    foreach($jskill as $newerjskill){
      $jskid[] = $newerjskill->job_id;
    }
    $firsts = Jobs::whereIn('job_id',$jskid)->get();
  }
  elseif( $cat != 0 && $skill == null ){
    $firsts = Jobs::where('category_id',$cat)->whereNotIn('job_id',$wkID)->get();
  }
  elseif( $cat == 0 && $skill == null ){
    $firsts = Jobs::whereNotIn('job_id',$wkID)->get();
  }
  if($paytype == 0 && $salary == 0){
    $veryfinal = [];
    foreach($firsts as $final){
      $veryfinal[] = [
      'job' => $final,
      'employer' =>$final->users->profile,
      'address' => $final->address];
    }
    $data['jobs'] = $veryfinal;
    return response()->json($data);
  }
  $secondID = [];
  foreach($firsts as $fst){
    $secondID[] = $fst->job_id;
  }
  // Filters
  if( $paytype == 0 && $salary != 0 ){
    if($salary == 1){     
      $seconds = Jobs::whereIn('job_id',$secondID)
      ->where('salary', '<=' , 500)->get();
    }
    elseif($salary == 2){
      $seconds = Jobs::whereIn('job_id',$secondID)
      ->where('salary', '<=' , 1000)->get(); 
    }
    elseif($salary == 3){
      $seconds = Jobs::whereIn('job_id',$secondID)
      ->where('salary', '>=' , 1000)->get();
    }
  }
  elseif( $paytype != 0 && $salary == 0 ){
    $seconds = Jobs::whereIn('job_id',$secondID)
    ->where('paytype', $paytype)->get();
  } 
  elseif( $paytype != 0 && $salary != 0 ){
    if($salary == 1){
      $seconds = Jobs::whereIn('job_id', $secondID)
      ->where('paytype', $paytype)
      ->where('salary', '<=' , 500)->get();
    }
    elseif($salary == 2){
      $seconds = Jobs::whereIn('job_id', $secondID)
      ->where('paytype', $paytype)
      ->where('salary', '<=' , 1000)->get(); 
    }
    elseif($salary == 3){
      $seconds = Jobs::whereIn('job_id', $secondID)
      ->where('paytype', $paytype)
      ->where('salary', '>' , 1000)->get(); 
    }
  }
  $veryfinal = [];
  foreach($seconds as $final){
    $veryfinal[] = [
    'job' => $final,
    'employer' =>$final->users->profile,
    'address' => $final->address];
  }
  $data['jobs'] = $veryfinal;
  return response()->json($data);
}
function getConflict($jobid){
  $userid = Auth::user()->id;
  $work = Works::where('applicant_id',$userid)->whereIn('status',[1,2])->get();
  $job = Jobs::where('job_id',$jobid)->first();
  $job_add = $job->address->address;
  $job_sched = Schedules::where('job_id',$jobid)->get();
  $wkIDs = [];
  if(count($work) >0){
    foreach($work as $wk){
      $job_id = $wk->schedules->job_id;
      $work_address = $wk->schedules->jobs->address->address;
      $disturl = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&travelMode=DRIVING&avoidHighways=false&avoidTolls=false&origins='.urlencode($work_address).'&destinations='.urlencode($job_add).'&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places';
      $distjson = @file_get_contents($disturl);
      $distdata = json_decode($distjson);
      // $origin = $distdata->origin_addresses[0];
      // $destination = $distdata->destination_addresses[0];
      $distance = $distdata->rows[0]->elements[0]->distance->text;
      $duration = $distdata->rows[0]->elements[0]->duration->text;
      // $distobj[] = ['work' => $wk,'origin' => $origin ,'destination' => $destination,'distance' => $distance, 'duration' => $duration];
      $array1 = array(" hour"," hours"," mins"," min"," ");
      $replace = array("H","H","M","M","");
      $duration = str_replace($array1,$replace,$duration);
      $str_duration = 'PT'.$duration;
      // dd($duration);
      foreach($job_sched as $job_sch){
        $mstart = new DateTime($wk->schedules->start);
        $mend = new DateTime($wk->schedules->end);
        $mend->add(new DateInterval($str_duration));
        $jstart = new DateTime($job_sch->start);
        $jend = new DateTime($job_sch->end);
        $mine[] =['start' => $mstart,'end' => $mend];
        if($mstart == $jstart && $mend == $jend){
         $result = ['conflict' => 1, 'job_sched' => $job_sch, 'work_sched' => $wk,'step' => 3,'mytime' =>$mine];
         return $result;
       }
       if($mstart >= $jstart && $mstart <= $jend){
         $result = ['conflict' => 1, 'job_sched' => $job_sch, 'work_sched' => $wk,'step' => 1,'mytime' =>$mine];
         return $result;
       }
       if($mend >= $jstart && $mend <= $jend){
        $result = ['conflict' => 1, 'job_sched' => $job_sch, 'work_sched' => $wk,'step' => 2,'mytime' =>$mine];
        return $result;
      }
      // $newtime[] = ['original' => $wk->schedules->schedule_id, 'added' =>$mend];
    }
  }
  $result = ['conflict' => 0];
  return $result;
}
else
{
  return null;
}
  // dd($job_add);
}
public function getResult(Request $request){
  $jobid = $request->jobid;
  $job              = Jobs::where('job_id',$jobid)->first();
  $job_skill        = Job_Skill::where('job_id',$job->job_id)->get();
  $conflict = $this->getConflict($jobid);
  $sched = Schedules::where('job_id',$job->job_id)->get();
  $userid = Auth::user()->id;
  $skillID = [];
  foreach($job_skill as $js){
    $skillID[] = $js->skill_id;
  }
  $is_applied = 0;
  $applied = Application::where('applicant',$userid)->where('job',$jobid)->first();
  if(count($applied) > 0){
    $is_applied = 1;
  }
  $skill = Skills::whereIn('skill_id',$skillID)->get();
  $response[] =[
  'job' => $job,
  'paytype' => $job->paytypes->name,
  'jobtype' => $job->jobtypes->name,
  'skill' => $skill,
  'user' => $job->users->profile,
  'schedule' => $sched,
  'category' => $job->categories->name,
  'address' => $job->address,
  'conflict' => $conflict,
  'applied' => $is_applied
  ];
  $data['response'] = $response;
  return response()->json($data);
}
public function getJobPage(){
  return view('applicant.jobfeeds');
}
public function getUserSkills(){
  $userid = Auth::user()->id;
  $profile = Profiles::where('user_id',$userid)->first();
  $userskills = Prof_Skill::where('profile_id',$profile->profile_id)->get();
  $userskill = [];
  $profile  = Profiles::where('user_id',$id)->first(); 
  if(count($userskills) > 0){
    $skill    = Prof_Skill::where('profile_id',$profile->profile_id)->get();   
    foreach($userskills as $usk){
      $userskill[] = $usk->skill_id; 
      foreach($skill as $sk){   
        $skids[] = $sk->skill_id;   
      }      
    }
  }
  return $skids;
}
function getJobFeeds(){
  $userid = Auth::user()->id;
  $jobs = Job_feeds::where('user_id',$userid)->orderBy('result','DESC')->get();
  
  foreach($jobs as $jb){
    if($jb->jobs->slot > 0){
      $job[] = [
      'result' => $jb->result,
      'job' => $jb->jobs,
      'address' => $jb->jobs->address,
      'employer' => $jb->jobs->users->profile];
    }
  }
  return $job;
}
function getJobRecommended(){
  $userid = Auth::user()->id;
  $jobs = Job_recommended::where('user_id',$userid)->orderBy('result','DESC')->get();
  
  foreach($jobs as $jb){
   if($jb->jobs->slot > 0){
    $job[] = [
    'result' => $jb->result,
    'job' => $jb->jobs,
    'address' => $jb->jobs->address,
    'employer' => $jb->jobs->users->profile];
  }
}
$response = [
'message' => 200,
'jobs' => $job];
return $response;
}
function getJobNearby(){
  $userid = Auth::user()->id;
  $jobs = Job_nearby::where('user_id',$userid)->orderBy('result','DESC')->get();
  
  foreach($jobs as $jb){
    if($jb->jobs->slot > 0){
      $job[] = [
      'result' => $jb->result,
      'job' => $jb->jobs,
      'address' => $jb->jobs->address,
      'employer' => $jb->jobs->users->profile];
    }
  }
  $response = [
  'message' => 200,
  'jobs' => $job];
  return $response;
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
public function getJobPageData(){
 $userid = Auth::user()->id;
 $prof = Profiles::where('profile_id',$userid)->first();
 $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prof->address).'&sensor=false';
 $json = @file_get_contents($url);
 $orig = json_decode($json);
 $lat1 = $orig->results[0]->geometry->location->lat;
 $long1 = $orig->results[0]->geometry->location->lng;
 
 // $userskills = Prof_Skill::where('profile_id',$prof->profile_id)->get();
 // $userskill = [];
 // if(count($userskills) > 0){
 //   // $skill    = Prof_Skill::where('profile_id',$profile->profile_id)->get();      
 //   foreach($userskills as $usk){
 //     $userskill[] = $usk->skill_id; 
 //   }
 // }
// job already filtered based from profile skill
// $job_skill = Job_Skill::whereIn('skill_id',$userskill)->get();
// $jskillID = [];
// foreach($job_skill as $jskill){
// $jskillID[] = $jskill->job_id;
// }
// get job where jobskill
// $finaljob = Jobs::whereIn('job_id',$jskillID)->get();
// $trial = ['user_skill' => $userskill, 'job_skill' => $job_skill,'job_id' => $jskillID];
// dd($trial);
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
  $jfeed= $this->getJobFeeds();
  $data['jobs'] = $jfeed;
  $data['message'] = 'success';
}
$data['skill']          = Skills::all();
$data['paytypes']       = Paytypes::all();
$data['categories']     = Categories::all();
return response()->json($data);
}
public function getProfile(){
  return view('users.app-profile');
}
public function Apply(Request $req){
  $jobid = $req->jobid;
  $today = new DateTime;
  $userid = Auth::user()->id;
  $application = new Application;
  $application->applicant = $userid;
  $application->job = $jobid;
  $application->date = $today;
  $application->is_accepted = 0;
  $application->save();
  $data['status'] = 1; 
  return response()->json($data);
}
public function getPendingConfirmation(){
  // $id = Auth::user()->id;
  // $sum = Work_Summary::all();
  // if(count($sum) >0){
  //   foreach($sum as $s){
  //     if($s->works->applicant_id == $id){
  //       $work_sum = Work_Summary::where('summary_id',$s->summary_id)->where('is_paid','!=',2)->first();
  //     }
  //   }
  //   $response = [];
  //   $response = [
  //   'summary' => $work_sum,
  //   'employer' => $work_sum->works->schedules->jobs->users->profile ,
  //   'work' => $work_sum->works
  //   ];
  //   $data['summary'] = $response;
  //   $status = 200;
  // }
  // else{
  //   $status = 400;
  // }
  // $data['status'] = $status;
  // return response()->json($data);
}
public function endJobSummary(Request $req){
  $workid = $req->workid;
  $work = Works::where('work_id',$workid)->first();
  $work->end_time = new DateTime;
  $work->save();
  $newwork = Works::where('work_id',$work->work_id)->first();
  $summary = [];
  $start = new DateTime($newwork->schedules->start);
  $started = new DateTime($newwork->start_time);
  $start->modify('+30 minutes');
  $difference = $start->diff($started);
  $data['start'] = $start;
  $data['diff'] = $difference;
  $salary = $newwork->schedules->jobs->salary;
  if($difference->invert == 0){
    $late = 1;
    $fines = 0.05 * $salary;
  }
  else{
    $late= 0;
    $fines = 0;
  }
  $started = new DateTime($newwork->start_time);
  $ended = new DateTime($newwork->end_time);
  $schedstart = new DateTime($newwork->schedules->start);
  $schedend = new DateTime($newwork->end_time);
  $result = $schedend->diff($schedstart);
  $rendered = $result->h;
  $paytype = $newwork->schedules->jobs->paytypes;
  $employer = $newwork->schedules->jobs->users->profile;
  if($paytype->paytype_id == 1){
    $total_salary = ($salary * $rendered) - $fines;
  }
  else{
    $total_salary = $salary - $fines;
  }
  $summ = new Work_Summary;
  $summ->work_id = $newwork->work_id;
  $summ->salary = $salary;
  $summ->total_salary = $total_salary;
  $summ->fines = $fines;
  $summ->hours_rendered = $rendered;
  $summ->is_paid = 0;
  $summ->save();
  $summary[] =[
  'work' => $newwork,
  'started' => $started,
  'ended' => $ended,
  'rendered' => $rendered,
  'salary' => $salary,
  'total_salary' => $total_salary,
  'fines' => $fines,
  'paytype' => $paytype,
  'employer' => $employer
  ];
  $data['status'] = 200;
  $data['work'] = $summary;
  return response()->json($data);
}
public function StartJob(Request $req){
  $workid = $req->workid;
  $now = new DateTime;
  $work = Works::where('work_id',$workid)->first();   
  if($work->is_start == 1){
    $data['status'] = 0;
  }
  else{
   $sched = Schedules::where('schedule_id',$work->sched_id)->first();
   $start = new DateTime($sched->start);
   $start->modify('+30 minutes');
   $difference = $start->diff($now);
   $data['start'] = $start;
   $data['diff'] = $difference;
   if($difference->invert == 0){
    $data['late'] = 1;
  }
  else{
    $data['late'] = 0;
  }
  $work->is_started = 1;
  $work->start_time = $now;
  $work->save();
  $data['status'] = 1;
}
    // $sched = Schedules::where('schedule_id',$schedid)->first();
    // $current   = new DateTime('now');
    // $start     = new DateTime($sched->start);
    // $end        = new DateTime($sched->end);
    // $result    = $start->diff($current);  
    // $min       = $result->format('%i');
    // if($min >= 30){
    //   //late
    //   $data['late'] = 1;
    // }
$data['end'] = $sched->end;
$data['message'] = 'success';
return response()->json($data);  
}
public function EndJob(Request $req){
  $rate   = $req->rate;
  $desc   = $req->review;
  $workid  = $req->workid;
  if($rate == 0){
    $data['status'] = 400;
    return response()->json($data);
  }
  else{
  $work = Works::where('work_id',$workid)->first();
  $work->status = 4;
  $work->is_started = 0;
  $work->save();
  $work_log = new Work_Logs;
  $work_log->work_id = $workid;
  $work_log->save();
  
  $review               = new Reviews;
  $review->comment      = $desc;
  $review->rating       = $rate;
  $review->reviewed_id  = $work->employer_id; 
  $review->reviewer_id  = $work->applicant_id;
  $review->work_id      = $workid;
  $review->save();
  $work_reviewed = Work_Reviewed::where('work_id',$workid)->first();
  if(count($work_reviewed) > 0){
    $work_reviewed->applicant_reviewed = 1;
    $work_reviewed->save();
    if($work_reviewed->employer_reviewed == 1){
      $work_reviewed->delete();
      $data['message'] = 'work officialy closed';
    }
  }
  else{
    $new_work_review = new Work_Reviewed;
    $new_work_review->work_id = $workid;
    $new_work_review->applicant_reviewed = 1;
    $new_work_review->employer_reviewed = 0;
    $new_work_review->save();
    $data['message'] = 'created a new review';
  }
}
  $data['status'] = 1;
  return response()->json($data);
}
public function viewJob($id){
  $profile = Profiles::all();
  $skills  = Skills::all();
  $job = Jobs::where('job_id',$id)->first();
  return view('applicant.jobinfo',compact('job','skills','profile'));
}
public function setReschedule(Request $req){
  $workid = $req->workid;
  $st = Carbon::now()->toDateTimeString();
  $work = Works::where('work_id',$workid)->first();
  $sched = Schedules::where('schedule_id',$work->sched_id)->first();
  $sched->start = $st;
  $sched->end = $st;
  $sched->save();
  $data['sched']  = $sched;
  $data['workid'] = $workid;
  $data['start']  = $st;
  $data['status'] = 1;
  return response()->json($data);
}
public function receivePayment(Request $req){
  $sumid = $req->sumid;
  $work = Work_Summary::where('summary_id',$sumid)->first();
  $work->is_paid = 2;
  $work->save();
  
  $data['status'] = 200;
  return response()->json($data);
}
public function getApplications(){
  $userid = Auth::user()->id;
  $apps = Application::where('applicant',$userid)
                      ->where('is_accepted',0)->get();
  return view('applicant.jobapplications',compact('apps'));
}
public function setApplication(Request $req){
  $appid = Application::where('application_id',$req->id)->first();
  $appid->delete();
  $data['message'] = 200;
  return response()->json($data);
}
}