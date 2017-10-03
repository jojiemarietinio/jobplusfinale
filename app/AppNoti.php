<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppNoti extends Model
{
    	protected $table = 'app_notifications';

    
    	public function user()
    	{
    		return $this->belongsTo('User');
    	}
}
