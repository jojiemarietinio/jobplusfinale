<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_Logs extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'work_logs';
    public $timestamps = false;
}
