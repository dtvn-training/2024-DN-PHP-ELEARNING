<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\CourseInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController
{
    protected CourseInterface $course;

    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Handle view course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllCourse(Request $request)
    {
        try {
            $aid = $request->session()->get('aid');
            $courses = $this->course->getAll($aid);
            return response()->json(['courses' => $courses ?: []], 200);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function viewCourse(Request $request): JsonResponse
    {
        try {
            $course_id = $request->route('course_id');

            $course = $this->course->view($course_id);

            if ($course) {
                return response()->json(['course' => $course], 200);
            }

            return response()->json(['message' => 'Course not found'], 404);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Handle delete course requests.
     * Handle modify course requests.
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

    public function modifyCourse(Request $request): JsonResponse
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

            if ($isModified) {
                return response()->json(['message' => 'Course modified successfully'], 200);
            }

            return response()->json(['message' => 'Failed to modify the course or no changes were made.'], 400);
        } catch (Exception $e) {
            Log::error('Error modifying course: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Handle add course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addCourse(Request $request): JsonResponse
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

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            $course_id = $this->course->add($aid, $validator->validated());

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
}
