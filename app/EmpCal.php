<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpCal extends Model
{
    	protected $table = 'emp_calendars';

    
      public function work()
    {
        return $this->hasMany('Works');   
    }

    	public function user()
    	{
    		return $this->belongsTo('User');
    	}
}
