<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prof_Edu extends Model
{
  	protected $primaryKey = 'profedu_id';
    protected $table= 'prof_educations';
    public $timestamps = false;

    protected $fillable =[
    'profile_id',
    'education_id'
    ];
}
