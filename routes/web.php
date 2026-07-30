<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UniversitySettingController;
use App\Http\Controllers\MarksheetController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending-approval');

Route::get('/dashboard', function () {
    $totalStudents = \App\Models\User::role('Student')->count();
    $totalTeachers = \App\Models\User::role('Teacher')->count();
    $totalCertificates = \App\Models\Marksheet::count(); // Total marksheets generated
    $pendingStudents = \App\Models\User::role('Student')->where('status', 'pending')->count();

    // 1. Enrollment trend (last 6 months registrations)
    $registrationTrend = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $monthName = $date->format('M');
        $count = \App\Models\User::role('Student')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
        $registrationTrend[] = [
            'month' => $monthName,
            'count' => $count,
        ];
    }

    // 2. Department distribution
    $departmentCounts = \App\Models\Marksheet::select('department', \DB::raw('count(*) as total'))
        ->whereNotNull('department')
        ->where('department', '<>', '')
        ->groupBy('department')
        ->get()
        ->pluck('total', 'department')
        ->toArray();

    return view('dashboard', compact(
        'totalStudents', 
        'totalTeachers', 
        'totalCertificates', 
        'pendingStudents',
        'registrationTrend',
        'departmentCounts'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/marksheets/{marksheet}/verify', [\App\Http\Controllers\MarksheetController::class, 'verify'])->name('marksheets.verify');
Route::get('/certificates/{certificate}/verify', [\App\Http\Controllers\CertificateController::class, 'verify'])->name('certificates.verify');

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

    // Marksheets
    Route::resource('marksheets', MarksheetController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

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
