<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\SyllabusSettingController;
use App\Http\Controllers\Admin\SystemAdminController;
use App\Http\Controllers\Admin\TypologyStandardController as AdminTypologyStandardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\UploadTemporaryFileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PresentationResourceController;
use App\Http\Controllers\ProgramDean\ContentManagementController;
use App\Http\Controllers\ProgramDean\CourseController as ProgramDeanCourseController;
use App\Http\Controllers\ProgramDean\InstructorController as ProgramDeanInstructorsController;
use App\Http\Controllers\ProgramDean\LessonController as ProgramDeanLessonController;
use App\Http\Controllers\ProgramDean\ReportsController;
use App\Http\Controllers\ProgramDean\ResourceController as ProgramDeanResourceController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UsersController;
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
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('activities/{user}/user-activities', [ActivitiesController::class, 'showUserActivities'])->name('activities.showUserActivities');
    Route::resource('activities', ActivitiesController::class);

    Route::put('course/{course}/archive', [CourseController::class, 'archive'])->name('course.archive');
    Route::get('course/{course}/resources', [CourseController::class, 'showResources'])->name('course.showResources');
    Route::get('course/{course}/lessons', [CourseController::class, 'showLessons'])->name('course.showLessons');
    Route::get('course/{course}/user-lessons/{user}', [CourseController::class, 'showUserLessons'])->name('course.showUserLessons');
    Route::get('course/{course}', [CourseController::class, 'show'])->name('course.show');

    Route::post('resource/download-all-by-lesson/{lesson}', [ResourceController::class, 'downloadAllByLesson'])->name('resource.downloadAllByLesson');
    Route::post('resource/download-all-by-course/{course}', [ResourceController::class, 'downloadAllByCourse'])->name('resource.downloadAllByCourse');
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
    Route::get('resources/preview/{resource}', [ResourceController::class, 'preview'])->name('resources.preview');
    Route::post('resources/download-html/{media}', [ResourceController::class, 'downloadAsHtml'])->name('resources.downloadAsHtml');
    Route::post('resources/download-original/{media}', [ResourceController::class, 'downloadOriginal'])->name('resources.downloadOriginal');
    Route::post('resources/download-pdf/{media}', [ResourceController::class, 'downloadAsPdf'])->name('resources.downloadAsPdf');
    Route::get('resources/download/{media}', [ResourceController::class, 'download'])->name('resources.download');
    Route::post('resources/bulk-download', [ResourceController::class, 'bulkDownload'])->name('resources.bulkDownload');
    // Route::post('resources/get-resources-json', [ResourceController::class, 'getResourcesJson'])->name('resources.getResourcesJson');

    Route::get('syllabi/submit-syllabus/{course}', [SyllabusController::class, 'create'])->name('syllabi.create');
    Route::post('syllabi/{resource}/store-new-version-url', [SyllabusController::class, 'storeNewVersionByUrl'])->name('syllabi.storeNewVersionByUrl');
    Route::post('syllabi/{resource}/store-new-version', [SyllabusController::class, 'storeNewVersion'])->name('syllabi.storeNewVersion');
    Route::post('syllabi/{resource}/confirm-validation', [SyllabusController::class, 'confirmValidation'])->name('syllabi.confirmValidation');
    Route::post('syllabi/lessonCreation', [SyllabusController::class, 'lessonCreation'])->name('syllabi.lessonCreation');
    Route::post('syllabi/storeByUrl', [SyllabusController::class, 'storeByUrl'])->name('syllabi.storeByUrl');
    Route::post('syllabi/uploadByUrl/{course}', [SyllabusController::class, 'uploadByUrl'])->name('syllabi.uploadByUrl');
    Route::post('syllabi/upload/{course}', [SyllabusController::class, 'upload'])->name('syllabi.upload');

    Route::post('presentations/{resource}/store-new-version-url', [PresentationResourceController::class, 'storeNewVersionByUrl'])->name('presentations.storeNewVersionByUrl');
    Route::post('presentations/{resource}/store-new-version', [PresentationResourceController::class, 'storeNewVersion'])->name('presentations.storeNewVersion');
    Route::post('presentations/confirm-validation', [PresentationResourceController::class, 'confirmValidation'])->name('presentations.confirmValidation');
    Route::get('presentations/preview/{resource}', [PresentationResourceController::class, 'preview'])->name('presentations.preview');
    Route::post('presentations/uploadByUrl', [PresentationResourceController::class, 'uploadByUrl'])->name('presentations.uploadByUrl');
    Route::post('presentations/upload', [PresentationResourceController::class, 'upload'])->name('presentations.upload');
    // Route::resource('presentations', PresentationResourceController::class);

    Route::put('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('user/{user}/edit-lesson/{lesson}', [UsersController::class, 'editLesson'])->name('user.editLesson');
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

    Route::resource('upload-temporary-file', UploadTemporaryFileController::class);

    // Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth.admin'])->group(function () {
        Route::resource('/programs', ProgramsController::class);
        Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
        Route::resource('/users', UserController::class);
        Route::post('/typology/{typology}', [AdminTypologyStandardController::class, 'store'])->name('typology.store');
        Route::resource('/typology', AdminTypologyStandardController::class)->except(['create', 'store', 'edit', 'destroy']);
        Route::resource('/syllabus-settings', SyllabusSettingController::class)->except(['create', 'store', 'edit', 'destroy']);
    });

    // Program dean
    Route::prefix('dean')->name('dean.')->as('dean.')->middleware(['auth.programdean'])->group(function () {
        Route::resource('resource', ProgramDeanResourceController::class);
        Route::put('instructor/{instructor}/update-course-assignment', [ProgramDeanInstructorsController::class, 'updateCourseAssignment'])->name('instructor.updateCourseAssignment');
        Route::resource('instructor', ProgramDeanInstructorsController::class);
        Route::put('course/{course}/archive', [ProgramDeanCourseController::class, 'archive'])->name('course.archive');
        Route::resource('course', ProgramDeanCourseController::class);
        Route::resource('lesson', ProgramDeanLessonController::class);

        Route::get('content-management/watermarks', [ContentManagementController::class, 'watermarks'])->name('cms.watermarks');
        Route::get('content-management/typology', [ContentManagementController::class, 'typology'])->name('cms.typology');
        Route::get('content-management/lessons', [ContentManagementController::class, 'lessons'])->name('cms.lessons');
        Route::get('content-management/courses', [ContentManagementController::class, 'courses'])->name('cms.courses');
        Route::get('content-management/personnels', [ContentManagementController::class, 'personnels'])->name('cms.personnels');
        Route::get('content-management/resources', [ContentManagementController::class, 'resources'])->name('cms.resources');

        Route::get('reports/instructors-table', [ReportsController::class, 'instructorsTable'])->name('reports.instructorsTable');
        Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
        Route::get('reports/course-submissions', [ReportsController::class, 'courseSubmissions'])->name('reports.courseSubmissions');
        Route::get('reports/submissions', [ReportsController::class, 'submissions'])->name('reports.submissions');
        Route::get('reports/syllabus', [ReportsController::class, 'syllabus'])->name('reports.syllabus');
        Route::get('reports/courses', [ReportsController::class, 'courses'])->name('reports.courses');
        Route::get('reports/instructors', [ReportsController::class, 'instructors'])->name('reports.instructors');
        Route::get('reports/lessons', [ReportsController::class, 'lessons'])->name('reports.lessons');
    });
});



require __DIR__ . '/auth.php';
