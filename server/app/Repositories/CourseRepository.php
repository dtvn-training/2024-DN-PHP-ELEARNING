<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

use App\Contracts\CourseInterface;

use App\Models\CourseViewModel;

class CourseRepository implements CourseInterface
{
    protected CourseViewModel $courseViewModel;

    public function __construct(
        CourseViewModel $courseViewModel,
    ) {
        $this->courseViewModel = $courseViewModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        return $this->courseViewModel->execute($course_id);
    }
}
