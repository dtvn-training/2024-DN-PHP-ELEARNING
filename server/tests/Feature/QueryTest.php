<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

class QueryTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Test the full lifecycle: create authentication, create user, read user, update user, delete user, and delete authentication.
     *
     * @return void
     */
    public function test_user_authentication_crud()
    {
        // Step 1: Create Authentication
        $authentication = DB::table('authentications')->insertGetId([
            'account' => DB::raw("AES_ENCRYPT('test_account', 'encryption_key')"),
            'password' => DB::raw("AES_ENCRYPT('test_password', 'encryption_key')"),
            'indentifer_email' => DB::raw("AES_ENCRYPT('test_user@example.com', 'encryption_key')"),
            'authentication_state' => true,
            'authorization_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertNotNull($authentication, 'Authentication record should be created.');
        echo "1. Authentication created with ID: $authentication\n";

        // Step 2: Create User linked to Authentication
        $user = DB::table('users')->insertGetId([
            'user_first_name' => 'test',
            'user_last_name' => 'test',
            'user_alias' => 'test',
            'user_gender' => true,
            'user_email' => 'test@example.com',
            'user_phone_number' => '1234567890',
            'user_address' => '123 Main St',
            'user_state' => true,
            'authentication_id' => $authentication,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertNotNull($user, 'User record should be created.');
        echo "2. User created with ID: $user\n";

        // Step 3: Read User
        $retrievedUser = DB::table('users')->where('user_id', $user)->first();
        $this->assertEquals('test', $retrievedUser->user_first_name, 'User first name should match.');
        $this->assertEquals('test', $retrievedUser->user_last_name, 'User last name should match.');
        echo "3. User retrieved: " . json_encode($retrievedUser) . "\n";

        // Step 4: Update User
        DB::table('users')->where('user_id', $user)->update([
            'user_first_name' => 'Jane',
            'user_last_name' => 'Smith',
            'updated_at' => now(),
        ]);

        $updatedUser = DB::table('users')->where('user_id', $user)->first();
        $this->assertEquals('Jane', $updatedUser->user_first_name, 'User first name should be updated.');
        $this->assertEquals('Smith', $updatedUser->user_last_name, 'User last name should be updated.');
        echo "4. User updated: " . json_encode($updatedUser) . "\n";

        // Step 5: Delete User
        $deletedUser = DB::table('users')->where('user_id', $user)->delete();
        $this->assertEquals(1, $deletedUser, 'User record should be deleted.');
        echo "5. User with ID $user deleted successfully.\n";

        // Step 6: Delete Authentication
        $deletedAuthentication = DB::table('authentications')->where('authentication_id', $authentication)->delete();
        $this->assertEquals(1, $deletedAuthentication, 'Authentication record should be deleted.');
        echo "6. Authentication with ID $authentication deleted successfully.\n";
    }
}
