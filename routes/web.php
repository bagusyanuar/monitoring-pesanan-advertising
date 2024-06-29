<?php

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

Route::get('/', [\App\Http\Controllers\Customer\BerandaController::class, 'index'])->name('customer.home');
Route::match(['post', 'get'],'/login', [\App\Http\Controllers\Customer\LoginController::class, 'login'])->name('customer.login');
Route::match(['post', 'get'],'/register', [\App\Http\Controllers\Customer\RegisterController::class, 'register'])->name('customer.register');

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('customer.product');
    Route::get('/{id}', [\App\Http\Controllers\Customer\ProductController::class, 'detail'])->name('customer.product.detail');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product');
        Route::match(['post', 'get'], '/add', [\App\Http\Controllers\Admin\ProductController::class, 'add'])->name('admin.product.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('admin.product.delete');
    });
});
