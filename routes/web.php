<?php

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
use App\Http\Controllers\EventController;

//crud evento


Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
Route::get('/events/{id}', [EventController::class, 'show']);

Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

Route::post('/events', [EventController::class, 'store']);

Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');

//para participar nos eventos
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');

//views evento

Route::get('/', [EventController::class, 'index']);

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/phpinfo', function () {
    return view('phpinfo');
});


Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');
