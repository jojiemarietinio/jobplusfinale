<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prof_Skill extends Model
{
	protected $primaryKey = 'id';
    protected $table= 'prof_skills';
    public $timestamps = false;

    protected $fillable =[
    'profile_id',
    'skill_id'
    ];
}
