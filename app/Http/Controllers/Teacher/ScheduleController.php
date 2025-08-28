<?php

namespace App\Http\Controllers\Teacher;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $today = ucfirst(Carbon::now()->locale('id')->dayName); // ex: Senin
        $now = Carbon::now()->format('H:i:s');

        // Daftar hari dalam seminggu
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $schedules = Schedule::with(['subjectTeacher.subject', 'subjectTeacher.teacher', 'subjectTeacher.grade'])
            ->whereHas('subjectTeacher', function ($q) {
                $q->where('teacher_id', Auth::user()->teacher->id);
            })
            ->get()
            ->sortBy(function ($item) use ($today, $now, $days) {
                $dayIndex = array_search($item->day, $days);

                if ($item->day === $today) {
                    // Hari ini → utamakan yg belum mulai
                    $timeRank = ($item->start_time >= $now) ? 0 : 1;
                } else {
                    // Hari lain setelah hari ini
                    $timeRank = 2;
                }

                return [$item->day == $today ? 0 : 1, $dayIndex, $timeRank, $item->start_time];
            });

        return view('teacher.schedule.index', compact('schedules'));
    }

}