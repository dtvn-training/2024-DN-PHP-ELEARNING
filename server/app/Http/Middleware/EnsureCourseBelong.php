<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GetCourseBelongModel;
use Illuminate\Support\Facades\Validator;

class EnsureCourseBelong
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
            'course_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $aid = $request->session()->get('aid');
        $courseId = $validator->validated()['course_id'];

        if (!$aid) {
            return response()->json(['message' => 'Unauthorized: Authentication required.'], 401);
        }

        $doesBelong = GetCourseBelongModel::execute($aid, $courseId);
        if (!$doesBelong) {
            return response()->json(['message' => 'Forbidden: You do not own this course.'], 403);
        }

        return $next($request);
    }
}
