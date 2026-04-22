<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("types")->insert([
            [
                'id' => 1, 
                'name' => 'Souvenir',
                'image_url' => '1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2, 
                'name' => 'Plakat',
                'image_url' => '2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3, 
                'name' => 'Stempel',
                'image_url' => '3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4, 
                'name' => 'Booth',
                'image_url' => '4.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5, 
                'name' => 'Printing',
                'image_url' => '5.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 0, 
                'name' => 'Others',
                'image_url' => '6.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
