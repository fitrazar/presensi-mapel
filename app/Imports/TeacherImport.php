<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            Log::info('Importing teacher row:', [
                'row' => $row
            ]);
            $username = rand(1000, 9999);

            $user = new User([
                'username' => $row['nip'] ?? $username,
                'password' => bcrypt($row['nip'] ?? $username),
            ]);
            $user->assignRole('teacher');
            $user->save();


            return new Teacher([
                'name' => Str::title($row['nama_guru']),
                'gender' => $row['lp'] == 'L' ? 'Laki - Laki' : 'Perempuan',
                'nip' => $row['nip'] ?? $username,
                'user_id' => $user->id
            ]);

        } catch (\Throwable $e) {
            Log::error('Gagal import guru.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'row' => $row
            ]);
            return null;
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}