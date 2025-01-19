<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonViewController
{
    protected LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * View a lesson.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'lesson_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $lesson_id = $validator->validated()['lesson_id'];

            $lesson = $this->lesson->view($lesson_id);

            if ($lesson) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Lesson retrieved successfully.',
                    'lesson' => $lesson,
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve the lesson or no data found.',
            ], 404);
        } catch (Exception $e) {
            Log::error('Error viewing lesson: ', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
