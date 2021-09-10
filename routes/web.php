<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeletedResourceController;
use App\Http\Controllers\ImportantResourceController;
use App\Http\Controllers\PendingResourceController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SavedResourceController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\UploadTemporaryFilesController;
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
    Route::get('resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');
    Route::resource('syllabi', SyllabusController::class);
    Route::resource('upload-temporary-files', UploadTemporaryFilesController::class);

    Route::resource('courses', CourseController::class);
    Route::resource('archive', ArchiveController::class);
    // saved resources
    Route::resource('saved-resources', SavedResourceController::class);
    Route::resource('pending-resources', PendingResourceController::class);
    Route::resource('important-resources', ImportantResourceController::class);
    Route::resource('deleted-resources', DeletedResourceController::class);
});



require __DIR__ . '/auth.php';