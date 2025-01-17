<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('material_types')->insert([
            ['m_type_description' => 'Video'],
            ['m_type_description' => 'Image'],
            ['m_type_description' => 'Text'],
        ]);
    }
}
