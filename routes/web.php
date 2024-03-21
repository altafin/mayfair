<?php

use App\Http\Controllers\{
    ClientSimplifiedController,
    StateController,
    CityController
};
use Illuminate\Support\Facades\Route;

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
    //Route::get('/admin/client/list', [ClientController::class, 'list'])->name('client.list');
    Route::resource('/admin/simplified/client', ClientSimplifiedController::class);
    Route::resource('/admin/state', StateController::class)->only('index');
    Route::resource('/admin/city/{state}', CityController::class)->only('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
