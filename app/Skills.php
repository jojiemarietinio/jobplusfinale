<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
	protected $table = 'skills';
	protected $primaryKey = 'skill_id';

	public function job(){
		return $this->hasMany('App\Jobs','skill_id');
	}

     public function category()
    {
        return $this->belongsTo('Categories');
    }

}
