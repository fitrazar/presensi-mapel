<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Teacher::with(['user', 'grade']);

            // Filter Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('grade', function ($row) {
                    return $row->grade ? $row->grade->full_class_name : '<span class="text-gray-400">-</span>';
                })
                ->addColumn('is_roommates', function ($row) {
                    return $row->is_roommates
                        ? '<span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Ya</span>'
                        : '<span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">Tidak</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex space-x-2">
                        <a href="' . route('admin.teacher.show', $row->id) . '" class="btn btn-info btn-sm">Lihat</a>
                        <a href="' . route('admin.teacher.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <button type="button" data-id="' . $row->id . '" class="delete-btn btn btn-error btn-sm">Hapus</button>
                    </div>
                ';
                })
                ->rawColumns(['grade', 'is_roommates', 'action'])
                ->make(true);
        }

        return view('admin.teacher.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teacher.create', [
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'grade_id' => 'nullable|exists:grades,id',
            'is_roommates' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'nip', 'phone', 'gender', 'grade_id']);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('teacher');

        $data['is_roommates'] = $request->has('is_roommates') ? 1 : 0;
        $data['user_id'] = $user->id;


        Teacher::create($data);

        return redirect()->route('admin.teacher.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $grades = Grade::all();
        return view('admin.teacher.edit', compact('teacher', 'grades'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'password' => 'nullable|min:4',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'grade_id' => 'nullable|exists:grades,id',
            'is_roommates' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'nip', 'phone', 'gender', 'grade_id']);
        if ($request->filled('password')) {
            $teacher->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data['is_roommates'] = $request->has('is_roommates') ? 1 : 0;


        $teacher->update($data);

        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();

        return response()->json(['success' => true, 'message' => 'Guru berhasil dihapus!']);
    }
}