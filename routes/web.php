<?php

use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SidebarController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UniversitySettingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarksheetController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Marksheet;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [PublicNewsController::class, 'show'])->name('news.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/page/{slug}', [HomeController::class, 'showPage'])->name('page.show');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending-approval');

Route::get('/dashboard', function () {
    $totalStudents = User::role('Student')->count();
    $totalTeachers = User::role('Teacher')->count();
    $totalCertificates = Marksheet::count(); // Total marksheets generated
    $pendingStudents = User::role('Student')->where('status', 'pending')->count();

    // 1. Enrollment trend (last 6 months registrations)
    $registrationTrend = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $monthName = $date->format('M');
        $count = User::role('Student')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
        $registrationTrend[] = [
            'month' => $monthName,
            'count' => $count,
        ];
    }

    // 2. Department distribution
    $departmentCounts = Marksheet::select('department', DB::raw('count(*) as total'))
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

Route::get('/marksheets/{marksheet}/verify', [MarksheetController::class, 'verify'])->name('marksheets.verify');
Route::get('/certificates/{certificate}/verify', [CertificateController::class, 'verify'])->name('certificates.verify');

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

    // Events Management
    Route::middleware(['permission:manage events'])->group(function () {
        Route::resource('admin/events', App\Http\Controllers\Admin\EventController::class)->names('admin.events');
    });

    // Pages Management
    Route::middleware(['permission:manage pages'])->group(function () {
        Route::resource('admin/pages', PageController::class)->names('admin.pages');
        Route::resource('admin/sidebars', SidebarController::class)->names('admin.sidebars');
    });

    // University Settings
    Route::middleware(['role:Principal'])->group(function () {
        Route::get('admin/settings', [UniversitySettingController::class, 'index'])->name('admin.settings.index');
        Route::post('admin/settings', [UniversitySettingController::class, 'update'])->name('admin.settings.update');
        Route::get('admin/homepage-settings', [HomepageSettingController::class, 'index'])->name('admin.homepage-settings.index');
        Route::post('admin/homepage-settings', [HomepageSettingController::class, 'update'])->name('admin.homepage-settings.update');
    });
});

Route::get('clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('event:clear');

    return response()->json([
        'success' => true,
        'message' => 'All caches cleared successfully.',
    ]);
});
require __DIR__.'/auth.php';
