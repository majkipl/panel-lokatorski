<?php

use App\Domains\Auth\Application\Controllers\LoginController;
use App\Domains\Auth\Application\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

//require __DIR__.'/auth.php';

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::middleware('inRoles:user|admin')->group(function () {
        Route::get('/wydatki', function () {
            return view('welcome');
        })->name('expense');
        Route::get('/wydatki/dodaj', function () {
            return view('welcome');
        })->name('expense.form');
        Route::get('/wydatki/anuluj/{id}', function () {
            return view('welcome');
        })->name('expense.cancel');
        Route::post('/wydatki/dodaj', function () {
            return view('welcome');
        })->name('expense.save');
        Route::get('/rozliczenia', function () {
            return view('welcome');
        })->name('billing');

        Route::middleware('role:admin')->group(function () {
            Route::get('/rozliczenia/{user}', function () {
                return view('welcome');
            })->name('billing.user');

            Route::get('/admin/wplaty', function () {
                return view('welcome');
            })->name('admin.payment');
            Route::get('/admin/wplaty/dodaj', function () {
                return view('welcome');
            })->name('admin.payment.form');
            Route::post('/admin/wplaty/dodaj', function () {
                return view('welcome');
            })->name('admin.payment.save');

            Route::get('/admin/lokatorzy', function () {
                return view('welcome');
            })->name('admin.tenant');
            Route::get('/admin/lokatorzy/dodaj', function () {
                return view('welcome');
            })->name('admin.tenant.form');
            Route::post('/admin/lokatorzy/dodaj', function () {
                return view('welcome');
            })->name('admin.tenant.save');
            Route::get('/admin/lokatorzy/blokuj/{user}', function () {
                return view('welcome');
            })->name('admin.tenant.lock');
            Route::get('/admin/lokatorzy/odblokuj/{user}', function () {
                return view('welcome');
            })->name('admin.tenant.unlock');
        });
    });
});

// Rejestracja
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Logowanie
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
