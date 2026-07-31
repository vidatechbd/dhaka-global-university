<?php

use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomepageSettingController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UniversitySettingController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarksheetController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\NoticeController as PublicNoticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [PublicNewsController::class, 'show'])->name('news.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/notices', [PublicNoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice}', [PublicNoticeController::class, 'show'])->name('notices.show');
Route::get('/page/{slug}', [HomeController::class, 'showPage'])->name('page.show');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/apply', [AdmissionController::class, 'apply'])->name('apply');
Route::post('/apply', [AdmissionController::class, 'store']);

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending-approval');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::match(['get', 'post'], '/marksheets/{marksheet}/verify', [MarksheetController::class, 'verify'])->name('marksheets.verify');
Route::match(['get', 'post'], '/certificates/{certificate}/verify', [CertificateController::class, 'verify'])->name('certificates.verify');

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
        Route::patch('admin/students/applications/{application}/approve', [StudentController::class, 'approveApplication'])->name('admin.students.approve');
        Route::delete('admin/students/applications/{application}', [StudentController::class, 'rejectApplication'])->name('admin.students.reject');
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

    // Notices Management
    Route::middleware(['permission:manage notices'])->group(function () {
        Route::resource('admin/notices', NoticeController::class)->names('admin.notices');
    });

    // Gallery Management
    Route::middleware(['permission:manage gallery'])->group(function () {
        Route::resource('admin/gallery', GalleryController::class)->names('admin.gallery');
    });

    // Pages Management
    Route::middleware(['permission:manage pages'])->group(function () {
        Route::resource('admin/pages', PageController::class)->names('admin.pages');
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
