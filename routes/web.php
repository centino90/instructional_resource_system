<?php

use App\Http\Controllers\ActivitiesController;
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
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PresentationResourceController;
use App\Http\Controllers\ProgramDean\ContentManagementController;
use App\Http\Controllers\ProgramDean\InstructorsController as ProgramDeanInstructorsController;
use App\Http\Controllers\ProgramDean\ReportsController;
use App\Http\Controllers\ProgramDean\ResourceController as ProgramDeanResourceController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ProgramDean\TypologyStandardController;
use App\Http\Controllers\UsersController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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


    Route::get('activities/{user}/user-activities', [ActivitiesController::class, 'showUserActivities'])->name('activities.showUserActivities');
    Route::resource('activities', ActivitiesController::class);

    Route::resource('program', ProgramController::class);

    Route::get('course/{course}/resources', [CourseController::class, 'showResources'])->name('course.showResources');
    Route::get('course/{course}/most-active-instructors', [CourseController::class, 'showMostActiveInstructors'])->name('course.showMostActiveInstructors');
    Route::get('course/{course}/lessons', [CourseController::class, 'showLessons'])->name('course.showLessons');
    Route::get('course/{course}/user-lessons/{user}', [CourseController::class, 'showUserLessons'])->name('course.showUserLessons');
    Route::resource('course', CourseController::class);

    Route::put('resource/{resource}/cancel-submission', [ResourceController::class, 'cancelSubmission'])->name('resource.cancelSubmission');
    Route::put('resource/{resource}/toggle-archive-state', [ResourceController::class, 'toggleArchiveState'])->name('resource.toggleArchiveState');
    Route::get('resource/add-view-redirect-preview/{resource}', [ResourceController::class, 'addViewCountThenRedirectToPreview'])->name('resource.addViewCountThenRedirectToPreview');
    Route::get('resource/add-view-redirect-show/{resource}', [ResourceController::class, 'addViewCountThenRedirectToShow'])->name('resource.addViewCountThenRedirectToShow');
    Route::put('resource/confirm', [ResourceController::class, 'confirm'])->name('resource.confirm');
    Route::post('resource/upload-old-images', [ResourceController::class, 'uploadOldImages'])->name('resource.uploadOldImages');
    Route::post('resource/upload-old-pdf', [ResourceController::class, 'uploadOldPdf'])->name('resource.uploadOldPdf');
    Route::get('resource/create-old/{lesson}', [ResourceController::class, 'createOld'])->name('resource.createOld');
    Route::post('resource/{resource}/store-new-version-url', [ResourceController::class, 'storeNewVersionByUrl'])->name('resource.storeNewVersionByUrl');
    Route::put('resource/{resource}/toggle-approve-state', [ResourceController::class, 'toggleApproveState'])->name('resource.toggleApproveState');
    Route::put('resource/{resource}/versions/{media}/update', [ResourceController::class, 'toggleCurrentVersion'])->name('resource.toggleCurrentVersion');
    Route::get('resource/{resource}/versions', [ResourceController::class, 'viewVersions'])->name('resource.viewVersions');
    Route::post('resource/{resource}/store-new-version', [ResourceController::class, 'storeNewVersion'])->name('resource.storeNewVersion');
    Route::get('resource/{resource}/create-new-version', [ResourceController::class, 'createNewVersion'])->name('resource.createNewVersion');
    Route::get('resource/preview/{resource}', [ResourceController::class, 'preview'])->name('resource.preview');
    Route::get('resource/create/{lesson}', [ResourceController::class, 'create'])->name('resource.create');
    Route::resource('resource', ResourceController::class)->except(['create']);

    Route::put('lesson/{lesson}/archive', [LessonController::class, 'archive'])->name('lesson.archive');
    Route::resource('lesson', LessonController::class);

    Route::post('resources/storeByUrl', [ResourceController::class, 'storeByUrl'])->name('resources.storeByUrl');
    // Route::resource('resources', ResourceController::class);
    Route::get('resources/preview/{resource}', [ResourceController::class, 'preview'])->name('resources.preview');
    Route::post('resources/download-html/{media}', [ResourceController::class, 'downloadAsHtml'])->name('resources.downloadAsHtml');
    Route::post('resources/download-original/{media}', [ResourceController::class, 'downloadOriginal'])->name('resources.downloadOriginal');
    Route::post('resources/download-pdf/{media}', [ResourceController::class, 'downloadAsPdf'])->name('resources.downloadAsPdf');
    Route::get('resources/download/{resource}', [ResourceController::class, 'download'])->name('resources.download');
    Route::post('resources/download-all-by-course', [ResourceController::class, 'downloadAllByCourse'])->name('resources.downloadAllByCourse');
    Route::post('resources/bulk-download', [ResourceController::class, 'bulkDownload'])->name('resources.bulkDownload');
    Route::post('resources/get-resources-json', [ResourceController::class, 'getResourcesJson'])->name('resources.getResourcesJson');


    Route::get('syllabi/submit-syllabus/{course}', [SyllabusController::class, 'create'])->name('syllabi.create');
    Route::post('syllabi/{resource}/store-new-version-url', [SyllabusController::class, 'storeNewVersionByUrl'])->name('syllabi.storeNewVersionByUrl');
    Route::post('syllabi/{resource}/store-new-version', [SyllabusController::class, 'storeNewVersion'])->name('syllabi.storeNewVersion');
    Route::post('syllabi/{resource}/confirm-validation', [SyllabusController::class, 'confirmValidation'])->name('syllabi.confirmValidation');
    Route::post('syllabi/lessonCreation', [SyllabusController::class, 'lessonCreation'])->name('syllabi.lessonCreation');
    Route::post('syllabi/storeByUrl', [SyllabusController::class, 'storeByUrl'])->name('syllabi.storeByUrl');
    Route::post('syllabi/uploadByUrl/{course}', [SyllabusController::class, 'uploadByUrl'])->name('syllabi.uploadByUrl');
    Route::get('syllabi/preview/{resource}', [SyllabusController::class, 'preview'])->name('syllabi.preview');
    Route::post('syllabi/upload/{course}', [SyllabusController::class, 'upload'])->name('syllabi.upload');
    Route::resource('syllabi', SyllabusController::class)->except('create');

    Route::post('presentations/{resource}/store-new-version-url', [PresentationResourceController::class, 'storeNewVersionByUrl'])->name('presentations.storeNewVersionByUrl');
    Route::post('presentations/{resource}/store-new-version', [PresentationResourceController::class, 'storeNewVersion'])->name('presentations.storeNewVersion');
    Route::post('presentations/confirm-validation', [PresentationResourceController::class, 'confirmValidation'])->name('presentations.confirmValidation');
    Route::get('presentations/preview/{resource}', [PresentationResourceController::class, 'preview'])->name('presentations.preview');
    Route::post('presentations/uploadByUrl', [PresentationResourceController::class, 'uploadByUrl'])->name('presentations.uploadByUrl');
    Route::post('presentations/upload', [PresentationResourceController::class, 'upload'])->name('presentations.upload');
    Route::resource('presentations', PresentationResourceController::class);

    Route::resource('courses', CourseController::class);


    Route::put('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::put('user/{user}/update-personal', [UsersController::class, 'updatePersonal'])->name('user.updatePersonal');
    Route::put('user/{user}/update-username', [UsersController::class, 'updateUsername'])->name('user.updateUsername');
    Route::put('user/{user}/update-password', [UsersController::class, 'updatePassword'])->name('user.updatePassword');
    Route::get('user/{user}/submissions', [UsersController::class, 'submissions'])->name('user.submissions');
    Route::get('user/{user}/notifications', [UsersController::class, 'notifications'])->name('user.notifications');
    Route::get('user/{user}/activities', [UsersController::class, 'activities'])->name('user.activities');
    Route::get('user/{user}/lessons', [UsersController::class, 'lessons'])->name('user.lessons');
    Route::resource('user', UsersController::class);

    Route::get('storage/restore', [StorageController::class, 'restore'])->name('storage.restore');
    Route::get('storage/{user}', [StorageController::class, 'show'])->name('storage.show');
    Route::resource('storage', StorageController::class)->except(['show']);

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
            // Route::resource('/dashboard', AdminDashboardController::class);

            // Route::get('/programs/list', [AdminProgramController::class, 'list'])->name('programs.list');
            // Route::resource('/programs', AdminProgramController::class);
            // Route::resource('/courses', CoursesController::class);
            // Route::resource('/resources', ResourcesController::class);
            // Route::resource('/personnels', PersonnelsController::class);
            // Route::resource('/notifications', NotificationsController::class);
            // Route::resource('/instructors', InstructorsController::class);
        });

    // Program dean
    Route::prefix('dean')->name('dean.')->as('dean.')->middleware(['auth.programdean'])->group(function () {
        Route::resource('resource', ProgramDeanResourceController::class);
        Route::resource('typology', TypologyStandardController::class);

        Route::get('content-management/watermarks', [ContentManagementController::class, 'watermarks'])->name('cms.watermarks');
        Route::get('content-management/typology', [ContentManagementController::class, 'typology'])->name('cms.typology');
        Route::get('content-management/lessons', [ContentManagementController::class, 'lessons'])->name('cms.lessons');
        Route::get('content-management/courses', [ContentManagementController::class, 'courses'])->name('cms.courses');
        Route::get('content-management/personnels', [ContentManagementController::class, 'personnels'])->name('cms.personnels');
        Route::get('content-management/resources', [ContentManagementController::class, 'resources'])->name('cms.resources');

        Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
        Route::get('reports/submissions', [ReportsController::class, 'submissions'])->name('reports.submissions');
        Route::get('reports/syllabus', [ReportsController::class, 'syllabus'])->name('reports.syllabus');
        Route::get('reports/courses', [ReportsController::class, 'courses'])->name('reports.courses');
        Route::get('reports/instructors', [ReportsController::class, 'instructors'])->name('reports.instructors');
        Route::get('reports/lessons', [ReportsController::class, 'lessons'])->name('reports.lessons');
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
