<?php

namespace App\Contracts;

interface CourseInterface
{
    public function view(int $course_id): ?array;
    public function create(int $aid, array $course_information): ?int;
}
