<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route Authentication
Route::middleware([])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/', 'login')->name('login');
        Route::get('/login', 'login')->name('login');
        Route::post('/authentication', 'auth')->name('auth');
        Route::get('/registrasi', 'registrasi')->name('registrasi');
        Route::post('/registrasi', 'signup')->name('signup');
    });
});