<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;

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
        return view('teacher.index');
    }
}