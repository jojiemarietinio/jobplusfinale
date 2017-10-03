<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
use App\Job_Skill;
use App\Job_Address;
use App\Schedules;
use App\Works;
use App\Work_Logs;
use App\Categories;
use App\Work_Summary;
use App\Prof_mobile;
use Borla\Chikka\Chikka;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Auth;
use Session;

class UserController extends Controller
{
    public function getHome(){
        return view('home');
    }

    public function checkJob(){
        $data['status'] = 1;
        return response()->json($data);
    }
    public function checkPage(){
        $job = Jobs::all();
        $sched = Schedules::all();
        return view('users.checker',compact('job','sched'));
    }

    public function getJob(){


        function array_push_assoc($array, $key, $value){
            $array[$key] = $value;
            return $array;
        }
        
        function getLocationPoints($distance){
            $points =   0;

            if($distance < 1000){
              return  $points  = 100;
          }
          else if($distance >= 1000 && $distance < 1500){
              return  $points = 90;
          }
          else if($distance >= 1500 && $distance < 2000){
           return   $points = 85;
       }
       else if($distance >= 2000 && $distance < 2500){
          return  $points = 80;
      }
      else if($distance >= 2500 && $distance < 3000){
          return  $points = 75;
      }
      else if($distance >= 3000 && $distance < 3500){
          return  $points = 70;
      }
      else if($distance >= 3500 && $distance < 4000){
          return  $points = 65;
      }
      else if($distance >= 4000 && $distance < 4500){
          return  $points = 60;
      }
      else if($distance >= 4500 && $distance < 5000){
          return  $points = 55;
      }
      else if($distance >= 5000){
          return  $points = 50;
      }
  }

  function getSkillPoints(&$userskill,$jobid){
    $points = 0;
    $jskill = [];
    $job_skill = Job_Skill::where('job_id',$jobid)->get();
    foreach($job_skill as $jsk){
        $jskill[] = $jsk->skill_id;
    }
    $counter = count($jskill);
    $lack = 0;
    for($i = 0; $i<$counter; $i++){
        if(!in_array($jskill[$i],$userskill)){
            $lack++;
        }
    }
    if($lack == 0){
        $points = 100;
    }
    else if($lack == 1){
        $points = 90;
    }
    else if($lack == 2){
        $points = 85;
    }
    else if($lack == 3){
        $points = 80;
    }
    else if($lack > 3){
        $points = 75;
    }
    return $points;
}

function getHistoryPoints($workhistoryID,$jobid){
    $work_history = Work_Logs::where('work_id',$workhistoryID)->first();
    if(count($work_history) < 1){
        $points = 0;
        return $points;
    }
    $history_job = Jobs::where('job_id',$work_history->job_id)->first();
    $history_job_skill = Job_Skill::where('job_id',$work_history->job_id)->get();

    $current_job = Jobs::where('job_id',$jobid)->first();
    $current_job_skill = Job_Skill::where('job_id',$current_job->job_id)->get();
    
    $ctrEmployer = 0;
    $ctrSkills = 0;
    $points = 0;

    if($history_job->user_id == $current_job->user_id){
        $ctrEmployer = 1;
    }
    
    $historySkill = [];
    $currentSkill = [];

    foreach($history_job_skill as $hjs){
        $historySkill[] = $hjs->skill_id;
    }
    foreach($current_job_skill as $cjs){
        $currentSkill[] = $cjs->skill_id;
    }

    $intersect = array_intersect($historySkill, $currentSkill);
    if(count($intersect) > 0){
        $ctrSkills = 1;
    }

    if($ctrSkills == 1 && $ctrEmployer == 1){
        $points = 1;
    }   
    else{
        $points = 0;
    }
    return $points;

}

function getHistory($jobid,$userid){
    $histwork = Works::where('applicant_id',$userid)->where('status',4)->get();

    if(count($histwork) < 1){
        $points = 80;
        return $points;
    }

    $flag = 0;
    foreach($histwork as $hw){
        if($flag == 0){
            $flag = getHistoryPoints($hw->work_id,$jobid);
        }
    }

    if($flag == 0){
        $points = 80;
    }
    else{
        $points = 100;
    }
    return $points;
}

$userid = Auth::user()->id;
$address = Job_Address::where('locality','Cebu City')->get();
$profile = Profiles::where('user_id',$userid)->first();

$userskills = Prof_Skill::where('profile_id',$profile->profile_id)->get();
$userskill = [];
if(count($userskills) > 0){
    foreach($userskills as $usk){
        $userskill[] = $usk->skill_id; 
    }
}


      //  Get distance on jobs with same locality
$lat1 = 10.310617;
$long1 =  123.892872;

$criteria_Loc = 0.5;
$criteria_skill = 0.3;
$criteria_history = 0.2;
$location_arr = [];
$loc_points = [];
$skill_points = [];
$history_arr = [];
$history_points = [];
$addressID = [];

foreach($address as $add){
    $addressID[] = $add->jobid;
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$add->lat.",".$add->lng."&mode=transit&key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places";
    $json = @file_get_contents($url);
    $location_datas = json_decode($json);

    $location_arr = array_push_assoc($location_arr, $add->jobid,$location_datas->rows[0]->elements[0]->distance->value);
    $loc_points = array_push_assoc($loc_points, $add->jobid,getLocationPoints($location_datas->rows[0]->elements[0]->distance->value) * $criteria_Loc);
    $skill_points = array_push_assoc($skill_points,$add->jobid,getSkillPoints($userskill,$add->jobid) * $criteria_skill);
    $history_points = array_push_assoc($history_points,$add->jobid,getHistory($add->jobid,$userid) * $criteria_history);
}

$addCount = count($addressID);
$result = [];
for($i = 0; $i< $addCount; $i++){
    $result[$addressID[$i]] = ( $loc_points[$addressID[$i]] + $skill_points[$addressID[$i]] + $history_points[$addressID[$i]] ) / 3;
}

function cmps($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

uasort($result,"App\Http\Controllers\cmps");
$finalres = [];

foreach($result as $key => $res){
    $finalres[] = $key;
}

$finaljobs = Jobs::whereIn('job_id',$finalres)->get();
$data['history_points'] = $history_points;
$data['location_arr'] = $location_arr;
$data['loc_points'] = $loc_points;
$data['skill_points'] = $skill_points;
$data['addressID'] = $addressID;
$data['result'] = $result;
$data['final'] = $finalres;
$data['jobs'] = $finaljobs;
return response()->json($data);
}

public function getProfile(){
  return view('users.app-profile');
}

public function UploadImage(){
    if(Input::hasFile('file')) {
        $id = Auth::user()->id;
        $profile = Profiles::where('user_id',$id)->first();

      //upload an image to the /img/tmp directory and return the filepath.
        $file = Input::file('file');
        $tmpFilePath = '/avatar/';
        $tmpFileName = time() . '-' . $file->getClientOriginalName();
        $file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
        $path = $tmpFilePath . $tmpFileName;
        $profile->avatar = $path;
        $profile->save();
        return response()->json(array('path'=> $path), 200);
    } else {
      return response()->json(false, 200);
  }
}

public function ChikkaSend(Request $req){
    // $mobile = '09335532300';
    // $message = 'Hello world';

    $config = [
    'shortcode'=> '292902017',
    'client_id'=> 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0',
    'secret_key'=> 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612',
    ];

    $chikka = new Chikka($config);
    $resp = $chikka->send($mobile, $message);
        // $data['response'] = 'response';
        // return view('masters.sms',compact('response'));
    return response()->json($data);
}

public function ChikkaReceive(Request $req){
    $config = [
    'shortcode'=> '292902017',
    'client_id'=> 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0',
    'secret_key'=> 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612',
    ];

    if($req->input('message_type')){
        echo "true";
    }
    else{
        echo "wala";
    }
    if($req->input('mobile')){
        echo "" +$req->input('mobile');
    }
    else{
        echo "false";   
    }

    // Process message
    // ->message(function($message) {
    //     // Do whatever you want to do with the message
    //     $content = $message->content;
    //     Session::put('cont',$content);
    //     $sender = $message->mobile;
    //     // Return true to tell Chikka that you have successfully received the message
    //     return true;
    // });;
    // $data['mes'] = $chikka->receive($_POST)->getMessage();    

}

private function processMessage($message, $sender) {
        // Get message content
    $content = $message->content;

        // Set new content for replying to message
    $message->content = 'Hello to you, too';
        // Set message id as null (to force the Message object to generate a new message id)
    $message->id = null;
        // Set cost
    $message->cost = 2.50;
        // Send reply
    $response = $sender->reply($message);
        // New message id
    $messageId = $response->attachments->message->id;
        // Return true to tell Chikka that you have successfully received the message
    return true;
}

public function getSMSPage(){
    return view('masters.sms');
}

public function getAdmin(){
    $job = Jobs::all();
    $skill = Job_Skill::all();
    $sk = Skills::all();
    $address = Job_Address::all();
    $paytype = Paytypes::all();
    $schedule = Schedules::all();
    $category = Categories::all();
    return view('masters.admin',compact('job','skill','sk','address','paytype','schedule','category'));
}

public function getProfileData(){
    $skill_ids = [];
    $id = Auth::user()->id;
    $attainment = Attainment::all();
    $degree = Degrees::all();

    $profile = Profiles::where('user_id',$id)->first();
    $prof_skills = Prof_Skill::where('profile_id',$profile->profile_id)->get();

    foreach($prof_skills as $skills){
        $skill_ids[] = $skills->skill_id;
    }

    $newskill = Skills::whereIn('skill_id',$skill_ids)->get();

    $works = Work_Summary::where('is_paid',2)->get();
    $balance = 0;
    if(count($works) > 0){
        foreach($works as $wk){
            if($wk->works->applicant_id == $id){
                $balance = $balance + $wk->total_salary; 
            }
        }
    }

    $data['balance'] = $balance;
    $data['attainment'] = $attainment;
    $data['degree'] = $degree;
    $data['profile'] = $profile;
    $data['skills'] = $newskill;
    $data['message'] = 'success';
    return response()->json($data);
}

public function updateName(Request $req){
    $id = Auth::user()->id;
    $profile = Profiles::where('user_id',$id)->first();
    $profile->fname = $req->fname;
    $profile->lname = $req->lname;
    $profile->save();
    $data['message'] = 'success';
    return response()->json($data);
}

public function getSetup(){
    $housekeeping = Skills::where('category_id',1)->get();
    $construction = Skills::where('category_id',2)->get();
    $personel = Skills::where('category_id',3)->get();
    $maintenance = Skills::where('category_id',4)->get();
    $degree = Degrees::all();

    return view('users.setup',compact('housekeeping','personel','maintenance','construction','degree'));
}

public function saveProfile(Request $request){
    $userid = Auth::user()->id;

    $profile = new Profiles;
    $profile->lname = Input::get("lastname");
    $profile->fname = Input::get("firstname");
    $profile->mobile = Input::get("mobile");
    $profile->biography = Input::get("aboutme");
    $profile->account_no = Input::get("account");
    $profile->key= Input::get("key");
    $profile->lat = Input::get("clat");
    $profile->long = Input::get("clong");
    $profile->user_id = $userid;
    $profile->save();

    $new_prof = Profiles::where('user_id',$userid)->firstOrFail();
    $profid = $new_prof->profile_id;

    $housekeep = Input::get('housekeeping');
    if(isset($housekeep[0])) {     
     foreach($housekeep as $hk){
        $house = new Prof_Skill;
        $house->profile_id = $profid;
        $house->skill_id = $hk;
        $house->save();
    }
}

$construction = $request['construction'];
if(isset($construction[0])){     
    foreach($construction as $ct){
        $construct = new Prof_Skill;
        $construct->profile_id = $profid;
        $construct->skill_id = $ct;
        $construct->save();
    } 
}

$personel = $request['personel'];
if(isset($personel[0])){     
 foreach($personel as $ps){
    $person = new Prof_Skill;
    $person->profile_id = $profid;
    $person->skill_id = $ps;
    $person->save();
}
}

$maintenance = $request['maintenance'];
if(isset($maintenance[0])){     
 foreach($maintenance as $mt){
    $mainte = new Prof_Skill;
    $mainte->profile_id = $profid;
    $mainte->skill_id = $mt;
    $mainte->save();        
}
}

// Education
$degree = Input::get('degrees');
$year = Input::get('year');
$school = Input::get('school');

return redirect()->route('user/home');
}

public function getWallet($id){

}

public function getLogs($id){

}

public function getSetupData(){

    $attainment = Attainment::all();
    $degree = Degrees::all();

    $data['attainment'] = $attainment;
    $data['degree'] = $degree;

    $data['status'] = "successful";
    return response()->json($data);
}

public function getDegree(Request $req){
    $attainment = $req->attainment_id;
    $field = Field_study::where('degree_id',$attainment)->get();

    $data['field'] = $field;
    $data['attainment'] = $attainment;

    $data['status'] = 'successful';

    return response()->json($data);
}

public function setEducation(Request $req){
    $attainment = $req->attainment;
    $school = $req->school;
    $start = $req->start;
    $end = $req->end;
    $degree = $req->degree;
    $field = $req->field;
    $userid = Auth::user()->id;
    $profile = Profiles::where('user_id',$userid)->first();

    $education = new Education;
    $prof_edu = new Prof_Edu;
    if($attainment == 1) //If Highschool
    {
       $education->attainment = $attainment;
       $education->school = $school;
       $education->start = $start;
       $education->end = $end;
       $education->save();
       $prof_edu->profile_id = $profile->user_id;
       $prof_edu->education_id = $education->education_id;
       $prof_edu->save();
       $data['saved'] = 'highschool';
   }
   else
   {
       $education->attainment = $attainment;
       $education->school = $school;
       $education->start = $start;
       $education->end = $end;
       $education->degree_id = $degree;
       $education->field_study = $field;    
       $education->save();
       $prof_edu->profile_id = $profile->user_id;
       $prof_edu->education_id = $education->education_id;
       $prof_edu->save();
       $data['saved'] = 'college';
   }
   $data['id'] = $education->education_id;
   $data['status'] = 'successful';

   return response()->json($data);
}

public function getEducation(){
    $userid = Auth::user()->id;
    $profile = Profiles::where('user_id',$userid)->first();
    $degree = Degrees::all();
    $field_study = Field_study::all();
    $prof_edu = Prof_Edu::where('profile_id',$profile->profile_id)->get();

    if(count($prof_edu) > 0){
        $data['hasEdu'] = "1";
        $predId = [];

        foreach($prof_edu as $pred){
            $predID[] = $pred->education_id;
        }
        
        $education = Education::whereIn('education_id',$predID)->get();
        $data['education'] = $education; 
    }
    else{
        $data['hasEdu'] = "0";
    }   
    $data['degree'] = $degree;
    $data['field'] = $field_study;
    return response()->json($data);
}

public function findEducation(Request $req){
 $edID = $req->education;

 $attainment = Attainment::all();
 $degree = Degrees::all();
 $education = Education::where('education_id',$edID)->first();
 $field_study = Field_study::where('degree_id',$education->degree_id)->get();

 if(count($education) > 0){
    $data['hasEdu'] = "1";
    $data['education'] = $education; 
}
else{
    $data['hasEdu'] = "0";
}
$data['attainment'] = $attainment;
$data['degree'] = $degree;
$data['field'] = $field_study;
return response()->json($data);
}

public function updateEducation(Request $req){
    $attainment = $req->attainment;
    $school = $req->school;
    $start = $req->start;
    $end = $req->end;
    $degree = $req->degree;
    $field = $req->field;
    $userid = Auth::user()->id;
    $profile = Profiles::where('user_id',$userid)->first();
    $educationID = $req->education;
    $education = Education::where('education_id',$educationID)->first();

    if($attainment == 1) //If Highschool
    {
       $education->attainment = $attainment;
       $education->school = $school;
       $education->start = $start;
       $education->end = $end;
       $education->save();
   }
   else
   {
       $education->attainment = $attainment;
       $education->school = $school;
       $education->start = $start;
       $education->end = $end;
       $education->degree_id = $degree;
       $education->field_study = $field;
       $education->save();
   }
   $data['id'] = $education;
   $data['status'] = 'successful';

   return response()->json($data);
}

public function removeEducation(Request $req){
    $edID = $req->education;

    $profed = Prof_Edu::where('education_id',$edID)->first();
    $profed->delete();
    $education = Education::where('education_id',$edID)->first();
    $education->delete();

    $data['deleted'] = 1;
    return response()->json($data);
}

public function setWork(Request $req){
    $work = $req->work;
    $year = $req->year;
    $employer = $req->employer;

    $userid = Auth::user()->id;
    $profile = Profiles::where('user_id',$userid)->first();

    $experience = new Experiences;
    $experience->job_title = $work;
    $experience->employer = $employer;
    $experience->year = $year;
    $experience->save();

    $prof_exp = new Prof_Exp;
    $prof_exp->profile_id = $profile->profile_id;
    $prof_exp->experience_id = $experience->experience_id;
    $prof_exp->save();

    $data['status'] = 'successful';
    return response()->json($data);
}

public function getWork(){
    $userid = Auth::user()->id;
    $profile = Profiles::where('user_id',$userid)->first();

    $prof_exp = Prof_Exp::where('profile_id',$profile->profile_id)->get();
    if(count($prof_exp) > 0){
        $data['hasWork'] = 1;
        $expid = [];

        foreach($prof_exp as $pe){
            $expid[] = $pe->experience_id;
        }

        $experience = Experiences::whereIn('experience_id',$expid)->get();
        $data['experience'] = $experience;
    }
    else{
        $data['hasWork'] = 0;        
    }

    return response()->json($data);
}

public function findWork(Request $req){
    $expid = $req->work;
    $experience = Experiences::where('experience_id',$expid)->first();
    $data['experience'] = $experience;
    return response()->json($data);
}

public function removeWork(Request $req){
    $expid = $req->experience;
    
    $prof_exp = Prof_Exp::where('experience_id',$expid)->first();
    $prof_exp->delete();

    $experience = Experiences::where('experience_id',$expid)->first();
    $experience->delete();

    $data['Deleted'] = '1';
    $data['profexp'] = $prof_exp;
    return response()->json($data);
}

public function updateWork(Request $req){
    $work = $req->work;
    $year = $req->year;
    $employer = $req->employer;
    $id = $req->id;

    $experience = Experiences::where('experience_id',$id)->first();
    $experience->job_title = $work;
    $experience->employer = $employer;
    $experience->year = $year;
    $experience->save();

    $data['status'] = 'successful';
    return response()->json($data);
}

public function setVerification(Request $req){
   $skills = [];
   $skills[] = $req->skills;

   $id = Auth::user()->id;
   $profile = Profiles::where('user_id',$id)->first();

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

$mobile = $req->mobile;
$bytes = random_bytes(2);
$code = bin2hex($bytes);

$hasCode = Prof_mobile::where('profile_id',$profile->profile_id)->first();
$username = Auth::user()->username;
if(count($hasCode) > 0){
    $data['status'] = 'has code already';
}
else{
    $prof_mob = new Prof_mobile;
    $prof_mob->code = $code;
    $prof_mob->is_verified = 0;
    $prof_mob->profile_id = $profile->profile_id;
    $prof_mob->save();

    $message ="Hi". " " .$username."! Your verification code is" . " ".$code . " --Thank you for supporting JobPlus!";

    $config = [
    'shortcode'=> '292902017',
    'client_id'=> 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0',
    'secret_key'=> 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612',
    ];

    $chikka = new Chikka($config);
    $resp = $chikka->send($mobile, $message);
    $data['code'] = 'code sent';
}
// $data['code'] = $code;
return response()->json($data);
}

public function getVerification(Request $req){
    $code = $req->code;

    $id = Auth::user()->id;
    $profile = Profiles::where('user_id',$id)->first();

    $prof_mob = Prof_mobile::where('profile_id',$profile->profile_id)->first();
    if($prof_mob->code == $code){
        $prof_mob->is_verified = 1;
        $prof_mob->save();
        $data['status'] = 1;
    }
    else{
        $data['status'] = 0;
    }

    return response()->json($data);
}

public function setStep1(Request $req){


    $mobile = $req->mobile;
    $fname = $req->fname;
    $lname = $req->lname;
    $address = $req->address;
    $about = $req->about;

    $id = Auth::user()->id;
    $profile = Profiles::where('user_id',$id)->first();
    $profile->lname = $lname;
    $profile->fname = $fname;
    $profile->address = $address;
    $profile->mobile = $mobile;
    $profile->biography = $about;
    $profile->save();

    $data['saved'] = 1;
    return response()->json($data);
}

public function resendCode(Request $request){
    $userid = Auth::user()->id;
    $mobile = $request->mobile;
    $username = Auth::user()->username;
    $profile = Profiles::Where('user_id',$userid)->first();
    $profile->mobile = $mobile;
    $profile->save();

    $bytes = random_bytes(2);
    $code = bin2hex($bytes);
    $prof_mob = Prof_mobile::where('profile_id',$profile->profile_id)->first();
    $prof_mob->code = $code;
    $prof_mob->save();

    $message ="Hi". " " .$username."! Your verification code is" . " ".$code . " --Thank you for supporting JobPlus!";

    $config = [
    'shortcode'=> '292902017',
    'client_id'=> 'b00de5e0839604cdfe07a9e7b5e6c8127ef4bf36ab3b44c0b287ae0603a678c0',
    'secret_key'=> 'aed7fabd8a0864f8c5a61b5f4dfb4fd3d1737e81d792ff22a3639748391d3612',
    ];

    $chikka = new Chikka($config);
    $resp = $chikka->send($mobile, $message);
    $data['status'] = 200;
    $data['resp'] = $resp;
    return response()->json($data);
}

}
