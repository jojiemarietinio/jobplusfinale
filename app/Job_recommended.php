<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_recommended extends Model
{
   protected $table = 'job_recommended';
   public $timestamps = false;

    public function jobs(){
        return $this->belongsTo('App\Jobs','job_id');
    }
}
