<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\ELDB\AuthorizationSeeder::class,
            \Database\Seeders\ELDB\AuthenticationSeeder::class,
            \Database\Seeders\ELDB\UserSeeder::class,
            \Database\Seeders\ELDB\TagSeeder::class,
            \Database\Seeders\ELDB\CourseSeeder::class,
            \Database\Seeders\ELDB\CourseTagSeeder::class,
            \Database\Seeders\ELDB\LessonSeeder::class,
            \Database\Seeders\ELDB\MaterialTypeSeeder::class,
            \Database\Seeders\ELDB\MaterialSeeder::class,
            \Database\Seeders\ELDB\EnrollmentSeeder::class,
            \Database\Seeders\ELDB\GradeSeeder::class,
            \Database\Seeders\ELDB\CourseFeedbackSeeder::class,
            \Database\Seeders\ELDB\SystemFeedbackSeeder::class,
            \Database\Seeders\ELDB\PaymentSeeder::class,
        ]);
    }
}
