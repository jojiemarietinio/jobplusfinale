<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    	protected $primaryKey = 'education_id';
    protected $table= 'education';
    public $timestamps = false;

    protected $fillable =[
	    'degree_id',
	    'school',
	    'year'
    ];


}
