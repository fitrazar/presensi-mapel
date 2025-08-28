<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $today = ucfirst(Carbon::now()->locale('id')->dayName);
        $time = $now->format('H:i:s');

        // Cari jadwal aktif
        $schedule = Schedule::with(['subjectTeacher.grade', 'subjectTeacher.subject', 'subjectTeacher.teacher.user'])
            ->where('day', $today)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->first();

        if (!$schedule) {
            return view('admin.attendance.index', ['schedule' => null]);
        }

        $gradeId = $schedule->subjectTeacher->grade_id;
        $students = Student::where('grade_id', $gradeId)->orderBy('name')->get();

        if ($request->ajax()) {
            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('status', function ($student) use ($schedule) {
                    $attendance = Attendance::where('student_id', $student->id)
                        ->where('schedule_id', $schedule->id)
                        ->whereDate('date', now()->toDateString())
                        ->first();

                    $current = $attendance ? $attendance->status : null; // null = belum diisi
                    $options = ['Hadir', 'Izin', 'Sakit','Pulang Sakit', 'Pulang', 'Keluar', 'Alpa'];

                    $html = '<select data-id="' . $student->id . '" data-schedule="' . $schedule->id . '" class="status-select border rounded px-2 py-1">';
                    // placeholder default jika belum ada attendance
                    $html .= '<option value="" disabled ' . ($current ? '' : 'selected') . '>-- Pilih Status --</option>';
                    foreach ($options as $opt) {
                        $selected = $current === $opt ? 'selected' : '';
                        $html .= "<option value=\"$opt\" $selected>$opt</option>";
                    }
                    $html .= '</select>';

                    return $html;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.attendance.index', compact('schedule'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_id' => 'required|exists:schedules,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Pulang Sakit,Pulang,Keluar,Alpa',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'schedule_id' => $request->schedule_id,
                'date' => now()->toDateString(),
            ],
            [
                'status' => $request->status,
                'time' => now()->format('H:i:s'),
            ]
        );

        return response()->json(['success' => true]);
    }
}
