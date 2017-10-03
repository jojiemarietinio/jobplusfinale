<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
   protected $primaryKey = 'review_id';
	protected $table = 'reviews';
	public $timestamps = false;
	protected $fillable =[
		'rating',
		'comment',
		'reviewed_id',
		'reviewer_id',
		'work_id'
	];

	 public function applicant(){
        return $this->belongsTo('App\User','reviewed_id');
    }
    public function employer(){
        return $this->belongsTo('App\User','reviewer_id');
    }
    public function work(){
        return $this->belongsTo('App\Works','work_id');
    }
}
