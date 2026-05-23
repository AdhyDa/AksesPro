<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Placeholder for future checkout/payment route
// Route::post('/checkout', [PaymentController::class, 'process'])->name('checkout.process');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::get('/user/katalog', [UserDashboardController::class, 'katalog'])->name('user.katalog');
Route::get('/user/katalog/{slug}', [UserDashboardController::class, 'showProduct'])->name('user.katalog.detail');
Route::get('/user/langganan', [UserDashboardController::class, 'langganan'])->name('user.langganan');
Route::get('/user/transaksi', [UserDashboardController::class, 'transaksi'])->name('user.transaksi');
Route::get('/user/transaksi/{invoice_id}/invoice', [UserDashboardController::class, 'downloadInvoice'])->name('user.transaksi.invoice');
Route::get('/user/poin', [UserDashboardController::class, 'poin'])->name('user.poin');
Route::get('/user/poin/{slug}', [UserDashboardController::class, 'showPoinProduct'])->name('user.poin.detail');
Route::post('/user/poin/{id}/redeem', [UserDashboardController::class, 'redeemPoin'])->name('user.poin.redeem');
Route::get('/user/bantuan', [UserDashboardController::class, 'bantuan'])->name('user.bantuan');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/produk', [AdminDashboardController::class, 'produk'])->name('admin.produk');
Route::get('/admin/transaksi', [AdminDashboardController::class, 'transaksi'])->name('admin.transaksi');
Route::get('/admin/pengguna', [AdminDashboardController::class, 'pengguna'])->name('admin.pengguna');
Route::get('/admin/laporan', [AdminDashboardController::class, 'laporan'])->name('admin.laporan');
Route::get('/admin/pengaturan', [AdminDashboardController::class, 'pengaturan'])->name('admin.pengaturan');

require __DIR__.'/auth.php';
