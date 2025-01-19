<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonModifyController
{
    protected LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Modify a lesson.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'lesson_id' => 'required|int',
                'lesson_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }
            
            $isModified = $this->lesson->modify($validator->validated());

            if ($isModified) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Lesson modified successfully.',
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to modify the lesson or no changes were made.',
            ], 400);
        } catch (Exception $e) {
            Log::error('Error modifying lesson: ', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
