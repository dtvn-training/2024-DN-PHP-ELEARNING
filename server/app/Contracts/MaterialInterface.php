<?php

namespace App\Contracts;

interface MaterialInterface
{
    public function list(int $lesson_id): ?array;
    public function get(int $material_id, string $name): ?string;
    public function create(array $material_data): ?int;
}
