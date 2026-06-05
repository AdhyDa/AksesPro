<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ══════════════════════════════════════════════════════════════════
// PUBLIC ROUTES — Halaman Publik / Landing Page
// ══════════════════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Google SSO ────────────────────────────────────────────────────
// ⚠️ JANGAN ubah ini ke Inertia. Ini adalah redirect OAuth murni.
// Di frontend: gunakan <a href="/auth/google/redirect"> — BUKAN <Link>
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('auth.google.callback');

// ── Midtrans Webhook ──────────────────────────────────────────────
// ⚠️ PENGECUALIAN KRITIKAL: Route ini mengembalikan JSON response.
// JANGAN sentuh MidtransCallbackController. CSRF dikecualikan di bootstrap/app.php.
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleNotification'])
    ->name('midtrans.callback');

// ══════════════════════════════════════════════════════════════════
// INERTIA GENERIC DASHBOARD
// Default Breeze dashboard route — redirect berdasarkan role
// ══════════════════════════════════════════════════════════════════

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ══════════════════════════════════════════════════════════════════
// USER ROUTES — Area member yang sudah login
// ══════════════════════════════════════════════════════════════════

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // Dashboard utama user
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // Katalog produk
    Route::get('/katalog', [UserDashboardController::class, 'katalog'])
        ->name('katalog');
    Route::get('/katalog/{slug}', [UserDashboardController::class, 'showProduct'])
        ->name('katalog.detail');

    // Proses pembayaran → Inertia Checkout.jsx
    Route::post('/checkout/{slug}', [TransactionController::class, 'processPayment'])
        ->name('checkout');

    // Langganan aktif
    Route::get('/langganan', [UserDashboardController::class, 'langganan'])
        ->name('langganan');

    // Riwayat transaksi
    Route::get('/transaksi', [UserDashboardController::class, 'transaksi'])
        ->name('transaksi');

    // Invoice download (PDF — tetap Blade/DomPDF, bukan Inertia)
    Route::get('/invoice/{invoiceId}', [UserDashboardController::class, 'downloadInvoice'])
        ->name('invoice');

    // Tukar Poin
    Route::get('/poin', [UserDashboardController::class, 'poin'])
        ->name('poin');
    Route::get('/poin/{slug}', [UserDashboardController::class, 'showPoinProduct'])
        ->name('poin.detail');
    Route::post('/poin/{id}/redeem', [UserDashboardController::class, 'redeemPoin'])
        ->name('poin.redeem');

    // Bantuan & Support
    Route::get('/bantuan', [UserDashboardController::class, 'bantuan'])
        ->name('bantuan');
});

// ══════════════════════════════════════════════════════════════════
// ADMIN ROUTES — Area administrator
// ══════════════════════════════════════════════════════════════════

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Manajemen Produk
    Route::get('/produk', [AdminDashboardController::class, 'produk'])
        ->name('produk');
    Route::post('/produk', [AdminDashboardController::class, 'storeProduct'])
        ->name('produk.store');
    Route::put('/produk/{id}', [AdminDashboardController::class, 'updateProduct'])
        ->name('produk.update');
    Route::delete('/produk/{id}', [AdminDashboardController::class, 'deleteProduct'])
        ->name('produk.delete');
    Route::patch('/produk/{id}/toggle', [AdminDashboardController::class, 'toggleProductActive'])
        ->name('produk.toggle');

    // Manajemen Transaksi
    Route::get('/transaksi', [AdminDashboardController::class, 'transaksi'])
        ->name('transaksi');
    Route::post('/transaksi/{id}/verify', [AdminDashboardController::class, 'verifyTransaction'])
        ->name('transaksi.verify');
    Route::post('/transaksi/{id}/reject', [AdminDashboardController::class, 'rejectTransaction'])
        ->name('transaksi.reject');
    Route::get('/transaksi/export-csv', [AdminDashboardController::class, 'exportTransactionsCsv'])
        ->name('transaksi.export-csv');

    // Manajemen Pengguna
    Route::get('/pengguna', [AdminDashboardController::class, 'pengguna'])
        ->name('pengguna');
    Route::post('/pengguna', [AdminDashboardController::class, 'storeUser'])
        ->name('pengguna.store');
    Route::put('/pengguna/{id}', [AdminDashboardController::class, 'updateUser'])
        ->name('pengguna.update');
    Route::delete('/pengguna/{id}', [AdminDashboardController::class, 'deleteUser'])
        ->name('pengguna.delete');
    Route::patch('/pengguna/{id}/toggle', [AdminDashboardController::class, 'toggleUserStatus'])
        ->name('pengguna.toggle');

    // Laporan
    Route::get('/laporan', [AdminDashboardController::class, 'laporan'])
        ->name('laporan');
    Route::get('/laporan/export-pdf', [AdminDashboardController::class, 'exportLaporanPdf'])
        ->name('laporan.export-pdf');

    // Pengaturan
    Route::get('/pengaturan', [AdminDashboardController::class, 'pengaturan'])
        ->name('pengaturan');
    Route::post('/pengaturan/umum', [AdminDashboardController::class, 'saveSettingsUmum'])
        ->name('pengaturan.umum');
    Route::post('/pengaturan/pembayaran', [AdminDashboardController::class, 'saveSettingsPembayaran'])
        ->name('pengaturan.pembayaran');
    Route::post('/pengaturan/email', [AdminDashboardController::class, 'saveSettingsEmail'])
        ->name('pengaturan.email');
});

// ══════════════════════════════════════════════════════════════════
// PROFILE ROUTES — Breeze default (sudah pakai Inertia)
// ══════════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ══════════════════════════════════════════════════════════════════
// AUTH ROUTES — Breeze (Login, Register, Reset Password, etc.)
// ══════════════════════════════════════════════════════════════════
require __DIR__ . '/auth.php';
