<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Student::with(['user', 'grade']);

            // Filter Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('grade', function ($row) {
                    return $row->grade ? $row->grade->full_class_name : '<span class="text-gray-400">-</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex space-x-2">
                        <a href="' . route('admin.student.show', $row->id) . '" class="btn btn-info btn-sm">Lihat</a>
                        <a href="' . route('admin.student.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <button type="button" data-id="' . $row->id . '" class="delete-btn btn btn-error btn-sm">Hapus</button>
                    </div>
                ';
                })
                ->rawColumns(['grade', 'action'])
                ->make(true);
        }

        return view('admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.student.create', [
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:50',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'grade_id' => 'nullable|exists:grades,id',
        ]);

        $data = $request->only(['name', 'nisn', 'gender', 'grade_id']);



        Student::create($data);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('admin.student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $grades = Grade::all();
        return view('admin.student.edit', compact('student', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:50',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'grade_id' => 'nullable|exists:grades,id',
        ]);

        $data = $request->only(['name', 'nisn', 'gender', 'grade_id']);


        $student->update($data);

        return redirect()->route('admin.student.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete();

        return response()->json(['success' => true, 'message' => 'Siswa berhasil dihapus!']);
    }
}