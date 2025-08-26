<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            MajorSeeder::class,
            GradeSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            SubjectSeeder::class,
            SubjectTeacherSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}