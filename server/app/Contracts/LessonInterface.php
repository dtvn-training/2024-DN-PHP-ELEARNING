<?php

namespace App\Contracts;

interface LessonInterface
{
    public function view(int $lesson_id): ?array;
    public function list(int $course_id): ?array;
    public function create(array $lesson_data): ?int;
    public function delete(int $lesson_id): ?bool;
    public function modify(array $lesson_data): ?bool;
}
