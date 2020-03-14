<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Staters',
                'image' => 'mushrooms.jpg',
                'display_order' => 1
            ],
            [
                'name' => 'Salads',
                'image' => 'salad.jpg',
                'display_order' => 2
            ],
            [
                'name' => 'Entrees',
                'image' => 'burger.jpg',
                'display_order' => 3
            ],
        ]);
    }
}