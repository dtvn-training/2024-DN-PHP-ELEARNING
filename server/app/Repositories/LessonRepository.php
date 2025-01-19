<?php

namespace App\Repositories;

use App\Contracts\LessonInterface;

use App\Models\LessonCreateModel;
use App\Models\LessonDeleteModel;
use App\Models\LessonListModel;
use App\Models\LessonModifyModel;
use App\Models\LessonViewModel;

class LessonRepository implements LessonInterface
{
    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_information
     * @return int|null
     */
    public function view(int $lesson_id): ?array
    {
        return LessonViewModel::execute($lesson_id);
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $aid
     * @param  int  $course_id
     * @return array|null
     */
    public function list(int $course_id): ?array
    {
        return LessonListModel::execute($course_id);
    }

    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_data
     * @return int|null
     */
    public function create(array $lesson_data): ?int
    {
        return LessonCreateModel::execute($lesson_data);
    }

    /**
     * Delete a lesson from the course.
     *
     * @param  int  $aid
     * @param  int  $course_id
     * @param  int  $lesson_id
     * @return bool
     */
    public function delete(int $lesson_id): bool
    {
        return LessonDeleteModel::execute($lesson_id);
    }

    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_data
     * @return int|null
     */
    public function modify(array $lesson_data): ?bool
    {
            return LessonModifyModel::execute($lesson_data);
    }
}