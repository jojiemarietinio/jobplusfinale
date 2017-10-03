<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $skills = [
        [
        	"category_id" => 1,       
        	"name"	=> 'Dishwasher'
	    ],
        [
        	"category_id" => 1,
        	"name"	=>'Housekeeper'
        ],
        [
        	"category_id" => 1,
        	"name"	=>'Child Care Worker'
	   ],
       [

        	"category_id" => 1,
        	"name"	=> 'Laundry and Dry Cleaning'
	   ],
       [
        	"category_id" => 2,
        	"name"	=>'Carpenter'
	   ],
       [
        	"category_id" => 2,
        	"name"	=>'Painter'
	   ],
       [
		
        	"category_id" => 2,
        	"name"	=>'Masonry'
	]	,[

        	"category_id" => 2,
        	"name"	=>'Cutter'
	]	,[
		
        	"category_id" => 2,
        	"name"	=> 'Tile and Marble Setter'
	]	,[

        	"category_id" => 2,
        	"name"	=>'Molding and Casting'
	]	,[

        	"category_id" => 2,
        	"name"	=> 'Upholsterer'
	]	,[
        	"category_id" => 3,
        	"name"	=>'Sales Clerk'
	]	,[

        	"category_id" => 3,
        	"name"	=> 'Promo Dicer'
	]
		,[
        	"category_id" => 3,
        	"name"	=> 'Waiter/Waitress'
	]	,[
		
        	"category_id" => 3,
        	"name"	=>'Dishwasher'
	]	,[
		

        	"category_id" => 3,
        	"name"	=> 'Retailer'
	]	,[
		

        	"category_id" => 3,
        	"name"	=>'Driver'
	]	,[

        	"category_id" => 3,
        	"name"	=>'Cook'
	]	,[

        	"category_id" => 4,
        	"name"	=>'Plumber'
	]	,[
		

        	"category_id" => 4,
        	"name"	=>'Automotive Technician'
	]	,[
		

        	"category_id" => 4,
        	"name"	=>'Appliance Technician'
	]	,[
		

        	"category_id" => 4,
        	"name"	=>'Electrician'
	]];
		
 DB::table('skills')->insert($skills);
    
    }
}
