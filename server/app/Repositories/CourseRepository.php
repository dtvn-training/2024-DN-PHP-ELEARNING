<?php

namespace App\Repositories;

use App\Contracts\CourseInterface;

use App\Models\GetUserIDModel;
use App\Models\CourseCreateModel;
use App\Models\CourseDeleteModel;
use App\Models\CourseListModel;
use App\Models\CourseModifyModel;
use App\Models\CourseViewModel;

class CourseRepository implements CourseInterface
{
    /**
     * Get course details by course ID.
     *
     * @param  int  $course_id
     * @return array|null
     */
    public function view(int $course_id): ?array
    {
        return CourseViewModel::execute($course_id);
    }

    /**
     * Add a new course for the authenticated user.
     *
     * @param  int  $aid - Authentication ID (user's ID).
     * @param  array  $course_information - Array containing the course details.
     * @return int|null - The ID of the newly added course, or null on failure.
     */
    public function create(int $aid, array $course_information): ?int
    {
        return CourseCreateModel::execute(
            GetUserIDModel::execute($aid), 
            $course_information
        );
    }

    /**
     * Modify the course if it belongs to the authenticated user.
     *
     * @param  int  $aid - Authentication ID (user's ID).
     * @param  array  $course_information - Array containing the course details.
     * @return bool - True if the course was successfully modified, False otherwise.
     */
    public function modify(int $aid, array $course_information): ?bool
    {
        return CourseModifyModel::execute(
            GetUserIDModel::execute($aid), 
            $course_information
        );
    }

    /**
     * Delete course by course ID.
     *
     * @param  int  $course_id
     * @return bool|null
     */
    public function delete(int $aid, $course_id): ?bool
    {
        return CourseDeleteModel::execute(
            GetUserIDModel::execute($aid), 
            $course_id
        );
    }

    /**
     * Get all course teht belong to user via aid.
     *
     * @param  int  $aid
     * @return array|null
     */
    public function list(int $aid): ?array
    {
        return CourseListModel::execute(GetUserIDModel::execute($aid));
    }
}
