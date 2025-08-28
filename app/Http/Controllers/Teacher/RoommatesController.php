<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\SubjectTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoommatesController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher; // Ambil data guru dari user login

        // Pastikan guru ini adalah wali kelas
        $classroom = $teacher->is_roommates;

        if (!$classroom) {
            abort(403, 'Anda bukan wali kelas.');
        }

        $subjects = SubjectTeacher::where('grade_id', $teacher->grade->id)->get();

        return view('teacher.subject.roommates', compact('classroom', 'subjects', 'teacher'));
    }

    public function attendance(Grade $grade, SubjectTeacher $subject)
    {
        $schedule = Schedule::where('subject_teacher_id', $subject->id)->first();

        // validasi: hanya wali kelas yg kelasnya sesuai yg boleh akses
        $teacher = Auth::user()->teacher;

        $classroom = $teacher->is_roommates;

        if (!$classroom) {
            abort(403, 'Anda bukan wali kelas.');
        }

        $attendances = Attendance::whereHas('student', function ($q) use ($grade) {
            $q->where('grade_id', $grade->id);
        })->where('schedule_id', $schedule->id)
            ->whereDate('date', today())->get();

        return view('teacher.subject.attendance', compact('teacher', 'grade', 'subject', 'attendances'));
    }
}