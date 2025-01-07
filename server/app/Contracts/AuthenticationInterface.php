<?php

namespace App\Contracts;

interface AuthenticationInterface
{
    public function login(string $account, string $password): ?int;
}
