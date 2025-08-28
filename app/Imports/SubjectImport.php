<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            Log::info('Importing subject row:', [
                'row' => $row
            ]);


            return new Subject([
                'name' => $row['nama_mapel'],
                'code' => $row['kode'],
            ]);

        } catch (\Throwable $e) {
            Log::error('Gagal import mapel.', [
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
