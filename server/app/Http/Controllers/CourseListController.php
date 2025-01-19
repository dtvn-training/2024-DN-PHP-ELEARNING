<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Contracts\CourseInterface;

class CourseListController
{
    protected CourseInterface $course;

    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Handle the request to fetch the list of courses for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $aid = $request->session()->get('aid');
            $courses = $this->course->list($aid);
            return response()->json(['courses' => $courses ?: []], 200);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}