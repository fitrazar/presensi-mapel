<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\SubjectTeacher;
use App\Imports\ScheduleImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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
        $teachers = Teacher::all();
        $grades = Grade::all();
        $subjects = Subject::all();

        return view('admin.schedule.create', compact('teachers', 'grades', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);


        // Ambil kelas dari subject_teacher_id
        $subjectTeacherFind = SubjectTeacher::with('grade')
            ->where('teacher_id', $request->teacher_id)
            ->where('grade_id', $request->grade_id)
            ->where('subject_id', $request->subject_id)->first();

        if ($subjectTeacherFind) {
            // Cek apakah bentrok
            $conflict = Schedule::whereHas('subjectTeacher', function ($q) use ($subjectTeacherFind) {
                $q->where('grade_id', $subjectTeacherFind->grade_id);
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
        }

        $subjectTeacher = SubjectTeacher::create([
            'teacher_id' => $request->teacher_id,
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
        ]);

        // Jika tidak bentrok, simpan
        Schedule::create([
            'subject_teacher_id' => $subjectTeacher->id,
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
        $teachers = Teacher::all();
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('admin.schedule.edit', compact('schedule', 'teachers', 'grades', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $subjectTeacherFind = SubjectTeacher::with('grade')
            ->where('teacher_id', $request->teacher_id)
            ->where('grade_id', $request->grade_id)
            ->where('subject_id', $request->subject_id)->first();

        if ($subjectTeacherFind) {
            // Cek bentrok kecuali jadwal yang sedang diupdate
            $conflict = Schedule::whereHas('subjectTeacher', function ($q) use ($subjectTeacherFind) {
                $q->where('grade_id', $subjectTeacherFind->grade_id);
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
        }

        $subjectTeacherFind->update([
            'teacher_id' => $request->teacher_id,
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
        ]);


        $schedule->update([
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

    public function import(Request $request)
    {
        Excel::import(new ScheduleImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimport!');
    }
}
