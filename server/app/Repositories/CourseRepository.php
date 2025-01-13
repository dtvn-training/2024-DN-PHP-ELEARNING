<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;
use App\Models\CourseModel;

class CourseRepository implements CourseInterface
{
    protected CourseModel $courseModel;

    public function __construct(CourseModel $courseModel)
    {
        $this->courseModel = $courseModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        return $this->courseModel->getCourseById($course_id);
    }
}
