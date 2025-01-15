<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\AllCourseModel;
use App\Models\CourseModel;
use App\Models\DeleteCourseModel;

class CourseRepository implements CourseInterface
{
    protected AllCourseModel $allCourseModel;
    protected CourseModel $courseModel;
    protected DeleteCourseModel $deleteCourseModel;

    public function __construct(CourseModel $courseModel, AllCourseModel $allCourseModel, DeleteCourseModel $deleteCourseModel)
    {
        $this->allCourseModel = $allCourseModel;
        $this->deleteCourseModel = $deleteCourseModel;
        $this->courseModel = $courseModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function getAll(int $aid): ?array
    {
        return $this->allCourseModel->getAllCoursesByAuthId($aid);
    }
    public function delete(int $aid, $course_id): ?bool
    {
        return $this->deleteCourseModel->deleteCourseByAuthIdAndCourseId($aid, $course_id);
    }
    public function view(int $course_id): ?array
    {
        return $this->courseModel->getCourseById($course_id);
    }
}
