<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;

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
        Route::get('/logout', 'logout')->name('logout');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/not-allowed-method', function(){
        return view('errors.minimal2', [
            'title' => 'Bad Request',
            'code' => 400,
            'message' => 'Bad Request'
        ]);
    })->name('preventCrossLevel');

    Route::middleware('checkRole:Admin')->group(function () {
        Route::prefix('admin')->group(function(){
            Route::controller(DashboardAdminController::class)->group(function(){
                Route::get('/dashboard', 'index');
            });
        });
    });

    Route::middleware('checkRole:Cashier')->group(function () {
        Route::prefix('cashier')->group(function(){
            Route::controller(DashboardAdminController::class)->group(function(){
                Route::get('/dashboard', 'index');
            });
        });
    });





});
