<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //use Illuminate\Auth\Authenticatable;
    use Messagable;
    protected $table ='users';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
        return $this->hasOne('App\Profiles');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transactions');
    }

    public function chats(){
        return $this->hasMany('App\Chat');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

}