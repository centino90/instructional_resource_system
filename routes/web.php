<?php

use App\Http\Controllers\ResourceController;
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
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('resources', ResourceController::class);
    Route::view('/subjects', 'subjects')->name('subjects');
    Route::view('/archive', 'archive')->name('archive');
});



require __DIR__ . '/auth.php';