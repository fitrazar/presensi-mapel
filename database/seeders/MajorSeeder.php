<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            ['acronym' => 'TKR', 'name' => 'Teknik Kendaraan Ringan'],
            ['acronym' => 'TKJ', 'name' => 'Teknik Komputer dan Jaringan'],
            ['acronym' => 'TP', 'name' => 'Teknik Pemesinan'],
            ['acronym' => 'AK', 'name' => 'Akuntansi dan Keuangan Lembaga'],
            ['acronym' => 'MP', 'name' => 'Manajemen Perkantoran dan Layanan Bisnis'],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}