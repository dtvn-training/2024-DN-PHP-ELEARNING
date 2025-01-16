<?php

namespace App\Http\Controllers;

use App\Contracts\LessonInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController
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
    public function getAllLesson(Request $request)
    {
        try {
            $aid = $request->session()->get('aid');
            $course_id = $request->input('course_id');
            $lessons = $this->lesson->viewFull($aid, $course_id);
            return response()->json(['lessons' => $lessons ?: []], 200);
        } catch (Exception $e) {
            Log::error("Error fetching lesson details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Handle add lesson requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addLesson(Request $request)
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

            $aid = $request->session()->get('aid');
            $lesson_id = $this->lesson->add($aid, $validator->validated());

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

    /**
     * Handle delete lesson requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteLesson(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|integer|exists:courses,course_id',
            'lesson_id' => 'required|integer|exists:lessons,lesson_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $aid = $request->session()->get('aid');
            $course_id = $request->input('course_id');
            $lesson_id = $request->input('lesson_id');

            // Call the delete method from the LessonInterface
            $deleted = $this->lesson->delete($aid, $course_id, $lesson_id);

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

    /**
     * View a lesson.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function viewLesson(Request $request): JsonResponse
    {
        try {
            Log::info($request->all());
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            if (!$aid) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized: Authentication ID not found in session.',
                ], 401);
            }

            $data = $validator->validated();

            $lesson = $this->lesson->view($aid, $data['course_id'], $data['lesson_id']);

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

    /**
     * Modify a lesson.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function modifyLesson(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
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

            $aid = $request->session()->get('aid');
            if (!$aid) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized: Authentication ID not found in session.',
                ], 401);
            }

            $data = $validator->validated();

            $isModified = $this->lesson->modify($aid, $data);

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
