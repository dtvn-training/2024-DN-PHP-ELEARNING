<?php

namespace App\Contracts;

interface CourseInterface
{
    public function view(int $course_id): ?array;
    public function getAll(int $aid): ?array;
}
