<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'grade_id' => 2,
            'name' => 'Fitra Fajar',
            'nisn' => '2110631170027',
            'gender' => 'Laki - Laki',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}