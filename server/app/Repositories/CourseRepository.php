<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\ViewCourseModel;
use App\Models\AllCourseModel;
use App\Models\CourseBelongModel;
use App\Models\ModifyCourseModel;
use App\Models\GetUserIDModel;
use App\Models\CreateCourseModel;
use Illuminate\Support\Facades\Log;

class CourseRepository implements CourseInterface
{
    protected ViewCourseModel $viewCourseModel;
    protected AllCourseModel $allCourseModel;
    protected GetUserIDModel $getUserIDModel;
    protected CourseBelongModel $courseBelongModel;
    protected ModifyCourseModel $modifyCourseModel;
    protected CreateCourseModel $createCourseModel;

    public function __construct(
        ViewCourseModel $viewCourseModel,
        AllCourseModel $allCourseModel,
        GetUserIDModel $getUserIDModel,
        CourseBelongModel $courseBelongModel,
        ModifyCourseModel $modifyCourseModel,
        CreateCourseModel $createCourseModel,
    ) {
        $this->viewCourseModel = $viewCourseModel;
        $this->allCourseModel = $allCourseModel;
        $this->getUserIDModel = $getUserIDModel;
        $this->courseBelongModel = $courseBelongModel;
        $this->modifyCourseModel = $modifyCourseModel;
        $this->createCourseModel = $createCourseModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        return $this->viewCourseModel->execute($course_id);
    }

    public function getAll(int $aid): ?array
    {
        return $this->allCourseModel->execute($aid);
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
            return $user_id ? $this->modifyCourseModel->execute($user_id, $course_information) : false;
        } catch (\Exception $e) {
            Log::error('Error modifying course: ' . $e->getMessage());
            return false;
        }
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
            return $this->createCourseModel->execute($user_id, $course_information);
        } catch (\Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return null;
        }
    }
}
