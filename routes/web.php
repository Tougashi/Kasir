<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
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
Route::middleware(['guest'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/', 'login')->name('login');
        Route::get('/login', 'login')->name('login');
        Route::post('/authentication', 'auth')->name('auth');
        Route::get('/registrasi', 'registrasi')->name('registrasi');
        Route::post('/registrasi', 'signup')->name('signup');
    });
});


Route::middleware('auth')->group(function () {

    Route::controller(AuthController::class)->group(function(){
        Route::get('/logout', 'logout')->name('logout');
    });

    Route::get('/not-allowed-method', function(){
        return view('errors.minimal2', [
            'title' => 'Bad Request',
            'code' => 400,
            'message' => 'Bad Request'
        ]);
    })->name('preventCrossLevel');

    Route::controller(UserController::class)->prefix('user')->group(function(){
        Route::get('/info', 'show');
    });

    Route::middleware('checkRole:Admin')->group(function () {
        Route::prefix('admin')->group(function(){

            Route::controller(UserController::class)->prefix('account')->group(function(){
                Route::get('/', 'index');
                Route::get('/add', 'create');
                Route::post('/add/store', 'store')->name('users.store');
                Route::get('/edit/{user}', 'edit')->name('users.edit');
                Route::put('/update/{user}', 'update')->name('users.update');
                Route::get('/delete/{user}', 'destroy')->name('users.destroy');
            });

            Route::controller(DashboardAdminController::class)->group(function(){
                Route::get('/dashboard', 'index');
            });

            Route::prefix('products')->group(function(){
                Route::controller(ProductController::class)->group(function(){
                    Route::get('/', 'index');
                    Route::get('/add', 'create');
                    Route::get('/edit/{code}', 'edit');
                    Route::post('/add/store', 'store');
                    Route::post('/update/{code}', 'update');
                    Route::get('/delete/{code}', 'destroy');
                    Route::get('/stock-in', 'stockIn');
                    // Route::get('/expired', 'expired');
                    Route::post('/stock-in/update', 'updateStock');
                    Route::get('/get/{code}', 'getProductData');
                });

                Route::prefix('categories')->controller(CategoryController::class)->group(function(){
                    Route::get('/', 'index');
                    Route::get('/add', 'create');
                    Route::post('/create/store', 'store');
                    Route::get('/edit/{slug}', 'edit');
                    Route::get('/delete/{slug}', 'destroy');
                    Route::post('/update/{slug}', 'update');
                    Route::post('/add/store', 'store');
                });
            });

            Route::prefix('suppliers')->controller(SupplierController::class)->group(function(){
                Route::get('/', 'index');
                Route::get('/add', 'create');
                Route::get('/edit/{code}', 'edit');
                Route::post('/add/store', 'store');
                Route::post('/update', 'update');
                Route::get('/delete/{code}', 'destroy');
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
