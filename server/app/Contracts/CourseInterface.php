<?php

namespace App\Contracts;

interface CourseInterface
{
    public function create(int $aid, array $course_information): ?int;
}
