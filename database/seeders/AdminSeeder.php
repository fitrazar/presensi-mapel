<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'user_id' => 1,
            'name' => 'Admin',
            'phone' => '6281385931773',
            'gender' => 'Laki - Laki',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
