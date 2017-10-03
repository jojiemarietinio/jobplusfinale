<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Review extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_review';
    public $timestamps = false;
}
