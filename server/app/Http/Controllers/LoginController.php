<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\AuthenticationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController
{
    protected AuthenticationInterface $authentication;

    public function __construct(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Handle login requests.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'account' => 'required|string|max:255',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $account = $request->input('account');
            $password = $request->input('password');
            
            $aid = $this->authentication->login($account, $password);

            if ($aid) {
                session()->put('aid', $aid);
                return response()->json(['message' => 'Login successful'], 200);
            }

            return response()->json(['message' => 'Invalid account or password'], 401);
        } catch (\Exception $e) {
            Log::error("Login error: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
