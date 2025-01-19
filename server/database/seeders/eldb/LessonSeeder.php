<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lessons')->insert([
            ['lesson_name' => 'Lesson 1', 'course_id' => 1],
            ['lesson_name' => 'Lesson 2', 'course_id' => 2],
            ['lesson_name' => 'Lesson 3', 'course_id' => 3],
        ]);
    }
}
