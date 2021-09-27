<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeletedResourceController;
use App\Http\Controllers\ImportantResourceController;
use App\Http\Controllers\PendingResourceController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SavedResourceController;
use App\Http\Controllers\SyllabusController;
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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('resources', ResourceController::class);
    Route::get('resources/download/{resource}', [ResourceController::class, 'download'])->name('resources.download');
    Route::post('resources/download-all-by-course', [ResourceController::class, 'downloadAllByCourse'])->name('resources.downloadAllByCourse');
    Route::post('resources/bulk-download', [ResourceController::class, 'bulkDownload'])->name('resources.bulkDownload');
    Route::post('resources/get-resources-json', [ResourceController::class, 'getResourcesJson'])->name('resources.getResourcesJson');

    Route::resource('syllabi', SyllabusController::class);

    Route::resource('courses', CourseController::class);
    Route::resource('archive', ArchiveController::class);
    Route::get('notifications', function (HttpRequest $request) {
        if ($request->view == 'read-notifications') {
            return view('readnotifications')->with('readNotifications', auth()->user()->notifications()->whereNotNull('read_at')->get());
        }
        return view('notifications');
    })->name('notifications.index');
    Route::put('notifications/{notification}', function ($notificationId) {
        auth()->user()
            ->unreadNotifications
            ->when($notificationId, function ($query) use ($notificationId) {
                return $query->where('id', $notificationId);
            })
            ->markAsRead();
        return response()->json(['status' => 200, 'message' => 'success']);
    })->name('notifications.update');
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
});



require __DIR__ . '/auth.php';
