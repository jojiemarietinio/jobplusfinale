<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('job_id');
            $table->integer('user_id');
            $table->string('category_id');            
            $table->integer('skill_id');
            $table->string('description');
            $table->string('lat');
            $table->string('long');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('paytype');
            $table->float('salary');
            $table->boolean('is_all_day');
            $table->integer('slot');
            $table->date('date_posted');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::drop('jobs');
    }
}
