<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // For development/demonstration, we fetch the first member user if not authenticated
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        
        $user = [
            'name' => $userModel->name,
            'points' => $userModel->points,
        ];

        $activeSubscriptions = \App\Models\UserSubscription::where('user_id', $userModel->id)
            ->where('status', 'active')
            ->count();

        $totalTransactions = \App\Models\Transaction::where('user_id', $userModel->id)
            ->where('status', 'success')
            ->count();

        // Calculate Estimated Savings
        $estimatedSavings = 0;
        $userSubs = \App\Models\UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->get();
            
        foreach ($userSubs as $sub) {
            $estimatedSavings += ($sub->product->original_price - $sub->product->aksespro_price);
        }

        $stats = [
            'active_subscriptions' => $activeSubscriptions,
            'total_transactions' => $totalTransactions,
            'points_collected' => $userModel->points,
            'estimated_savings' => 'Rp ' . number_format($estimatedSavings, 0, ',', '.'),
        ];

        $activeSubsData = \App\Models\UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->where('status', 'active')
            ->get();

        $subscriptions = [];
        foreach ($activeSubsData as $sub) {
            $subscriptions[] = [
                'name' => $sub->product->name,
                'package' => $sub->product->duration_days . ' Hari',
                'end_date' => $sub->end_date->format('Y-m-d'),
                'status' => 'Aktif', // we filter by active anyway
            ];
        }

        return view('user.dashboard', compact('user', 'stats', 'subscriptions'));
    }

    public function katalog()
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];
        
        $products = \App\Models\Product::where('is_active', true)->get();
        
        return view('user.katalog', compact('user', 'products'));
    }

    public function showProduct($id)
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $product = \App\Models\Product::findOrFail($id);

        return view('user.katalog-detail', compact('user', 'product'));
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
