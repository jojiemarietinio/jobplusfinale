<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_Type extends Model
{
	protected $table = 'job_type';
	protected $primaryKey = 'jobtype_id';
	public $timestamps = false;
}
