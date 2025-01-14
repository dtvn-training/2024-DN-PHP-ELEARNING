<?php

namespace App\Contracts;

interface CourseInterface
{
    public function getAll(int $aid): ?array;
}
