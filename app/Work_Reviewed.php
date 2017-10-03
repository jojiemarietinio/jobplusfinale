<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_Reviewed extends Model
{
	protected $table = 'work_reviewed';
	public $timestamps = false;  
	protected $primaryKey =  'id';

	public function works(){
		return $this->belongsTo('App\Works','work_id');
	}
}
