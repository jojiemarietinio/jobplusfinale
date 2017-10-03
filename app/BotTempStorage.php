<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BotTempStorage extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "bot_temp_storage";
    protected $fillable = ['facebook_id', 'job_id', 'user_id', 'reason', 'tracker'];
    //
}
