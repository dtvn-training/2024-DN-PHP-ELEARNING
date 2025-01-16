<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CourseInterface;

class CourseController
{
    protected CourseInterface $course;

    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Handle view course requests.
     * Handle add course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
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

            $data = $validator->validated();
            $course = $this->course->view($data['course_id']);

            if ($course) {
                return response()->json([
                    'status' => 'success',
                    'course' => $course,
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Course not found',
            ], 404);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $aid = $request->session()->get('aid');
            $courses = $this->course->getAll($aid);
            return response()->json(['courses' => $courses ?: []], 200);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());
        }
    }

    /**
     * Handle modify course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_name' => 'required|string|max:255',
                'short_description' => 'required|string|max:1000',
                'long_description' => 'required|string|max:5000',
                'course_price' => 'required|numeric|min:0',
                'course_duration' => 'required|string|max:100',
                'course_state' => 'required|boolean',
            ]);

            $aid = $request->session()->get('aid');
            $course_id = $this->course->create($aid, $validator->validated());

            if ($course_id) {
                return response()->json([
                    'message' => 'Course added successfully',
                    'course_id' => $course_id,
                ], 201);
            }

            return response()->json(['message' => 'Failed to add course'], 400);
        } catch (Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Handle modify course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|integer|exists:courses,course_id',
                'course_name' => 'required|string|max:255',
                'short_description' => 'required|string|max:1000',
                'long_description' => 'required|string|max:5000',
                'course_price' => 'required|numeric|min:0',
                'course_duration' => 'required|string|max:100',
                'course_state' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            $isModified = $this->course->modify($aid, $validator->validated());

            $aid = $request->session()->get('aid');
            $course_id = $this->course->create($aid, $validator->validated());

            if ($isModified) {
                return response()->json(['message' => 'Course modified successfully'], 200);
            }

            return response()->json(['message' => 'Failed to modify the course or no changes were made.'], 400);
        } catch (Exception $e) {
            Log::error('Error modifying course: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to add course'], 400);
        }
    }
    /**
     * Handle delete course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCourse(Request $request)
    {
        try {
            $aid = $request->session()->get('aid');
            $course_id = $request->input('course_id');

            if (!$aid || !$course_id) {
                return response()->json(['message' => 'Invalid request data.'], 400);
            }

            $deleted = $this->course->delete($aid, $course_id);

            if ($deleted) {
                return response()->json(['message' => 'Course deleted successfully.'], 200);
            }

            return response()->json(['message' => 'Failed to delete course.'], 400);
        } catch (Exception $e) {
            Log::error("Error deleting course: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
