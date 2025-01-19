<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonCreateController
{
    protected LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Handle create lesson requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|string|max:255',
                'lesson_name' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $lesson_id = $this->lesson->create($validator->validated());

            if ($lesson_id) {
                return response()->json([
                    'message' => 'Lesson added successfully',
                    'lesson_id' => $lesson_id,
                ], 201);
            }

            return response()->json(['message' => 'Failed to add lesson'], 400);
        } catch (Exception $e) {
            Log::error("Error fetching lesson details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
