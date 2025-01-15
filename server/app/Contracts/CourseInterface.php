<?php

namespace App\Contracts;

interface CourseInterface
{
    public function getAll(int $aid): ?array;
    public function delete(int $aid, int $course_id): ?bool; 
}
