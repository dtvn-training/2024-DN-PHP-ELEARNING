<?php

namespace App\Repositories;

use App\Contracts\LessonInterface;
use App\Models\CourseBelongModel;
use App\Models\ReadAllLessonModel;
use App\Models\AddLessonModel;
use App\Models\DeleteLessonModel;
use App\Models\ModifyLessonModel;
use App\Models\ViewLessonModel;
use Illuminate\Support\Facades\Log;

class LessonRepository implements LessonInterface
{
    protected CourseBelongModel $courseBelongModel;
    protected ReadAllLessonModel $readLessonModel;
    protected AddLessonModel $addLessonModel;
    protected DeleteLessonModel $deleteLessonModel;
    protected ViewLessonModel $viewLessonModel;
    protected ModifyLessonModel $modifyLessonModel;

    public function __construct(
        CourseBelongModel $courseBelongModel,
        ReadAllLessonModel $readLessonModel,
        AddLessonModel $addLessonModel,
        DeleteLessonModel $deleteLessonModel,
        ViewLessonModel $viewLessonModel,
        ModifyLessonModel $modifyLessonModel
    ) {
        $this->courseBelongModel = $courseBelongModel;
        $this->readLessonModel = $readLessonModel;
        $this->addLessonModel = $addLessonModel;
        $this->deleteLessonModel = $deleteLessonModel;
        $this->viewLessonModel = $viewLessonModel;
        $this->modifyLessonModel = $modifyLessonModel;
    }

    /**
     * Get course details by course ID.
     *
     * @param  int  $aid
     * @param  int  $course_id
     * @return array|null
     */
    public function viewFull(int $aid, int $course_id): ?array
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_id);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            Log::info($this->readLessonModel->getLessonsByCourse($course_id));
            return $this->readLessonModel->getLessonsByCourse($course_id);
        } catch (\Exception $e) {
            Log::error('Error retrieving course lessons: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_information
     * @return int|null
     */
    public function add(int $aid, array $lesson_information): ?int
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $lesson_information['course_id']);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->addLessonModel->addLesson($lesson_information);
        } catch (\Exception $e) {
            Log::error('Error adding lesson: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a lesson from the course.
     *
     * @param  int  $aid
     * @param  int  $course_id
     * @param  int  $lesson_id
     * @return bool
     */
    public function delete(int $aid, int $course_id, int $lesson_id): bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_id);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->deleteLessonModel->deleteLesson($course_id, $lesson_id);
        } catch (\Exception $e) {
            Log::error('Error deleting lesson: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_information
     * @return int|null
     */
    public function view(int $aid, int $course_id, int $lesson_id): ?array
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_id);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->viewLessonModel->viewLesson($lesson_id);
        } catch (\Exception $e) {
            Log::error('Error adding lesson: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a lesson to the course.
     *
     * @param  int  $aid
     * @param  array  $lesson_information
     * @return int|null
     */
    public function modify(int $aid, array $lesson_information): ?bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $lesson_information['course_id']);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->modifyLessonModel->modifyLesson($lesson_information);
        } catch (\Exception $e) {
            Log::error('Error adding lesson: ' . $e->getMessage());
            return null;
        }
    }
}
