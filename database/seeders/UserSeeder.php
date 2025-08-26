<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');
        $teacher = User::create([
            'username' => 'teacher',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole('teacher');
    }
}
