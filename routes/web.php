<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ScheduleController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/login');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/', [DashboardController::class, 'admin'])->name('index');

    Route::resource('/admin', AdminController::class);
    Route::resource('/student', StudentController::class);
    Route::resource('/teacher', TeacherController::class);
    Route::resource('/subject', SubjectController::class);
    Route::resource('/schedule', ScheduleController::class);


    // Import
    Route::post('/student/import', [StudentController::class, 'import'])->name('student.import');
    Route::post('/teacher/import', [TeacherController::class, 'import'])->name('teacher.import');
    Route::post('/subject/import', [SubjectController::class, 'import'])->name('subject.import');
    Route::post('/schedule/import', [ScheduleController::class, 'import'])->name('schedule.import');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [DashboardController::class, 'teacher'])->name('index');
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
