<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCal extends Model
{

	protected $table = 'app_calendars'

      public function work()
    {
        return $this->hasMany('Works');   
    }

    	public function user()
    	{
    		return $this->belongsTo('User');
    	}
}
