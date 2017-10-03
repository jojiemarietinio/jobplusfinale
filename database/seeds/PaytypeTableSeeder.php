<?php

use Illuminate\Database\Seeder;

class PaytypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$mop =[[
    	'name' => 'Hourly'
    	],
    	[
    	'name' => 'Daily'
    	],
    	[
    	'name' => 'Per Project'
    	]];
        DB::table('paytypes')->insert($mop);
    }
}
