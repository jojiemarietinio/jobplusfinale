<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    public $timestamps = false;  
    protected $primaryKey =  'id';


    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
