<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [Backend\DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => ['user-access:owner']], function () {
        Route::get('log-activities', [Backend\LogActivityController::class, 'index'])->name('log-activities');
        Route::resource('employees', Backend\EmployeeController::class);
    });

    Route::group(['middleware' => ['user-access:owner,kepala-toko']], function () {
        Route::resource('products', Backend\ProductController::class);
        Route::get('product/safe-stock', [Backend\ProductController::class, 'safeStock'])->name('safe-stock');
        Route::get('product/out-of-stock', [Backend\ProductController::class, 'outOfStock'])->name('out-of-stock');
        Route::get('product/{product}/print', [Backend\ProductController::class, 'print'])->name('products.print');
    });

    Route::group(['middleware' => ['user-access:owner,admin']], function () {
        Route::get('transactions', [Backend\TransactionController::class, 'index'])->name('transactions');
        Route::get('transactions/print/{id}', [Backend\TransactionController::class, 'print'])->name('transactions.print');
    });

    Route::group(['middleware' => ['user-access:admin']], function () {
        Route::resource('cashier', Backend\CashierController::class);
        Route::post('cashier/select/{id}', [Backend\CashierController::class, 'select'])->name('select');
    });

    Route::resources([
        'branches' => Backend\BranchController::class,
        'discounts' => Backend\DiscountController::class,
        'carts' => Backend\CartController::class,
        'report' => Backend\ReportController::class,
        'profile' => Backend\ProfileController::class,
        'password-change' => Backend\PasswordController::class,
    ]);
});