<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
        protected $primaryKey = 'schedule_id';
    	protected $table = 'schedules';
        public $timestamps = false;  
    	protected $fillable =[
    		'job_id',
    		'start',
    		'end'
    	];

   public function jobs(){
        return $this->belongsTo('App\Jobs','job_id');
    }

}

