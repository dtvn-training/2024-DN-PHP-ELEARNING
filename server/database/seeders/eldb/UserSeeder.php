<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_first_name' => 'John',
                'user_last_name' => 'Doe',
                'user_alias' => 'johndoe',
                'user_gender' => true,
                'user_email' => 'john@example.com',
                'user_phone_number' => '1234567890',
                'user_address' => '123 Main St',
                'user_state' => true,
                'authentication_id' => 1,
            ],
            [
                'user_first_name' => 'Jane',
                'user_last_name' => 'Smith',
                'user_alias' => 'janesmith',
                'user_gender' => false,
                'user_email' => 'jane@example.com',
                'user_phone_number' => '2345678901',
                'user_address' => '456 Oak St',
                'user_state' => true,
                'authentication_id' => 2,
            ],
            [
                'user_first_name' => 'Alice',
                'user_last_name' => 'Johnson',
                'user_alias' => 'alicejohnson',
                'user_gender' => false,
                'user_email' => 'alice@example.com',
                'user_phone_number' => '3456789012',
                'user_address' => '789 Pine St',
                'user_state' => true,
                'authentication_id' => 3,
            ],
        ]);
    }
}
