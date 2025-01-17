<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authorizations')->insert([
            ['authorization_role' => 'ADMIN'],
            ['authorization_role' => 'TEACHER'],
            ['authorization_role' => 'STUDENT'],
        ]);
    }
}
