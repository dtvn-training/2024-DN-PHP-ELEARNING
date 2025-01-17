<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tags')->insert([
            ['tag_description' => 'Technology'],
            ['tag_description' => 'Science'],
            ['tag_description' => 'Health'],
            ['tag_description' => 'Education'],
            ['tag_description' => 'Business'],
        ]);
    }
}
