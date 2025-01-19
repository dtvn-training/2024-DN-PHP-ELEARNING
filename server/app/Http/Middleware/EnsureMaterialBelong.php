<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GetMaterialBelongModel;
use Illuminate\Support\Facades\Validator;

class EnsureMaterialBelong
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $aid = $request->session()->get('aid');
        $materialId = $validator->validated()['material_id'];

        if (!$aid) {
            return response()->json(['message' => 'Unauthorized: Authentication required.'], 401);
        }

        $doesBelong = GetMaterialBelongModel::execute($aid, $materialId);
        if (!$doesBelong) {
            return response()->json(['message' => 'Forbidden: You do not own this material.'], 403);
        }

        return $next($request);
    }
}
