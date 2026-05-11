<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Dummy data for Admin Dashboard
        $admin = [
            'name' => 'Admin Utama',
        ];

        $stats = [
            'monthly_revenue' => 'Rp 15.450.000',
            'revenue_trend' => '+12.5%',
            'total_users' => 1245,
            'users_trend' => '+45',
            'successful_orders' => 384,
            'orders_trend' => '+8.2%',
            'complaint_tickets' => 5,
            'tickets_trend' => '-2',
        ];

        $recent_transactions = [
            ['user' => 'Budi Santoso', 'product' => 'Netflix Premium 1 Bulan', 'total' => 'Rp 35.000', 'payment' => 'QRIS', 'status' => 'Sukses'],
            ['user' => 'Siti Aminah', 'product' => 'Canva Pro 1 Tahun', 'total' => 'Rp 150.000', 'payment' => 'Gopay', 'status' => 'Sukses'],
            ['user' => 'Andi Wijaya', 'product' => 'Spotify Family 3 Bulan', 'total' => 'Rp 85.000', 'payment' => 'Transfer Bank', 'status' => 'Menunggu'],
            ['user' => 'Rina Melati', 'product' => 'Zoom Pro 1 Bulan', 'total' => 'Rp 45.000', 'payment' => 'OVO', 'status' => 'Sukses'],
            ['user' => 'Dedi Kurniawan', 'product' => 'Netflix Premium 1 Bulan', 'total' => 'Rp 35.000', 'payment' => 'QRIS', 'status' => 'Gagal'],
        ];

        return view('admin.dashboard', compact('admin', 'stats', 'recent_transactions'));
    }

    public function produk()
    {
        $admin = ['name' => 'Superadmin'];
        $products = [
            ['id' => 1, 'name' => 'Netflix Premium 1 Bulan', 'category' => 'Streaming', 'price' => 35000, 'stock' => 15, 'max_stock' => 20, 'status' => 'Aktif', 'desc' => 'Akun sharing 1 profile 1 device. Resolusi 4K UHD. Garansi penuh 1 bulan.'],
            ['id' => 2, 'name' => 'Spotify Family 1 Bulan', 'category' => 'Musik', 'price' => 25000, 'stock' => 0, 'max_stock' => 10, 'status' => 'Habis', 'desc' => 'Invite via link family. Akun private region Indonesia. Anti banned.'],
            ['id' => 3, 'name' => 'Canva Pro 1 Bulan', 'category' => 'Desain', 'price' => 15000, 'stock' => 50, 'max_stock' => 50, 'status' => 'Nonaktif', 'desc' => 'Invite tim Canva Pro. Semua fitur premium terbuka. Legal 100%.'],
        ];
        return view('admin.produk', compact('admin', 'products'));
    }

    public function transaksi()
    {
        $admin = ['name' => 'Superadmin'];
        $transactions = [
            ['id' => 'TRX-901', 'date' => '2026-05-11 10:30', 'user' => 'Budi Santoso', 'product' => 'Netflix Premium 1 Bulan', 'total' => 'Rp 35.000', 'method' => 'QRIS', 'status' => 'Menunggu'],
            ['id' => 'TRX-900', 'date' => '2026-05-11 09:15', 'user' => 'Siti Aminah', 'product' => 'Spotify Family 1 Bulan', 'total' => 'Rp 25.000', 'method' => 'Transfer BCA', 'status' => 'Sukses'],
            ['id' => 'TRX-899', 'date' => '2026-05-10 20:45', 'user' => 'Andi Wijaya', 'product' => 'Canva Pro 1 Tahun', 'total' => 'Rp 150.000', 'method' => 'Gopay', 'status' => 'Gagal'],
        ];
        return view('admin.transaksi', compact('admin', 'transactions'));
    }

    public function pengguna()
    {
        $admin = ['name' => 'Superadmin'];
        $users = [
            ['id' => 1, 'name' => 'Budi Santoso', 'email' => 'budi@student.ac.id', 'role' => 'Member', 'points' => 1200, 'join_date' => '2026-01-15', 'status' => 'Aktif'],
            ['id' => 2, 'name' => 'Siti Aminah', 'email' => 'siti@gmail.com', 'role' => 'Member', 'points' => 450, 'join_date' => '2026-03-22', 'status' => 'Aktif'],
            ['id' => 3, 'name' => 'Andi Wijaya', 'email' => 'andi@yahoo.com', 'role' => 'Member', 'points' => 0, 'join_date' => '2026-05-01', 'status' => 'Suspended'],
        ];
        return view('admin.pengguna', compact('admin', 'users'));
    }

    public function laporan()
    {
        $admin = ['name' => 'Superadmin'];
        return view('admin.laporan', compact('admin'));
    }

    public function pengaturan()
    {
        $admin = ['name' => 'Superadmin'];
        return view('admin.pengaturan', compact('admin'));
    }
}
