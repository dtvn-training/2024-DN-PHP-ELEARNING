<?php

namespace App\Contracts;

interface LessonInterface
{
    public function list(int $course_id): ?array;
    public function create(array $lesson_data): ?int;
    public function delete(int $lesson_id): ?bool;
}
