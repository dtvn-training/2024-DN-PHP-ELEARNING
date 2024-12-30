<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutController
{
    /**
     * Handle logout requests.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->session()->forget('aid');
            $request->session()->flush();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logout successful',], 200);
        } catch (Exception $e) {
            Log::error("Logout error:" . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.',], 500);
        }
    }
}
