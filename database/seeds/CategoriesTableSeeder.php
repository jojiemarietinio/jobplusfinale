<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
        [
        	'name' => 'Household'
        ],
        [
            'name' => 'Construction'
        ],
        [
            'name' => 'Personel'
        ],
        [
            'name' => 'Maintenance'
        ]
    ];

        DB::table('categories')->insert($category);
    }
}
