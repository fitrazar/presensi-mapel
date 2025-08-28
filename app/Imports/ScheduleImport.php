<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use App\Models\SubjectTeacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScheduleImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            Log::info('Importing schedule row:', [
                'row' => $row
            ]);

            $teacher = Teacher::where('name', 'like', '%' . $row['nama_guru'] . '%')->first();
            $subject = Subject::where('name', 'like', '%' . $row['nama_mapel'] . '%')->first();
            $grade = Grade::where('level', 'like', '%' . substr($row['kelas'], 0, 1) . '%')->where('class_number', 'like', '%' . substr($row['kelas'], 1, 1) . '%')->first();

            $subjectTeacher = SubjectTeacher::create([
                'teacher_id' => $teacher->id,
                'grade_id' => $grade->id,
                'subject_id' => $subject->id,
            ]);
            // dd($row);

            return new Schedule([
                'subject_teacher_id' => $subjectTeacher->id,
                'day' => $row['hari'],
                'start_time' => Carbon::parse($row['jam_masuk']),
                'end_time' => Carbon::parse($row['jam_selesai']),
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
