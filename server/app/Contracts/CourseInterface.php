<?php

namespace App\Contracts;

interface CourseInterface
{
    public function getAll(int $aid): ?array;
    public function delete(int $aid, int $course_id): ?bool; 
    public function view(int $course_id): ?array;
    public function add(int $aid, array $course_information): ?int;
    public function modify(int $aid, array $course_information): ?bool;
}
