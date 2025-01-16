<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

use App\Contracts\CourseInterface;

use App\Models\CreateCourseModel;
use App\Models\GetUserIDModel;

class CourseRepository implements CourseInterface
{
    protected GetUserIDModel $getUserIDModel;
    protected CreateCourseModel $createCourseModel;

    public function __construct(
        GetUserIDModel $getUserIDModel,
        CreateCourseModel $createCourseModel 
    ) {
        $this->getUserIDModel = $getUserIDModel;
        $this->createCourseModel = $createCourseModel;
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
        try {
            $user_id = $this->getUserIDModel->getUserID($aid);
            return $this->createCourseModel ->execute($user_id, $course_information);
        } catch (\Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return null;
        }
    }
}
