<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materials')->insert([
            ['material_content' => 'test_video.mp4', 'type_id' => 1, 'lesson_id' => 1],
            ['material_content' => 'test_image.png', 'type_id' => 2, 'lesson_id' => 1],
            ['material_content' => '# This is very long text', 'type_id' => 3, 'lesson_id' => 1],
        ]);
    }
}
