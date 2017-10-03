<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(CategoriesTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(DegreeTableSeeder::class);
        $this->call(PaytypeTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
