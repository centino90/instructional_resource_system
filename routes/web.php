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
use App\Http\Controllers\Admin\ProgramsController as AdminProgramController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Instructor\ResourceController as InstructorResourceController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PresentationResourceController;
use App\Http\Controllers\StorageController;
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

    Route::resource('program', ProgramController::class);

    Route::resource('course', CourseController::class);

    Route::post('resource/{resource}/create-new-version-url', [ResourceController::class, 'storeNewVersionByUrl'])->name('resource.storeNewVersionByUrl');
    Route::put('resource/{resource}/versions/{media}/update', [ResourceController::class, 'toggleCurrentVersion'])->name('resource.toggleCurrentVersion');
    Route::get('resource/{resource}/versions', [ResourceController::class, 'viewVersions'])->name('resource.viewVersions');
    Route::post('resource/{resource}/create-new-version', [ResourceController::class, 'storeNewVersion'])->name('resource.storeNewVersion');
    Route::get('resource/{resource}/create-new-version', [ResourceController::class, 'createNewVersion'])->name('resource.createNewVersion');
    Route::get('resource/preview/{resource}', [ResourceController::class, 'preview'])->name('resource.preview');
    Route::get('resource/create/{lesson}', [ResourceController::class, 'create'])->name('resource.create');
    Route::resource('resource', ResourceController::class)->except(['create']);
    Route::resource('lesson', LessonController::class);

    Route::post('resources/storeByUrl', [ResourceController::class, 'storeByUrl'])->name('resources.storeByUrl');
    Route::resource('resources', ResourceController::class);
    Route::get('resources/preview/{resource}', [ResourceController::class, 'preview'])->name('resources.preview');
    Route::get('resources/download-original/{resource}', [ResourceController::class, 'downloadOriginal'])->name('resources.downloadOriginal');
    Route::get('resources/download-pdf/{resource}', [ResourceController::class, 'downloadAsPdf'])->name('resources.downloadAsPdf');
    Route::get('resources/download/{resource}', [ResourceController::class, 'download'])->name('resources.download');
    Route::post('resources/download-all-by-course', [ResourceController::class, 'downloadAllByCourse'])->name('resources.downloadAllByCourse');
    Route::post('resources/bulk-download', [ResourceController::class, 'bulkDownload'])->name('resources.bulkDownload');
    Route::post('resources/get-resources-json', [ResourceController::class, 'getResourcesJson'])->name('resources.getResourcesJson');


    Route::post('syllabi/lessonCreation', [SyllabusController::class, 'lessonCreation'])->name('syllabi.lessonCreation');
    Route::post('syllabi/storeByUrl', [SyllabusController::class, 'storeByUrl'])->name('syllabi.storeByUrl');
    Route::post('syllabi/uploadByUrl', [SyllabusController::class, 'uploadByUrl'])->name('syllabi.uploadByUrl');
    Route::get('syllabi/preview/{syllabus}', [SyllabusController::class, 'preview'])->name('syllabi.preview');
    Route::post('syllabi/upload', [SyllabusController::class, 'upload'])->name('syllabi.upload');
    Route::resource('syllabi', SyllabusController::class);

    Route::get('presentations/preview/{presentation}', [PresentationResourceController::class, 'preview'])->name('presentations.preview');
    Route::post('presentations/uploadByUrl', [PresentationResourceController::class, 'uploadByUrl'])->name('presentations.uploadByUrl');
    Route::post('presentations/upload', [PresentationResourceController::class, 'upload'])->name('presentations.upload');
    Route::resource('presentations', PresentationResourceController::class);

    Route::resource('courses', CourseController::class);
    Route::resource('archive', ArchiveController::class);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');

    Route::resource('storage', StorageController::class);
    Route::get('storage/{user}', [StorageController::class, 'show'])->name('storage.show');

    // saved resources
    Route::resource('saved-resources', SavedResourceController::class);

    Route::put('pending-resources/approve/{resource}', [PendingResourceController::class, 'approve'])
        ->name('pending-resources.approve');
    Route::put('pending-resources/reject/{resource}', [PendingResourceController::class, 'reject'])
        ->name('pending-resources.reject');
    Route::resource('pending-resources', PendingResourceController::class);

    Route::resource('important-resources', ImportantResourceController::class);

    Route::resource('deleted-resources', DeletedResourceController::class);

    // Route::resource('comments', CommentController::class);

    Route::resource('upload-temporary-file', UploadTemporaryFileController::class);

    // Admin
    Route::prefix('admin')->name('admin.')
        ->middleware(['auth.admin'])->group(function () {
            Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::get('/programs/list', [AdminProgramController::class, 'list'])->name('programs.list');
            Route::resource('/programs', AdminProgramController::class);
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

        // Route::resource('course', InstructorCourseController::class);
        // Route::get('resource/preview/{resource}', [InstructorResourceController::class, 'preview'])->name('resource.preview');
        // Route::get('resource/create/{lesson}', [InstructorResourceController::class, 'create'])->name('resource.create');
        // Route::resource('resource', InstructorResourceController::class)->except(['create']);
        // Route::resource('lesson', InstructorLessonController::class);
    });
});



require __DIR__ . '/auth.php';
