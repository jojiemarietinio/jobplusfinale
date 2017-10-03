<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
        	 [	'job_id' => 8,
        	'user_id' => 2,
        	'category_id' => 4,
        	'skill_id' => 19,
        	'description' => 'A nice description',
        	'lat' => 10.338055962488454,
        	'long' => 123.94646644592285,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 2,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'We need a Plumber '
        	],
        	 [	'job_id' => 9,
        	'user_id' => 2,
        	'category_id' => 3,
        	'skill_id' => 14,
        	'description' => 'Second nice description',
        	'lat' => 10.339575830539369,
        	'long' => 123.93432140350342,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 1,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'Need Waiter'
        	]
        	, [	'job_id' => 10,
        	'user_id' => 2,
        	'category_id' => 2,
        	'skill_id' => 5,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 1,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'Need Carpenter'
        	]
        	, [	'job_id' => 11,
        	'user_id' => 2,
        	'category_id' => 3,
        	'skill_id' => 13,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 2,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for a Promo Dicer'
        	]
        	, [	'job_id' => 12,
        	'user_id' => 2,
        	'category_id' => 2,
        	'skill_id' => 6,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 3,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for a good construction worker'
        	]
        	, [	'job_id' => 13,
        	'user_id' => 2,
        	'category_id' => 4,
        	'skill_id' => 22,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 2,
        	'salary' => 1500,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for Electrician'
        	]
        	, [	'job_id' => 14,
        	'user_id' => 2,
        	'category_id' => 3,
        	'skill_id' => 17,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 2,
        	'salary' => 800,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for a driver'
        	]
        	, [	'job_id' => 15,
        	'user_id' => 2,
        	'category_id' => 3,
        	'skill_id' => 18,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 1,
        	'salary' => 300,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for a good cook'
        	]
        	, [	'job_id' => 16,
        	'user_id' => 2,
        	'category_id' => 1,
        	'skill_id' => 3,
        	'description' => 'We all deserve this one good description to fit your lorem ipsum',
        	'lat' => 10.317338,
        	'long' => 123.892235,
        	'start_date' => '2016-10-27 11:00:00',
        	'end_date' => '2016-10-28 10:00:00',
        	'paytype' => 1,
        	'salary' => 400,
        	'is_all_day' => 0,
        	'slot' => 1,
        	'date_posted' => '2016-10-20',
        	'title' => 'looking for a good Yaya'
        	]];
        DB::table('jobs')->insert($jobs);
    }
}
