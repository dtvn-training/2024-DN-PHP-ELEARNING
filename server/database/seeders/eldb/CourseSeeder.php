<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'course_name' => 'Intro to Technology',
                'course_description' => 'Learn the basics of technology.',
                'course_price' => 100,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Advanced Science',
                'course_description' => 'Explore advanced scientific concepts.',
                'course_price' => 200,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Health and Wellness',
                'course_description' => 'Tips for maintaining good health.',
                'course_price' => 300,
                'course_state' => true,
                'user_id' => 2,
            ],
        ]);
    }
}
