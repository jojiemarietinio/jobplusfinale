<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_Cancelled extends Model
{
    protected $table = "job_cancelled";
    protected $fillable = ['job_id', 'user_id', 'reason'];
}
