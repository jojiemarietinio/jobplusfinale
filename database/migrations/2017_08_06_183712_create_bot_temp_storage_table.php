<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotTempStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_temp_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracker');
            $table->unsignedBigInteger('facebook_id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('custom_field')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bot_temp_storage');
    }
}
