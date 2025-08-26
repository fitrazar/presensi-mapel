<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Subject::query();

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    return '
                        <div class="flex space-x-2">
                            <a href="' . route('admin.subject.show', $row->id) . '" class="btn btn-info btn-sm">Lihat</a>
                            <a href="' . route('admin.subject.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" data-id="' . $row->id . '" class="delete-btn btn btn-error btn-sm">Hapus</button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.subject.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        $data = $request->only(['name', 'code']);



        Subject::create($data);

        return redirect()->route('admin.subject.index')->with('success', 'Mapel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('admin.subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);

        $data = $request->only(['name', 'code']);


        $subject->update($data);

        return redirect()->route('admin.subject.index')->with('success', 'Data mapel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Mapel berhasil dihapus!']);
    }
}