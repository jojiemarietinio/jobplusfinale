<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
        protected $table = 'profiles';
        public $timestamps = false;
        protected $primaryKey = 'profile_id';
    protected $fillable =[
        'user_id',
        'lname',
        'fname',
        'mobile',
        'account_no',
        'key',
        'lat',
        'long',
        'biography'
    ];

  

}
 