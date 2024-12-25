<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grades')->insert([
            ['grade_number' => 85, 'enrollment_id' => 1, 'lesson_id' => 1],
            ['grade_number' => 90, 'enrollment_id' => 2, 'lesson_id' => 2],
            ['grade_number' => 95, 'enrollment_id' => 3, 'lesson_id' => 3],
        ]);
    }
}
