<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonDeleteController
{
    protected LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Handle delete lesson requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'lesson_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $lesson_id = $validator->validated()['lesson_id'];

            $deleted = $this->lesson->delete( $lesson_id);

            if ($deleted) {
                return response()->json(['message' => 'Lesson deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Failed to delete lesson.'], 400);
            }
        } catch (Exception $e) {
            Log::error("Error deleting lesson: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
