<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpNoti extends Model
{
    
	protected $table = 'emp_notifications';

  
    	public function user()
    	{
    		return $this->belongsTo('User');
    	}
}
