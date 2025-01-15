<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\CourseBelongModel;
use App\Models\CourseModel;
use App\Models\ModifyCourseModel;
use App\Models\AddCourseModel;
use App\Models\GetUserIDModel;
use Illuminate\Support\Facades\Log;

class CourseRepository implements CourseInterface
{
    protected CourseModel $courseModel;
    protected GetUserIDModel $getUserIDModel;
    protected ModifyCourseModel $modifyCourseModel;
    protected CourseBelongModel $courseBelongModel;
    protected AddCourseModel $addCourseModel;

    public function __construct(
        CourseModel $courseModel,
        GetUserIDModel $getUserIDModel,
        ModifyCourseModel $modifyCourseModel,
        CourseBelongModel $courseBelongModel,
        AddCourseModel $addCourseModel
    ) {
        $this->courseModel = $courseModel;
        $this->getUserIDModel = $getUserIDModel;
        $this->modifyCourseModel = $modifyCourseModel;
        $this->courseBelongModel = $courseBelongModel;
        $this->addCourseModel = $addCourseModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        try {
            return $this->courseModel->getCourseById($course_id);
        } catch (\Exception $e) {
            Log::error('Error retrieving course: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a new course for the authenticated user.
     *
     * @param  int  $aid - Authentication ID (user's ID).
     * @param  array  $course_information - Array containing the course details.
     * @return int|null - The ID of the newly added course, or null on failure.
     */
    public function add(int $aid, array $course_information): ?int
    {
        try {
            $user_id = $this->getUserIDModel->getUserID($aid);
            return $this->addCourseModel->addCourse($user_id, $course_information);
        } catch (\Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Modify the course if it belongs to the authenticated user.
     *
     * @param  int  $aid - Authentication ID (user's ID).
     * @param  array  $course_information - Array containing the course details.
     * @return bool - True if the course was successfully modified, False otherwise.
     */
    public function modify(int $aid, array $course_information): bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_information['course_id']);
            return $user_id ? $this->modifyCourseModel->modifyCourse($user_id, $course_information) : false;
        } catch (\Exception $e) {
            Log::error('Error modifying course: ' . $e->getMessage());
            return false;
        }
    }
}
