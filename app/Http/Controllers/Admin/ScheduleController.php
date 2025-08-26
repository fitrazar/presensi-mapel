<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\SubjectTeacher;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $schedules = Schedule::with([
                'subjectTeacher.teacher',
                'subjectTeacher.subject',
                'subjectTeacher.grade'
            ]);

            return DataTables::of($schedules)
                ->addIndexColumn()
                ->addColumn('teacher', function ($row) {
                    return $row->subjectTeacher->teacher->name ?? '-';
                })
                ->addColumn('subject', function ($row) {
                    return $row->subjectTeacher->subject->name ?? '-';
                })
                ->addColumn('grade', function ($row) {
                    return $row->subjectTeacher->grade->full_class_name ?? '-';
                })
                ->addColumn('time', function ($row) {
                    return $row->start_time . ' - ' . $row->end_time;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="flex space-x-2">
                            <a href="' . route('admin.schedule.show', $row->id) . '" class="btn btn-info btn-sm">Lihat</a>
                            <a href="' . route('admin.schedule.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" data-id="' . $row->id . '" class="delete-btn btn btn-error btn-sm">Hapus</button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjectTeachers = SubjectTeacher::with(['subject', 'teacher', 'grade'])->get();

        return view('admin.schedule.create', compact('subjectTeachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_teacher_id' => 'required|exists:subject_teachers,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Ambil kelas dari subject_teacher_id
        $subjectTeacher = SubjectTeacher::with('grade')->findOrFail($request->subject_teacher_id);

        // Cek apakah bentrok
        $conflict = Schedule::whereHas('subjectTeacher', function ($q) use ($subjectTeacher) {
            $q->where('grade_id', $subjectTeacher->grade_id);
        })
            ->where('day', $request->day)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'conflict' => 'Jadwal bentrok dengan jadwal lain di kelas ini!'
            ])->withInput();
        }

        // Jika tidak bentrok, simpan
        Schedule::create([
            'subject_teacher_id' => $request->subject_teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        return view('admin.schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $subjectTeachers = SubjectTeacher::with(['subject', 'teacher', 'grade'])->get();
        return view('admin.schedule.edit', compact('schedule', 'subjectTeachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'subject_teacher_id' => 'required|exists:subject_teachers,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $subjectTeacher = SubjectTeacher::with('grade')->findOrFail($request->subject_teacher_id);

        // Cek bentrok kecuali jadwal yang sedang diupdate
        $conflict = Schedule::whereHas('subjectTeacher', function ($q) use ($subjectTeacher) {
            $q->where('grade_id', $subjectTeacher->grade_id);
        })
            ->where('day', $request->day)
            ->where('id', '!=', $schedule->id) // <--- abaikan jadwal yang sedang diedit
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'conflict' => 'Jadwal bentrok dengan jadwal lain di kelas ini!'
            ])->withInput();
        }

        $schedule->update([
            'subject_teacher_id' => $request->subject_teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json(['success' => true, 'message' => 'Jadwal Mapel berhasil dihapus!']);
    }
}