<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$status =[
    	[
    		'name' => 'Pending'
    	],
    	[
    		'name' => 'Active'
    	],
    	[
    		'name' => 'Ongoing'
    	],
    	[
    		'name' => 'Ended'
    	]];
    	
        DB::table('status')->insert($status);
    }
}
