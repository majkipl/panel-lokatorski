<?php

use App\Domains\Auth\Application\Controllers\LoginController;
use App\Domains\Auth\Application\Controllers\RegisterController;
use App\Domains\Billing\Application\Controllers\BillingController;
use App\Domains\Expense\Application\Controllers\ExpenseController;
use App\Domains\Payment\Application\Controllers\PaymentController;
use App\Domains\User\Application\Controllers\TenantController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('inRoles:user|admin')->group(function () {
        Route::get('/wydatki', [ExpenseController::class, 'index'])->name('expense');
        Route::get('/wydatki/dodaj', [ExpenseController::class, 'form'])->name('expense.form');
        Route::get('/wydatki/anuluj/{id}', [ExpenseController::class, 'cancel'])->name('expense.cancel');
        Route::post('/wydatki/dodaj', [ExpenseController::class, 'store'])->name('expense.save');

        Route::get('/rozliczenia', [BillingController::class, 'billing'])->name('billing');

        Route::middleware('role:admin')->group(function () {
            Route::get('/rozliczenia/{user}', [BillingController::class, 'billing'])->name('billing.user');

            Route::get('/admin/wplaty', [PaymentController::class, 'index'])->name('admin.payment');
            Route::get('/admin/wplaty/dodaj', [PaymentController::class, 'form'])->name('admin.payment.form');
            Route::post('/admin/wplaty/dodaj', [PaymentController::class, 'store'])->name('admin.payment.save');

            Route::get('/admin/lokatorzy', [TenantController::class, 'index'])->name('admin.tenant');
            Route::get('/admin/lokatorzy/dodaj', [TenantController::class, 'form'])->name('admin.tenant.form');
            Route::post('/admin/lokatorzy/dodaj', [TenantController::class, 'store'])->name('admin.tenant.save');
            Route::get('/admin/lokatorzy/blokuj/{user}', [TenantController::class, 'lock'])->name('admin.tenant.lock');
            Route::get('/admin/lokatorzy/odblokuj/{user}', [TenantController::class, 'unlock'])->name('admin.tenant.unlock');
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
