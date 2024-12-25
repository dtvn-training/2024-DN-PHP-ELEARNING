<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('enrollments')->insert([
            ['enrollment_date' => now(), 'enrollment_is_complete' => true, 'course_id' => 1, 'user_id' => 1],
            ['enrollment_date' => now(), 'enrollment_is_complete' => false, 'course_id' => 2, 'user_id' => 2],
            ['enrollment_date' => now(), 'enrollment_is_complete' => true, 'course_id' => 3, 'user_id' => 3],
        ]);
    }
}
