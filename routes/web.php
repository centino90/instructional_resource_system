<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DeletedResourceController;
use App\Http\Controllers\DogController;
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
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::resource('resources', ResourceController::class);
    Route::resource('syllabi', SyllabusController::class);
    Route::resource('uploadTemporaryFiles', UploadTemporaryFilesController::class);
    Route::resource('dogs', DogController::class);
    Route::post('dogs/storeAjax', [DogController::class, 'storeAjax'])->name('dogs.storeAjax');

    Route::resource('courses', CourseController::class);
    Route::resource('archive', ArchiveController::class);
    // saved resources
    Route::resource('saved-resources', SavedResourceController::class);
    Route::resource('pending-resources', PendingResourceController::class);
    Route::resource('important-resources', ImportantResourceController::class);
    Route::resource('deleted-resources', DeletedResourceController::class);
});



require __DIR__ . '/auth.php';