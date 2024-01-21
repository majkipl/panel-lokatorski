<?php

use App\Domains\Balance\Application\Controllers\Api\BalanceController;
use App\Domains\Expense\Application\Controllers\Api\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('/user/expense', [ExpenseController::class, 'index'])->name('api.user.expense');
    Route::get('/user/balance', [BalanceController::class, 'index'])->name('api.user.balance');
});
