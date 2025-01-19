<?php

namespace App\Contracts;

interface LessonInterface
{
    public function list(int $aid, int $course_id): ?array;
}
