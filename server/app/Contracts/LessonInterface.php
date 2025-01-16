<?php

namespace App\Contracts;

interface LessonInterface
{
    public function viewFull(int $aid, int $course_id): ?array;
    public function add(int $aid, array $lesson_information): ?int;
    public function delete(int $aid, int $course_id, int $lesson_id): ?bool;
    public function view(int $aid, int $course_id, int $lesson_id): ?array;
    public function modify(int $aid, array $lesson_information): ?bool;
}
