<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonListController
{
    protected LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Handle view course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        try {
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
            
            $course_id = $validator->validated()['course_id'];
            
            $lessons = $this->lesson->list($course_id);

            return response()->json(['lessons' => $lessons ?: []], 200);
        } catch (Exception $e) {
            Log::error("Error fetching lesson details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
