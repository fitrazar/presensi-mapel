<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'user_id' => 2,
            'grade_id' => 2,
            'nip' => '55723',
            'name' => 'Putri',
            'phone' => '6281385931773',
            'gender' => 'Perempuan',
            'is_roommates' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
