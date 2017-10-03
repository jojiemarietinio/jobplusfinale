<?php

use Illuminate\Database\Seeder;

class DegreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degree =[[
    	'name' => 'Highschool'
    	],
    	[
    	'name' => 'College'
    	]];
        DB::table('degrees')->insert($degree);
    }
}
