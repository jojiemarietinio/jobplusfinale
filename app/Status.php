<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
	protected $primaryKey = 'status_id';
    protected $table = 'status';
   	protected $fillable =[
   	'name'
   	];
}
