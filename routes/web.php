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

    // Midtrans Snap Checkout
    Route::post('/user/checkout/{slug}', [\App\Http\Controllers\TransactionController::class, 'processPayment'])->name('user.checkout.process');
});

// Midtrans Webhook Callback (Public)
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransCallbackController::class, 'handleNotification'])->name('midtrans.callback');



Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard & Laporan
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/laporan', [AdminDashboardController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/pdf', [AdminDashboardController::class, 'exportLaporanPdf'])->name('admin.laporan.pdf');

    // CRUD Produk
    Route::get('/produk', [AdminDashboardController::class, 'produk'])->name('admin.produk');
    Route::post('/produk', [AdminDashboardController::class, 'storeProduct'])->name('admin.produk.store');
    Route::post('/produk/{id}', [AdminDashboardController::class, 'updateProduct'])->name('admin.produk.update');
    Route::delete('/produk/{id}', [AdminDashboardController::class, 'deleteProduct'])->name('admin.produk.delete');
    Route::post('/produk/{id}/toggle-active', [AdminDashboardController::class, 'toggleProductActive'])->name('admin.produk.toggle-active');

    // Transaksi
    Route::get('/transaksi', [AdminDashboardController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/transaksi/export', [AdminDashboardController::class, 'exportTransactionsCsv'])->name('admin.transaksi.export');
    Route::post('/transaksi/{id}/verify', [AdminDashboardController::class, 'verifyTransaction'])->name('admin.transaksi.verify');
    Route::post('/transaksi/{id}/reject', [AdminDashboardController::class, 'rejectTransaction'])->name('admin.transaksi.reject');

    // CRUD Pengguna
    Route::get('/pengguna', [AdminDashboardController::class, 'pengguna'])->name('admin.pengguna');
    Route::post('/pengguna', [AdminDashboardController::class, 'storeUser'])->name('admin.pengguna.store');
    Route::post('/pengguna/{id}', [AdminDashboardController::class, 'updateUser'])->name('admin.pengguna.update');
    Route::delete('/pengguna/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.pengguna.delete');
    Route::post('/pengguna/{id}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.pengguna.toggle-status');
    
    // Pengaturan
    Route::get('/pengaturan', [AdminDashboardController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::post('/pengaturan/umum', [AdminDashboardController::class, 'saveSettingsUmum'])->name('admin.pengaturan.umum');
    Route::post('/pengaturan/pembayaran', [AdminDashboardController::class, 'saveSettingsPembayaran'])->name('admin.pengaturan.pembayaran');
    Route::post('/pengaturan/email', [AdminDashboardController::class, 'saveSettingsEmail'])->name('admin.pengaturan.email');
});

require __DIR__.'/auth.php';
