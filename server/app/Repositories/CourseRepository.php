<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\ViewCourseModel;
use App\Models\AllCourseModel;
use App\Models\CourseBelongModel;
use App\Models\ModifyCourseModel;
use App\Models\GetUserIDModel;
use Illuminate\Support\Facades\Log;

class CourseRepository implements CourseInterface
{
    protected ViewCourseModel $viewCourseModel;
    protected AllCourseModel $allCourseModel;
    protected GetUserIDModel $getUserIDModel;
    protected CourseBelongModel $courseBelongModel;
    protected ModifyCourseModel $modifyCourseModel;

    public function __construct(
        ViewCourseModel $viewCourseModel,
        AllCourseModel $allCourseModel,
        GetUserIDModel $getUserIDModel,
        CourseBelongModel $courseBelongModel,
        ModifyCourseModel $modifyCourseModel,
    ) {
        $this->viewCourseModel = $viewCourseModel;
        $this->allCourseModel = $allCourseModel;
        $this->getUserIDModel = $getUserIDModel;
        $this->courseBelongModel = $courseBelongModel;
        $this->modifyCourseModel = $modifyCourseModel;
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
}
