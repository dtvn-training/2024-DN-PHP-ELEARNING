<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginModel
{
    /**
     * Verify account and password, and return the authentication ID (aid).
     *
     * @param string $account
     * @param string $password
     * @return int|null
     */
    public function authenticate(string $account, string $password): ?int
    {
        // Fetch user record by account
        $user = DB::table('authentications')
            ->where('account', $account)
            ->where('authentication_state', true)
            ->where('deleted_flag', false)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user->authentication_id;
        }
        
        return null;
    }
}
