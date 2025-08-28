<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalSubjects = Subject::count();

        // Presensi hari ini
        $today = Carbon::today();
        $todayAttendance = Attendance::whereDate('created_at', $today)->count();
        $totalTodayStudents = $totalStudents; // target presensi
        $attendancePercentage = $totalTodayStudents > 0
            ? round(($todayAttendance / $totalTodayStudents) * 100, 2)
            : 0;

        // Presensi terbaru (ambil 5 terakhir)
        $recentAttendances = Attendance::with(['schedule.subjectTeacher.subject', 'schedule.subjectTeacher.grade'])
            ->latest()
            ->take(5)
            ->get();


        return view('admin.index', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalSubjects' => $totalSubjects,
            'todayAttendance' => $todayAttendance,
            'totalTodayStudents' => $totalTodayStudents,
            'attendancePercentage' => $attendancePercentage,
            'recentAttendances' => $recentAttendances,
        ]);
    }
    public function teacher()
    {
        $teacher = Auth::user()->teacher;

        // Ambil semua mapel yang diampu guru ini
        $subjectTeachers = SubjectTeacher::with(['subject', 'grade'])
            ->where('teacher_id', $teacher->id)
            ->get();

        // Jadwal terbaru (7 hari terakhir atau akan datang)
        $latestSchedules = Schedule::with(['subjectTeacher.subject', 'subjectTeacher.grade'])
            ->whereIn('subject_teacher_id', $subjectTeachers->pluck('id'))
            ->whereDate('start_time', '>=', Carbon::now()->subDays(7))
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        // Statistik presensi (hari ini saja)
        $today = Carbon::today();
        $attendanceStats = Attendance::whereDate('date', $today)
            ->whereHas('schedule', function ($q) use ($subjectTeachers) {
                $q->whereIn('subject_teacher_id', $subjectTeachers->pluck('id'));
            })
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status');


        // Jika wali kelas, ambil siswa kelas tersebut
        $classStudents = $teacher->is_roommates
            ? Student::where('grade_id', $teacher->grade_id)->get()
            : collect();

        // Jika wali kelas → hitung top/bottom kehadiran siswa di kelasnya
        $topStudents = collect();
        $bottomStudents = collect();

        if ($teacher->is_roommates) {
            $studentIds = $classStudents->pluck('id');

            // Hitung total hadir / alpa per siswa
            $studentAttendance = Attendance::whereIn('student_id', $studentIds)
                ->selectRaw("student_id, 
                SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir_count,
                SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as alpa_count,
                COUNT(*) as total_presensi")
                ->groupBy('student_id')
                ->get();

            // Top 5 hadir terbanyak
            $topStudents = $studentAttendance->sortByDesc('hadir_count')->take(5);

            // Bottom 5 (alpa terbanyak)
            $bottomStudents = $studentAttendance->sortByDesc('alpa_count')->take(5);
        }

        return view('teacher.index', compact(
            'teacher',
            'subjectTeachers',
            'latestSchedules',
            'attendanceStats',
            'classStudents',
            'topStudents',
            'bottomStudents'
        ));
    }

}