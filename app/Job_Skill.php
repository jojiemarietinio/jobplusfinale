<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_Skill extends Model
{
   protected $table = 'job_skills';
   public $timestamps = false;

   public function skills(){
        return $this->hasMany('App\Skills');
   }
    public function jobs(){
        return $this->belongsTo('App\Jobs','job_id');
    }
}
