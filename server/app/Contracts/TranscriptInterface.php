<?php

namespace App\Contracts;

interface TranscriptInterface
{
    public function generate($aid, $material_info);
    public function improve($aid, $material_info);
}
