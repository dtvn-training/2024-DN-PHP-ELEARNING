<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GetRoleModel;

class EnsureRoleTeacher
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
        $aid = $request->session()->get('aid');
        $role = GetRoleModel::execute($aid);

        if ($role !== "TEACHER") {
            return response()->json(['message' => 'Forbidden: Only teacher can access this.'], 403);
        }
        
        return $next($request);
    }
}
