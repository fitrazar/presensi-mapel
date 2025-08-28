<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['level' => '7', 'class_number' => 'A'],
            ['level' => '7', 'class_number' => 'B'],
            ['level' => '7', 'class_number' => 'C'],
            ['level' => '7', 'class_number' => 'D'],
            ['level' => '7', 'class_number' => 'E'],
            ['level' => '7', 'class_number' => 'F'],
            ['level' => '7', 'class_number' => 'G'],

            ['level' => '8', 'class_number' => 'A'],
            ['level' => '8', 'class_number' => 'B'],
            ['level' => '8', 'class_number' => 'C'],
            ['level' => '8', 'class_number' => 'D'],
            ['level' => '8', 'class_number' => 'E'],
            ['level' => '8', 'class_number' => 'F'],
            ['level' => '8', 'class_number' => 'G'],
            ['level' => '8', 'class_number' => 'H'],

            ['level' => '9', 'class_number' => 'A'],
            ['level' => '9', 'class_number' => 'B'],
            ['level' => '9', 'class_number' => 'C'],
            ['level' => '9', 'class_number' => 'D'],
            ['level' => '9', 'class_number' => 'E'],
            ['level' => '9', 'class_number' => 'F'],
            ['level' => '9', 'class_number' => 'G'],
            ['level' => '9', 'class_number' => 'H'],
            ['level' => '9', 'class_number' => 'I'],
            ['level' => '9', 'class_number' => 'J'],
        ];

        foreach ($classes as $class) {
            Grade::create($class);
        }
    }
}
