<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;

class LoginModel
{
    /**
     * Verify account and password, and return the authentication ID (aid).
     */
    public function login(string $account, string $password): ?int
    {
        $user = Authentication::where('account', $account)
            ->where('authentication_state', true)
            ->where('deleted_flag', false)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            $user->createToken('Login Token')->plainTextToken;
            return $user->authentication_id;
        }

        return null;
    }
}
