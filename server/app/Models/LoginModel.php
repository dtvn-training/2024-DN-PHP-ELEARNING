<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginModel
{
    /**
     * Verify account and password, and return the authentication ID (aid).
     */
    public function authenticate(string $account, string $password): ?int
    {
        $user = DB::table('authentications')
            ->select(['authentication_id', 'password'])
            ->where('account', $account)
            ->where('authentication_state', true)
            ->where('deleted_flag', false)
            ->first();

        if (
            $user
            && property_exists($user, 'password')
            && property_exists($user, 'authentication_id')
            && (is_string($user->password)
                && Hash::check($password, $user->password))
        ) {
            return is_numeric($user->authentication_id) ? (int) $user->authentication_id : null;
        }

        return null;
    }
}
