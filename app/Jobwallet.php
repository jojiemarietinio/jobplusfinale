<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobwallet extends Model
{
    protected $table = 'jobwallet';
    public $timestamps = false;  
    protected $primaryKey =  'id';


    public function users(){
        return $this->belongsTo('App\User','user_id');
    }
}
