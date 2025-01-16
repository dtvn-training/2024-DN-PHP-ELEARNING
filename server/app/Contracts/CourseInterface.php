<?php

namespace App\Contracts;

interface CourseInterface
{
    public function delete(int $aid, int $course_id): ?bool; 
}
