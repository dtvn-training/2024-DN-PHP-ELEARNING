<?php

namespace App\Contracts;

interface LessonInterface
{
    public function list(int $aid, int $course_id): ?array;
    public function create(int $aid, array $lesson_data): ?int;
}
