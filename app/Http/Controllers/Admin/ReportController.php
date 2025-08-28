<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AttendanceExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        $grade_id = $request->grade_id ?? null;

        // Query dasar attendances
        $attendances = Attendance::whereBetween('date', [$start_date, $end_date])
            ->when($grade_id, function ($query) use ($grade_id) {
                $query->whereHas('schedule.subjectTeacher', function ($q) use ($grade_id) {
                    $q->where('grade_id', $grade_id);
                });
            });

        // Hitung total per status
        $statusCounts = (clone $attendances)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Mapel hari ini
        $mapelHariIni = Attendance::whereDate('date', now())
            ->when($grade_id, function ($query) use ($grade_id) {
                $query->whereHas('schedule.subjectTeacher', function ($q) use ($grade_id) {
                    $q->where('grade_id', $grade_id);
                });
            })
            ->select('schedule_id', DB::raw('count(*) as total'))
            ->groupBy('schedule_id')
            ->with('schedule.subjectTeacher.subject')
            ->get();

        // Top 5 siswa hadir terbanyak
        $topHadir = Attendance::select('student_id', DB::raw('count(*) as total'))
            ->where('status', 'Hadir')
            ->whereBetween('date', [$start_date, $end_date])
            ->when($grade_id, function ($query) use ($grade_id) {
                $query->whereHas('schedule.subjectTeacher', function ($q) use ($grade_id) {
                    $q->where('grade_id', $grade_id);
                });
            })
            ->groupBy('student_id')
            ->orderByDesc('total')
            ->with('student')
            ->take(5)
            ->get();

        $attendanceClass = Attendance::select(
            DB::raw("CONCAT(grades.level, '', grades.class_number) as kelas"),
            'attendances.status',
            DB::raw('count(*) as total')
        )
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('grades', 'students.grade_id', '=', 'grades.id')
            ->whereBetween('attendances.date', [$start_date, $end_date])
            ->groupBy('grades.level', 'grades.class_number', 'attendances.status')
            ->get();


        // Susun ulang biar sesuai dengan kebutuhan view
        $perClass = [];
        $statuses = ['Hadir', 'Izin', 'Sakit', 'Pulang Sakit', 'Alpa', 'Pulang', 'Keluar'];

        foreach ($attendanceClass as $row) {
            $kelas = $row->kelas;
            if (!isset($perClass[$kelas])) {
                $perClass[$kelas] = array_fill_keys($statuses, 0);
            }
            $perClass[$kelas][$row->status] = $row->total;
        }

        $grades = Grade::all();

        return view('admin.report.index', compact(
            'statusCounts',
            'mapelHariIni',
            'topHadir',
            'start_date',
            'end_date',
            'grades',
            'grade_id',
            'perClass'
        ));
    }

    public function exportExcel(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $grade_id = $request->query('grade_id');

        $fileName = 'Presensi Siswa ' . $start_date . ' - ' . $end_date . '.xlsx';

        return Excel::download(new AttendanceExport($start_date, $end_date, $grade_id), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();
        $gradeId = $request->grade_id;

        $query = Attendance::whereBetween('date', [$start, $end]);

        if ($gradeId) {
            $studentIds = Student::where('grade_id', $gradeId)->pluck('id');
            $query->whereIn('student_id', $studentIds);
        }

        $attendances = $query->with(['student.grade', 'schedule.subjectTeacher.subject'])->get();

        // --- Statistik global ---
        $statusSummary = $attendances->groupBy('status')->map->count();

        // --- Statistik per kelas ---
        $byClass = $attendances->groupBy(fn($a) => $a->student->grade->full_class_name)
            ->map(fn($rows) => $rows->groupBy('status')->map->count());

        // --- Statistik per mapel ---
        $bySubject = $attendances->groupBy(fn($a) => $a->schedule?->subjectTeacher?->subject?->name ?? 'Tanpa Mapel')
            ->map->count();

        // --- Top 5 hadir ---
        $topHadir = $attendances->where('status', 'Hadir')
            ->groupBy('student_id')
            ->map->count()
            ->sortDesc()
            ->take(5);

        $students = Student::whereIn('id', $topHadir->keys())->pluck('name', 'id');

        $pdf = Pdf::loadView('admin.report.pdf', [
            'attendances' => $attendances,
            'statusSummary' => $statusSummary,
            'byClass' => $byClass,
            'bySubject' => $bySubject,
            'topHadir' => $topHadir,
            'students' => $students,
            'start' => $start,
            'end' => $end,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Laporan Presensi.pdf');
    }

}