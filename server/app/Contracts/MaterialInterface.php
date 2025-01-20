<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface MaterialInterface
{
    public function list(int $lesson_id): ?array;
    public function create(array $material_data): ?int;
    public function modify(array $material_data): ?bool;
    public function delete(int $material_id): ?bool;
    public function get(int $material_id, string $name): ?string;
    public function set(int $material_id, UploadedFile $file): ?bool;
    public function generate(int $material_id, string $material_content): ?bool;
    public function improve(int $material_id, string $material_content, string $prompt): ?bool;
}
