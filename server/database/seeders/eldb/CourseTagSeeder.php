<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTagSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_tag')->insert([
            ['course_id' => 1, 'tag_id' => 1],
            ['course_id' => 1, 'tag_id' => 2],
            ['course_id' => 2, 'tag_id' => 3],
            ['course_id' => 3, 'tag_id' => 4],
        ]);
    }
}
