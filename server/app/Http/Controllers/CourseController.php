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
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function viewCourse(Request $request)
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
}
