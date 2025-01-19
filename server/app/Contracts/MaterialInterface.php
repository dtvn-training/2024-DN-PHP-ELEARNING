<?php

namespace App\Contracts;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface MaterialInterface
{
    public function list(int $lesson_id): ?array;
    public function get(int $material_id, string $name): ?string;
}
