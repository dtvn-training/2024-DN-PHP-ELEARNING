<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemFeedbackSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_feedback')->insert([
            ['system_feedback_description' => 'System is easy to use.', 'user_id' => 1],
            ['system_feedback_description' => 'Great UI!', 'user_id' => 2],
            ['system_feedback_description' => 'Highly responsive.', 'user_id' => 3],
        ]);
    }
}
