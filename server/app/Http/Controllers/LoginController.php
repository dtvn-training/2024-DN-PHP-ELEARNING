<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController
{
    protected $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    /**
     * Handle login requests.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'account' => 'required|string|max:1000',
                'password' => 'required|string|max:1000',
            ]);

            $account = $request->input('account');
            $password = $request->input('password');

            $aid = $this->loginModel->authenticate($account, $password);

            if ($aid) {
                session()->put('aid', $aid);
                return response()->json(['message' => 'Login successful'], 200);
            }

            return response()->json(['message' => 'Invalid account or password'], 401);
        } catch (Exception $e) {
            Log::error("Login error: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}