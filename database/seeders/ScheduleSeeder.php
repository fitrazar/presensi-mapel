<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::create([
            'subject_teacher_id' => 1,
            'day' => 'Senin',
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
