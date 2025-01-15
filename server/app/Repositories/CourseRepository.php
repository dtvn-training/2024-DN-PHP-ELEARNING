<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\AllCourseModel;
use App\Models\DeleteCourseModel;

class CourseRepository implements CourseInterface
{
    protected AllCourseModel $allCourseModel;
    protected DeleteCourseModel $deleteCourseModel;

    public function __construct(AllCourseModel $allCourseModel, DeleteCourseModel $deleteCourseModel)
    {
        $this->allCourseModel = $allCourseModel;
        $this->deleteCourseModel = $deleteCourseModel;
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
}
