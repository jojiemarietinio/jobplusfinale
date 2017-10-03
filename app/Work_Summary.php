<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_Summary extends Model
{
    protected $primaryKey = 'summary_id';
	protected $table = 'work_summary';
	public $timestamps = false;

	public function works(){
		return $this->belongsTo('App\Works','work_id');
	}
}
