<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClientController,
    PersonController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/admin', function () {
        return view('dashboard');
    });

    //Route::resource('/admin/person', PersonController::class);
    Route::resource('/admin/client', ClientController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
