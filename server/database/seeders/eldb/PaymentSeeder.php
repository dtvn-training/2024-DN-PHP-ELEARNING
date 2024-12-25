<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            ['payment_description' => 'Payment for Course 1', 'payment_amount' => 100, 'transaction_id' => 'txn_001', 'user_id' => 1],
            ['payment_description' => 'Payment for Course 2', 'payment_amount' => 200, 'transaction_id' => 'txn_002', 'user_id' => 2],
            ['payment_description' => 'Payment for Course 3', 'payment_amount' => 300, 'transaction_id' => 'txn_003', 'user_id' => 3],
        ]);
    }
}
