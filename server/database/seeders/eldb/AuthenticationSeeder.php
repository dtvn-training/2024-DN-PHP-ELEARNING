<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authentications')->insert([
            [
                'account' => 'admin_account',
                'password' => Hash::make('admin_password'),
                'indentifer_email' => 'admin@example.com',
                'authentication_state' => true,
                'authorization_id' => 1,
            ],
            [
                'account' => 'teacher_account',
                'password' => Hash::make('teacher_password'),
                'indentifer_email' => 'teacher@example.com',
                'authentication_state' => true,
                'authorization_id' => 2,
            ],
            [
                'account' => 'student_account',
                'password' => Hash::make('student_password'),
                'indentifer_email' => 'student@example.com',
                'authentication_state' => true,
                'authorization_id' => 3,
            ],
            [
                'account' => 'teacher_account_2',
                'password' => Hash::make('teacher_password'),
                'indentifer_email' => 'teacher2@example.com',
                'authentication_state' => true,
                'authorization_id' => 2,
            ],
        ]);
    }
}
