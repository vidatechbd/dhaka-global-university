<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UniversitySettingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending-approval');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Principal'])->group(function () {
        Route::resource('admin/roles', RoleController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names('admin.roles');
        Route::resource('admin/permissions', PermissionController::class)->only(['index', 'store', 'destroy'])->names('admin.permissions');
        Route::resource('admin/teachers', TeacherController::class)->only(['index', 'store', 'destroy'])->names('admin.teachers');
    });

    // Student management (Principal & Teacher)
    Route::middleware(['permission:manage students'])->group(function () {
        Route::resource('admin/students', StudentController::class)->only(['index', 'store', 'destroy'])->names('admin.students');
        Route::patch('admin/students/{student}/approve', [StudentController::class, 'approve'])->name('admin.students.approve');
    });

    // Certificates
    Route::resource('certificates', CertificateController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // News Management
    Route::middleware(['permission:manage news'])->group(function () {
        Route::resource('admin/news', NewsController::class)->names('admin.news');
    });

    // University Settings
    Route::middleware(['role:Principal'])->group(function () {
        Route::get('admin/settings', [UniversitySettingController::class, 'index'])->name('admin.settings.index');
        Route::post('admin/settings', [UniversitySettingController::class, 'update'])->name('admin.settings.update');
    });
});

require __DIR__.'/auth.php';
