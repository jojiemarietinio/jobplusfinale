<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paytypes extends Model
{
    	protected $table = 'paytypes';
    	protected $primaryKey= 'paytype_id';
    	public $timestamps = false;
}
