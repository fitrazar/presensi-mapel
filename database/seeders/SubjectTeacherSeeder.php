<?php

namespace Database\Seeders;

use App\Models\SubjectTeacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubjectTeacher::create([
            'subject_id' => 1,
            'teacher_id' => 1,
            'grade_id' => 2
        ]);
    }
}