<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_feeds extends Model
{
	protected $table = 'job_feeds';
	public $timestamps = false;

	public function jobs(){
		return $this->belongsTo('App\Jobs','job_id');
	}
}
