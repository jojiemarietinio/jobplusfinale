<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_nearby extends Model
{
	protected $table = 'job_nearby';
	public $timestamps = false;

	 public function jobs(){
        return $this->belongsTo('App\Jobs','job_id');
    }
}
