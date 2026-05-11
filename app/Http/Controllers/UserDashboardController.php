<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Dummy data for User Dashboard
        $user = [
            'name' => 'Adhy',
            'points' => 100,
        ];

        $stats = [
            'active_subscriptions' => 3,
            'total_transactions' => 12,
            'points_collected' => 350,
            'estimated_savings' => 'Rp 450.000',
        ];

        $subscriptions = [
            ['name' => 'Netflix Premium', 'package' => '1 Bulan', 'end_date' => '2026-06-15', 'status' => 'Aktif'],
            ['name' => 'Spotify Family', 'package' => '3 Bulan', 'end_date' => '2026-08-01', 'status' => 'Aktif'],
            ['name' => 'Canva Pro', 'package' => '1 Tahun', 'end_date' => '2027-01-10', 'status' => 'Mendekati Kedaluwarsa'],
        ];

        return view('user.dashboard', compact('user', 'stats', 'subscriptions'));
    }

    public function katalog()
    {
        $user = ['name' => 'Adhy', 'points' => 100];
        $products = [
            ['name' => 'Netflix Premium', 'category' => 'Streaming', 'price' => 35000, 'original_price' => 50000, 'duration' => '1 Bulan'],
            ['name' => 'Spotify Family', 'category' => 'Musik', 'price' => 25000, 'original_price' => 35000, 'duration' => '1 Bulan'],
            ['name' => 'Canva Pro', 'category' => 'Desain', 'price' => 15000, 'original_price' => 25000, 'duration' => '1 Bulan'],
            ['name' => 'Youtube Premium', 'category' => 'Streaming', 'price' => 20000, 'original_price' => 30000, 'duration' => '1 Bulan'],
            ['name' => 'Zoom Pro', 'category' => 'Produktivitas', 'price' => 40000, 'original_price' => 60000, 'duration' => '1 Bulan'],
            ['name' => 'Microsoft 365', 'category' => 'Produktivitas', 'price' => 50000, 'original_price' => 80000, 'duration' => '1 Tahun'],
        ];
        return view('user.katalog', compact('user', 'products'));
    }

    public function langganan()
    {
        $user = ['name' => 'Adhy', 'points' => 100];
        $subscriptions = [
            ['name' => 'Netflix Premium', 'package' => '1 Bulan', 'start_date' => '2026-05-15', 'end_date' => '2026-06-15', 'status' => 'Aktif', 'auto_renew' => true],
            ['name' => 'Spotify Family', 'package' => '3 Bulan', 'start_date' => '2026-05-01', 'end_date' => '2026-08-01', 'status' => 'Aktif', 'auto_renew' => false],
            ['name' => 'Canva Pro', 'package' => '1 Tahun', 'start_date' => '2026-01-10', 'end_date' => '2027-01-10', 'status' => 'Mendekati Kedaluwarsa', 'auto_renew' => false],
        ];
        return view('user.langganan', compact('user', 'subscriptions'));
    }

    public function transaksi()
    {
        $user = ['name' => 'Adhy', 'points' => 100];
        $transactions = [
            ['id' => 'INV-202605-001', 'date' => '2026-05-15', 'product' => 'Netflix Premium 1 Bulan', 'amount' => 35000, 'method' => 'QRIS', 'status' => 'Berhasil'],
            ['id' => 'INV-202605-002', 'date' => '2026-05-01', 'product' => 'Spotify Family 3 Bulan', 'amount' => 75000, 'method' => 'Gopay', 'status' => 'Berhasil'],
            ['id' => 'INV-202601-001', 'date' => '2026-01-10', 'product' => 'Canva Pro 1 Tahun', 'amount' => 150000, 'method' => 'Transfer Bank', 'status' => 'Berhasil'],
        ];
        return view('user.transaksi', compact('user', 'transactions'));
    }

    public function poin()
    {
        $user = ['name' => 'Adhy', 'points' => 35000]; // 35k points to test the UI (1 point = 1 Rp)
        $products = [
            ['name' => 'Netflix Premium', 'category' => 'Streaming', 'price' => 35000, 'original_price' => 50000, 'duration' => '1 Bulan'],
            ['name' => 'Spotify Family', 'category' => 'Musik', 'price' => 25000, 'original_price' => 35000, 'duration' => '1 Bulan'],
            ['name' => 'Canva Pro', 'category' => 'Desain', 'price' => 15000, 'original_price' => 25000, 'duration' => '1 Bulan'],
        ];
        return view('user.poin', compact('user', 'products'));
    }

    public function bantuan()
    {
        $user = ['name' => 'Adhy', 'points' => 100];
        return view('user.bantuan', compact('user'));
    }
}
