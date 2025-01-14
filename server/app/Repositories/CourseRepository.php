<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\AllCourseModel;

class CourseRepository implements CourseInterface
{
    protected AllCourseModel $allCourseModel;

    public function __construct(AllCourseModel $allCourseModel)
    {
        $this->allCourseModel = $allCourseModel;
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
}
