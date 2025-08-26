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
            ['level' => 'X', 'major_id' => 1, 'class_number' => 1],
            ['level' => 'X', 'major_id' => 1, 'class_number' => 2],
            ['level' => 'X', 'major_id' => 1, 'class_number' => 3],
            ['level' => 'X', 'major_id' => 2, 'class_number' => 1],
            ['level' => 'X', 'major_id' => 2, 'class_number' => 2],
            ['level' => 'X', 'major_id' => 2, 'class_number' => 3],
            ['level' => 'X', 'major_id' => 3, 'class_number' => 1],
            ['level' => 'X', 'major_id' => 3, 'class_number' => 2],
            ['level' => 'X', 'major_id' => 3, 'class_number' => 3],
            ['level' => 'X', 'major_id' => 4, 'class_number' => 1],
            ['level' => 'X', 'major_id' => 4, 'class_number' => 2],
            ['level' => 'X', 'major_id' => 4, 'class_number' => 3],
            ['level' => 'X', 'major_id' => 5, 'class_number' => 1],
            ['level' => 'X', 'major_id' => 5, 'class_number' => 2],
            ['level' => 'X', 'major_id' => 5, 'class_number' => 3],

            ['level' => 'XI', 'major_id' => 1, 'class_number' => 1],
            ['level' => 'XI', 'major_id' => 1, 'class_number' => 2],
            ['level' => 'XI', 'major_id' => 1, 'class_number' => 3],
            ['level' => 'XI', 'major_id' => 2, 'class_number' => 1],
            ['level' => 'XI', 'major_id' => 2, 'class_number' => 2],
            ['level' => 'XI', 'major_id' => 2, 'class_number' => 3],
            ['level' => 'XI', 'major_id' => 3, 'class_number' => 1],
            ['level' => 'XI', 'major_id' => 3, 'class_number' => 2],
            ['level' => 'XI', 'major_id' => 3, 'class_number' => 3],
            ['level' => 'XI', 'major_id' => 4, 'class_number' => 1],
            ['level' => 'XI', 'major_id' => 4, 'class_number' => 2],
            ['level' => 'XI', 'major_id' => 4, 'class_number' => 3],
            ['level' => 'XI', 'major_id' => 5, 'class_number' => 1],
            ['level' => 'XI', 'major_id' => 5, 'class_number' => 2],
            ['level' => 'XI', 'major_id' => 5, 'class_number' => 3],

            ['level' => 'XII', 'major_id' => 1, 'class_number' => 1],
            ['level' => 'XII', 'major_id' => 1, 'class_number' => 2],
            ['level' => 'XII', 'major_id' => 1, 'class_number' => 3],
            ['level' => 'XII', 'major_id' => 2, 'class_number' => 1],
            ['level' => 'XII', 'major_id' => 2, 'class_number' => 2],
            ['level' => 'XII', 'major_id' => 2, 'class_number' => 3],
            ['level' => 'XII', 'major_id' => 3, 'class_number' => 1],
            ['level' => 'XII', 'major_id' => 3, 'class_number' => 2],
            ['level' => 'XII', 'major_id' => 3, 'class_number' => 3],
            ['level' => 'XII', 'major_id' => 4, 'class_number' => 1],
            ['level' => 'XII', 'major_id' => 4, 'class_number' => 2],
            ['level' => 'XII', 'major_id' => 4, 'class_number' => 3],
            ['level' => 'XII', 'major_id' => 5, 'class_number' => 1],
            ['level' => 'XII', 'major_id' => 5, 'class_number' => 2],
            ['level' => 'XII', 'major_id' => 5, 'class_number' => 3],
        ];

        foreach ($classes as $class) {
            Grade::create($class);
        }
    }
}