<?php

namespace App\Contracts;

interface MaterialInterface
{
    public function viewAll(int $aid, int $course_id, int $lesson_id): ?array;
    public function add(int $aid, array $material_infomation): ?int;
    public function modify(int $aid, array $material_infomation): ?bool;
    public function delete(int $aid, array $material_infomation): ?bool;
}
