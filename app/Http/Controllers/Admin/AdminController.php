<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Admin::with('user');

            // Filter Gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if ($row->photo) {
                        return '<img src="' . asset('storage/' . $row->photo) . '" class="w-10 h-10 rounded-full object-cover mx-auto">';
                    }
                    return '<span class="text-gray-400">-</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="flex space-x-2">
                            <a href="' . route('admin.admin.show', $row->id) . '" class="btn btn-info btn-sm">Lihat</a>
                            <a href="' . route('admin.admin.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" data-id="' . $row->id . '" class="delete-btn btn btn-error btn-sm">Hapus</button>
                        </div>
                    ';
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        return view('admin.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|min:3|max:10',
            'password' => 'required|string|min:6|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 1. Create user (login account)
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('admin');

        // 2. Upload photo (if any)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('admins', 'public');
        }

        // 3. Create admin profile
        Admin::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'password' => 'nullable|string|min:6',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Laki - Laki,Perempuan',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 1. Update password jika diisi
        if ($request->filled('password')) {
            $admin->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // 2. Upload photo (replace jika ada)
        $photoPath = $admin->photo;
        if ($request->hasFile('photo')) {
            if ($admin->photo && \Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($admin->photo);
            }
            $photoPath = $request->file('photo')->store('admins', 'public');
        }

        // 3. Update profile admin
        $admin->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        // Hapus foto jika ada
        if ($admin->photo && \Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }

        // Hapus user sekaligus (karena ada foreignId user_id cascade delete, cukup hapus user)
        $admin->user->delete();

        return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus!']);
    }

}
