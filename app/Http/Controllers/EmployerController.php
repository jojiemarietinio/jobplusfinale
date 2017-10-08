<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Jobs;
use App\Works;
use App\Profiles;
use App\Schedules;
use App\Categories;
use App\Paytypes;
use App\Job_Type;
use App\Job_Address;
use App\Reviews;
use App\Job_Skill;
use App\Application;
use App\Work_Reviewed;
use App\Work_Summary;
use App\User_Review;
use Auth;
use Carbon\Carbon;
use DateTime;

class EmployerController extends Controller
{
 public function index(){
  $jobs = Job::all();
  return view('employer.home',compact('jobs'));
}

public function getDashboard(){
  $userid = Auth::user()->id;
  $jobs = Jobs::where('user_id',$userid)->get();
  $jobb = array();
  
  foreach($jobs as $job){
    $jobb[] = $job->job_id;
  };

  $profiles = Profiles::all();
  return view('employer.home',compact('applications','profiles','jobs'));
}
 
public function postJob(Request $req){
   $id = Auth::user()->id;
  
  $data['requested'] = $req->all();

  $address = new Job_Address;
  $address->lat = $req->lat;
  $address->lng = $req->lng;
  $address->locality = $req->locality;
  $address->address = $req->address;
  $address->save();
  
  $start = new DateTime($req->start);
  $end = new DateTime($req->end);

  $newjob = new Jobs;
  $newjob->user_id = $id;
  $newjob->category_id = $req->category;
  $newjob->job_type_id = $req->jobtype;
  $newjob->address_id = $address->id;
  $newjob->title = $req->title;
  $newjob->description = $req->description;
  $newjob->start_date = date_format($start, 'Y-m-d H:i:00');
  $newjob->end_date = date_format($end, 'Y-m-d H:i:00');
  $newjob->paytype = $req->paytype;
  $newjob->salary = $req->salary;
  $newjob->is_all_day = 1;
  $newjob->slot = $req->slot;
  $newjob->date_posted = new DateTime;
  $newjob->save();
  
  $jobid = $newjob->job_id;
  $jsched = new Schedules;
  $jsched->job_id = $jobid;
  $jsched->start = date_format($start, 'Y-m-d H:i:00');
  $jsched->end = date_format($end, 'Y-m-d H:i:00');
  $jsched->save();

  $arr[] = $req->skills;
  for($i=0; $i<count($req->skills); $i++){
    $skills = new Job_Skill;
    $skills->job_id = $jobid;
    $skills->skill_id = $arr[0][$i];
    $skills->save();
  }

  $data['status'] = 'success';
  return response()->json($data);
}

public function getJobPostData(){
  $id = Auth::user()->id;
  $profile  = Profiles::where('user_id',$id)->first();
  $category = Categories::all();
  $paytype = Paytypes::all();
  $jobtype = Job_Type::all();
  
  $job = Jobs::where('user_id',$id)->get();
  $jobs = []; 
  $jobids = [];
  foreach($job as $j){
    $jobids[] = $j->job_id;
    $jobs[] = [
    'id' => $j->job_id,
    'employer' =>$j->users->profile,
    'title' => $j->title,
    'posted' => $j->date_posted,
    'category' => $j->categories->name,
    'description' => $j->description,
    'address' => $j->address,
    'slot' => $j->slot,
    'paytype' => $j->paytypes->name,
    'jobtype' => $j->jobtypes->name,
    'salary' => $j->salary,
    ];
  }

  $data['ids'] = $jobids;
  $applicant = [];
  if(count($job)>0){
    $applicants = Application::whereIn('job',$jobids)
    ->where('is_accepted',0)
    ->get();

    foreach($applicants as $app){
      $applicant[] = [
      'application_id' => $app->application_id,
      'applicant' => $app->users->profile,
      'job' => $app->job];
    }
  }

  $data['applicant'] = $applicant;

  $data['jobs'] = $jobs;
  $data['paytype'] = $paytype;
  $data['jobtype'] = $jobtype;
  $data['profile'] = $profile;
  $data['category'] = $category;
  return response()->json($data);
}

public function getJobPost(){
  return view('employer.jobposting');
}

public function getViewJob(){
  return view('employer.jobposting');
}

public function getProfile(){
  return view('users.emp-profile');
}

public function getJobWallet(){
    return view('employer.jobwallet');
}

public function getApplications(){
  return view('employer.application');
}

public function getApplicationData(){
  $id = Auth::user()->id;
  $jobs = Jobs::where('user_id',$id)->get();
  $jobID = [];
  if(count($jobs)>0){
    foreach($jobs as $j){
      $jobID[] = $j->job_id;
    }

    $applications = Application::whereIn('job',$jobID)
    ->where('is_accepted',0)->get();
    $profile = Profiles::all();
    $response = [];
    foreach($applications as $app){
      $response[] = [
      'app_id' => $app->application_id,
      'date' => $app->date,
      'user' => $app->users->profile,
      'job' => $app->jobs];
    }
    $data['response'] = $response;
    $data['status'] = 200;
  }else{
    $data['status'] = 400;
  }

  return response()->json($data);
}

public function startJob(Request $req){
  $workid = $req->id;
  $work = Works::where('work_id',$workid)->first();
  $work->is_started = 1;
  $work->start_time = new DateTime;
  $work->save();
  $data['status'] = 200;
  return response()->json($data);
}

public function endJobSummary(Request $req){
 $workid = $req->workid;

 $summ =  Work_Summary::where('work_id',$workid)->first();

 $newwork = Works::where('work_id',$summ->work_id)->first();
 $summary = [];

 $started = new DateTime($newwork->start_time);
 $ended = new DateTime($newwork->end_time);

 $rendered = $summ->hours_rendered;
 $salary = $summ->salary;
 $fines = $summ->fines;
 $paytype = $newwork->schedules->jobs->paytypes;
 $applicant = $newwork->users->profile;
 $total_salary = $summ->total_salary;

 $summary[] =[
 'work' => $newwork,
 'started' => $started,
 'ended' => $ended,
 'rendered' => $rendered,
 'salary' => $salary,
 'total_salary' => $total_salary,
 'fines' => $fines,
 'paytype' => $paytype,
 'applicant' => $applicant
 ];

 $data['status'] = 200;
 $data['work'] = $summary;
 return response()->json($data);
}

public function endJob(Request $req){
  $workid = $req->workid;
  $rate   = $req->rate;
  $desc   = $req->review;

  $work = Works::where('work_id',$workid)->first();

  $review               = new Reviews;
  $review->comment      = $desc;
  $review->rating       = $rate;
  $review->reviewed_id  = $work->applicant_id; 
  $review->reviewer_id  = $work->employer_id;
  $review->work_id      = $workid;
  $review->save();

  $work_reviewed = Work_Reviewed::where('work_id',$workid)->first();
  if(count($work_reviewed) > 0){
    $work_reviewed->employer_reviewed = 1;
    $work_reviewed->save(); 
  }
  else{
    $new_work_review = new Work_Reviewed;
    $new_work_review->work_id = $workid;
    $new_work_review->applicant_reviewed = 0;
    $new_work_review->employer_reviewed = 1;
    $new_work_review->save();
    $data['message'] = 'created a new review';
  }

  $work_sum = Work_Summary::where('work_id',$workid)->first();
  $work_sum->is_paid = 1;
  $work_sum->save();

  
  $data['is_paid'] = true;
  return response()->json($data);
}

public function getDashboardData(){
  $id = Auth::user()->id;
  $this->setActive();
  $this->setUpcoming();

  $activeID = [];
  $actID = [];
  $upcomingID = [];
  $needReview = [];

  $review_work = Work_Reviewed::where('employer_reviewed',0)->get();
  if(count($review_work)>0){
    foreach($review_work as $rw){
      if($rw->employer_id == 0 && $rw->works->employer_id == $id && $rw->works->status == 4)
        $needReview[] = [
      'work' => $rw->works,
      'schedule' => $rw->works->schedules,
      'applicant' => $rw->works->users->profile,
      'job' => $rw->works->schedules->jobs,
      'paytype' => $rw->works->schedules->jobs->paytypes->name];
    }
    $data['pending_status'] = 200;
  }
  else{
    $data['pending_status'] = 400;
  }

  $active = Works::where('employer_id',$id)->where('status',1)->get();
  if(count($active)>0){
    foreach($active as $act){
      $actID[] = $act->work_id;
      $activeID[] = [
      'work' => $act,
      'schedule' => $act->schedules,
      'applicant' => $act->users->profile,
      'job' => $act->schedules->jobs,
      'paytype' =>$act->schedules->jobs->paytypes->name
      ];
    }
    $data['active_status'] = 200;
  }
  else{
    $data['active_status'] = 400;
  }


  $upcoming = Works::where('employer_id',$id)->where('status',2)->get();
  if(count($upcoming)>0){
    foreach($upcoming as $up){
      $upcomingID[] = [
      'work_' => $up->work,
      'schedule' => $up->schedules,
      'applicant' => $up->users->profile,
      'job' => $up->schedules->jobs,
      'paytype' =>$up->schedules->jobs->paytypes->name
      ];
    }
    $data['upcoming_status'] = 200;
  }
  else{
    $data['upcoming_status'] = 400;
  }
  $data['pending'] = $needReview;
  $data['active'] = $activeID;
  $data['upcoming'] = $upcomingID;
  return response()->json($data);
}

public function ApplicationResponse(Request $req){
  $id = $req->appid;
  $application = Application::where('application_id',$id)->first();
  if($req->response == 1){
    $application->is_accepted = 1;
    $application->save();

    $job = Jobs::where('job_id',$application->job)->first();
    $job->slot = $job->slot - 1;
    $job->save();
    
    $sched = Schedules::where('job_id',$job->job_id)->get();
    foreach($sched as $sch){
      $work = new Works;
      $work->sched_id = $sch->schedule_id;
      $work->applicant_id = $application->applicant;
      $work->employer_id = Auth::user()->id;
      $work->status = 2;
      $work->date = new DateTime;
      $work->is_started = 0;
      $work->save();
    }


  }
  else{
    $application->delete();
  }
  $data['status'] = 200;
  return response()->json($data);

}

public function setActive(){
  $userid = Auth::user()->id;
  $work = Works::where('status',2)->where('employer_id',$userid)->get();

  $now = new DateTime;
  if(count($work)>0){

    foreach($work as $w){
      $start = new DateTime($w->schedules->start);
      $result = $start->diff($now);
      $rhour = $result->format('%h');
      if($rhour == 0){
        $w->status = 1;
        $w->save();
      }
    }

  }
}

public function setUpcoming(){
  $userid = Auth::user()->id;
  $work = Works::where('status',3)
  ->where('employer_id',$userid)
  ->get();

  $now = new DateTime;
  if(count($work)>0){

    foreach($work as $w){
      $start = new DateTime($w->schedules->start);
      $result = $now->diff($start);
      $month = $result->format('%m');
      $day = $result->format('%d');
      if($day == 0 && $month == 0){
        $w->status = 2;
        $w->save();
      }
    }

  }
} 

public function getRecommendedApplicants() {
    $job_id = 1;
 
    $job = Jobs::where('job_id', $job_id)->first();
 
 
    $recommended_applicants = User::join('profiles', 'users.id', '=', 'profiles.user_id')
    ->join('prof_skills', 'profiles.profile_id', '=', 'prof_skills.profile_id')
    ->where('prof_skills.skill_id', $job->skill_id)
    ->get();
 
    return view('employer.empRecom', compact('recommended_applicants'));
}




}
