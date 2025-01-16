<?php

namespace App\Repositories;

use App\Models\CourseBelongModel;
use Illuminate\Support\Facades\Log;

use App\Contracts\CourseInterface;
use App\Models\DeleteCourseModel;

class CourseRepository implements CourseInterface
{
    protected DeleteCourseModel $deleteCourseModel;
    protected  CourseBelongModel $courseBelongModel;

    public function __construct(CourseBelongModel $courseBelongModel, DeleteCourseModel $deleteCourseModel)
    {
        $this->courseBelongModel = $courseBelongModel;
        $this->deleteCourseModel = $deleteCourseModel;
    }

    /**
     * Delete course by course ID.
     *
     * @param  int  $course_id
     * @return bool|null
     */
    public function delete(int $aid, $course_id): ?bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_id);
            if (!$user_id) {
                return null;
            }
            return $this->deleteCourseModel->execute($aid, $course_id);
        } catch (\Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return null;
        }
    }
}
