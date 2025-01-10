<?php

namespace App\Repositories;

use App\Contracts\AuthenticationInterface;
use App\Models\LoginModel;

class AuthenticationRepository implements AuthenticationInterface
{
    protected LoginModel $loginModel;

    public function __construct(LoginModel $loginModel)
    {
        $this->loginModel = $loginModel;
    }

    /**
     * Verify account and password, and return the authentication ID (aid).
     */
    public function login(string $account, string $password): ?int
    {
        return $this->loginModel->login($account, $password);
    }
}
