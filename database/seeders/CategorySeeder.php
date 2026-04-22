<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1, 
                'type_id' => 1, 
                'name' => 'Tumbler',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
