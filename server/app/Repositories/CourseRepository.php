<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\ViewCourseModel;
use App\Models\AllCourseModel;

class CourseRepository implements CourseInterface
{
    protected ViewCourseModel $viewCourseModel;
    protected AllCourseModel $allCourseModel;

    public function __construct(
        ViewCourseModel $viewCourseModel,
        AllCourseModel $allCourseModel
    ) {
        $this->viewCourseModel = $viewCourseModel;
        $this->allCourseModel = $allCourseModel;
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
}
