<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

use App\Contracts\CourseInterface;

use App\Models\GetUserIDModel;
use App\Models\CourseCreateModel;
use App\Models\CourseViewModel;

class CourseRepository implements CourseInterface
{
    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        return CourseViewModel::execute($course_id);
    }


    /**
     * Add a new course for the authenticated user.
     *
     * @param  int  $aid - Authentication ID (user's ID).
     * @param  array  $course_information - Array containing the course details.
     * @return int|null - The ID of the newly added course, or null on failure.
     */
    public function create(int $aid, array $course_information): ?int
    {
        $user_id = GetUserIDModel::execute($aid);
        if ($user_id === null) {
            Log::error('User ID not found for authentication ID: ' . $aid);
            return null;
        }
        return CourseCreateModel::execute(GetUserIDModel::execute($aid), $course_information);
    }
}
