<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.index');
    }
    public function teacher()
    {
        return view('teacher.index');
    }
}
