<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Major;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            Log::info('Importing student row:', [
                'row' => $row
            ]);

            $classNumber = substr($row['kelas'], 0, 1);
            $classLetter = substr($row['kelas'], 1, 1);


            $grade = Grade::where('level', $classNumber)
                ->where('class_number', $classLetter)
                ->first();


            return new Student([
                'name' => Str::title($row['nama_santri']),
                'gender' => $row['lp'] == 'L' ? 'Laki - Laki' : 'Perempuan',
                'nisn' => $row['nis'],
                'grade_id' => $grade->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('Gagal import siswa.', [
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
