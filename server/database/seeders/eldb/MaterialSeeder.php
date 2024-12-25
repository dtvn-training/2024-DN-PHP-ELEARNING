<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materials')->insert([
            ['material_content' => 'Video Content 1', 'type_id' => 1, 'lesson_id' => 1],
            ['material_content' => 'Text Content 1', 'type_id' => 2, 'lesson_id' => 2],
            ['material_content' => 'PDF Content 1', 'type_id' => 3, 'lesson_id' => 3],
        ]);
    }
}
