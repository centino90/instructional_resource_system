<?php

use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeletedResourceController;
use App\Http\Controllers\ImportantResourceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PendingResourceController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SavedResourceController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\UploadTemporaryFileController;
use App\Http\Controllers\Admin\InstructorsController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\PersonnelsController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\PresentationResourceController;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::post('dashboard/resourceDatatable', [DashboardController::class, 'resourceDatatable'])->name('dashboard.resourceDatatable');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('resources', ResourceController::class);
    Route::get('resources/preview/{resource}', [ResourceController::class, 'preview'])->name('resources.preview');
    Route::get('resources/download/{resource}', [ResourceController::class, 'download'])->name('resources.download');
    Route::post('resources/download-all-by-course', [ResourceController::class, 'downloadAllByCourse'])->name('resources.downloadAllByCourse');
    Route::post('resources/bulk-download', [ResourceController::class, 'bulkDownload'])->name('resources.bulkDownload');
    Route::post('resources/get-resources-json', [ResourceController::class, 'getResourcesJson'])->name('resources.getResourcesJson');

    Route::get('syllabi/preview/{syllabus}', [SyllabusController::class, 'preview'])->name('syllabi.preview');
    Route::post('syllabi/upload', [SyllabusController::class, 'upload'])->name('syllabi.upload');
    Route::resource('syllabi', SyllabusController::class);

    Route::get('presentations/preview/{presentation}', [PresentationResourceController::class, 'preview'])->name('presentations.preview');
    Route::post('presentations/upload', [PresentationResourceController::class, 'upload'])->name('presentations.upload');
    Route::resource('presentations', PresentationResourceController::class);

    Route::resource('courses', CourseController::class);
    Route::resource('archive', ArchiveController::class);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');

    // saved resources
    Route::resource('saved-resources', SavedResourceController::class);

    Route::put('pending-resources/approve/{resource}', [PendingResourceController::class, 'approve'])
        ->name('pending-resources.approve');
    Route::put('pending-resources/reject/{resource}', [PendingResourceController::class, 'reject'])
        ->name('pending-resources.reject');
    Route::resource('pending-resources', PendingResourceController::class);

    Route::resource('important-resources', ImportantResourceController::class);

    Route::resource('deleted-resources', DeletedResourceController::class);

    Route::resource('comments', CommentController::class);

    Route::resource('upload-temporary-file', UploadTemporaryFileController::class);

    // Admin
    Route::prefix('admin')->name('admin.')
        ->middleware(['auth.admin'])->group(function () {
            Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::get('/programs/list', [ProgramsController::class, 'list'])->name('programs.list');
            Route::resource('/programs', ProgramsController::class);
            Route::resource('/courses', CoursesController::class);
            Route::resource('/resources', ResourcesController::class);
            Route::resource('/personnels', PersonnelsController::class);
            Route::resource('/notifications', NotificationsController::class);
            // Route::resource('/instructors', InstructorsController::class);
        });

    // Program dean
    Route::prefix('programdean')->name('programdean.')->middleware(['auth.programdean'])->group(function () {
    });

    // Secretary
    Route::prefix('auth')->name('secretary.')->middleware(['auth.secretary'])->group(function () {
    });

    // Instructor
    Route::prefix('instructor')->name('instructor.')->middleware(['auth.instructor'])->group(function () {
    });
});



require __DIR__ . '/auth.php';
