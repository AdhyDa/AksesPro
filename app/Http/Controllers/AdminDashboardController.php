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
}
