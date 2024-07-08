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
Route::get('/logout', [\App\Http\Controllers\Customer\LoginController::class, 'logout'])->name('customer.logout');

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [\App\Http\Controllers\Customer\ProductController::class, 'index'])->name('customer.product');
    Route::get('/{id}', [\App\Http\Controllers\Customer\ProductController::class, 'detail'])->name('customer.product.detail');
});

Route::group(['prefix' => 'keranjang'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Customer\KeranjangController::class, 'index'])->name('customer.cart');
    Route::post('/checkout', [\App\Http\Controllers\Customer\KeranjangController::class, 'checkout'])->name('customer.checkout');
    Route::post('/{id}/delete', [\App\Http\Controllers\Customer\KeranjangController::class, 'delete'])->name('customer.delete');
});

Route::group(['prefix' => 'pesanan'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Customer\PesananController::class, 'index'])->name('customer.order');
    Route::get('/{id}', [\App\Http\Controllers\Customer\PesananController::class, 'detail'])->name('customer.order.detail');
    Route::match(['post', 'get'],'/{id}/pembayaran', [\App\Http\Controllers\Customer\PesananController::class, 'pembayaran'])->name('customer.order.payment');
});

Route::group(['prefix' => 'admin'], function () {
    Route::match(['post', 'get'],'/', [\App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login');
    Route::get('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'pengguna'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna');
        Route::match(['post', 'get'], '/add', [\App\Http\Controllers\Admin\PenggunaController::class, 'add'])->name('admin.pengguna.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\PenggunaController::class, 'edit'])->name('admin.pengguna.edit');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PenggunaController::class, 'delete'])->name('admin.pengguna.delete');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customer');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product');
        Route::match(['post', 'get'], '/add', [\App\Http\Controllers\Admin\ProductController::class, 'add'])->name('admin.product.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('admin.product.delete');
    });

    Route::group(['prefix' => 'pesanan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\PesananController::class, 'index'])->name('admin.order');
        Route::match(['post', 'get'],'/{id}/pesanan-baru', [\App\Http\Controllers\Admin\PesananController::class, 'detail_new'])->name('admin.order.detail.new');
        Route::match(['post', 'get'],'/{id}/pesanan-proses', [\App\Http\Controllers\Admin\PesananController::class, 'detail_process'])->name('admin.order.detail.process');
        Route::match(['post', 'get'],'/{id}/siap-diambil', [\App\Http\Controllers\Admin\PesananController::class, 'detail_take'])->name('admin.order.detail.take');
        Route::match(['post', 'get'],'/{id}/pesanan-selesai', [\App\Http\Controllers\Admin\PesananController::class, 'detail_finish'])->name('admin.order.detail.finish');
    });

    Route::group(['prefix' => 'laporan-penjualan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.report');
        Route::get('/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'pdf'])->name('admin.report.print');
    });


});
