<?php

namespace App\Contracts;

interface CourseInterface
{
    public function view(int $course_id): ?array;
    public function getAll(int $aid): ?array;
    public function modify(int $aid, array $course_information): ?bool;
    public function create(int $aid, array $course_information): ?int;
    public function delete(int $aid, int $course_id): ?bool; 
}
