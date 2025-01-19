<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseFeedbackSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_feedback')->insert([
            ['course_feedback_description' => 'Great course!', 'enrollment_id' => 1],
            ['course_feedback_description' => 'Very informative.', 'enrollment_id' => 2],
            ['course_feedback_description' => 'Loved the lessons.', 'enrollment_id' => 3],
        ]);
    }
}
