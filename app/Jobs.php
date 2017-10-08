<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Prof_Skill;
use App\Profile;
use App\Category;


class Jobs extends Model 
{
    protected $table = 'jobs';
    protected $dates = ['start', 'end'];
    public $timestamps = false;  
    protected $primaryKey =  'job_id';
    protected $fillable = ['job_type_id', 'category_id', 'skill_id', 'title', 'description', 'address_id', 'start_date', 'end_date', 'slot',  'salary', 'paytype', 'is_all_day'];

    public function skills()
    {
    	return $this->hasManyThrough('App\Skills','App\Job_Skill','job_id','skill_id');
    }

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }
    public function categories(){
        return $this->belongsTo('App\Categories','category_id');
    }
    public function jobtypes(){
        return $this->belongsTo('App\Job_Type','job_type_id');
    }
    public function paytypes(){
        return $this->belongsTo('App\Paytypes','paytype');
    }
    public function address(){
        return $this->belongsTo('App\Job_Address','address_id');
    }

    // public function getRecommendedApplicants() {
    //     // $job = $this->where('job_id', 1);

    //     return 'Hello world!';
    // }

}
