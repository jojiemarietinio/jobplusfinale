<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prof_Exp extends Model
{
   	protected $primaryKey = 'profexp_id';
    protected $table= 'prof_experiences';
    public $timestamps = false;

    protected $fillable =[
    'profile_id',
    'experience_id'
    ];
}
