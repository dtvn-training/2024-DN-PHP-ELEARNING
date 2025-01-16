<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\CourseBelongModel;
use App\Models\ModifyCourseModel;
use App\Models\GetUserIDModel;
use App\Models\ViewCourseModel;
use Illuminate\Support\Facades\Log;

class CourseRepository implements CourseInterface
{
    protected GetUserIDModel $getUserIDModel;
    protected CourseBelongModel $courseBelongModel;
    protected ViewCourseModel $viewCourseModel;
    protected ModifyCourseModel $modifyCourseModel;

    public function __construct(
        GetUserIDModel $getUserIDModel,
        CourseBelongModel $courseBelongModel,
        ViewCourseModel $viewCourseModel,
        ModifyCourseModel $modifyCourseModel,
    ) {
        $this->getUserIDModel = $getUserIDModel;
        $this->courseBelongModel = $courseBelongModel;
        $this->viewCourseModel = $viewCourseModel;
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
