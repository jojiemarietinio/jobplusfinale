<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $primaryKey = 'application_id';
    protected $table = 'application';
    public $timestamps = false;

     public function users(){
        return $this->belongsTo('App\User','applicant');
    }
    public function jobs(){
        return $this->belongsTo('App\Jobs','job');
    }
}
