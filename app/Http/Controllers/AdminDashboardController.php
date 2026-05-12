<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'admin')->first();
        
        $admin = [
            'name' => $adminModel ? $adminModel->name : 'Superadmin',
        ];

        $currentMonth = now()->month;

        $monthlyRevenue = \App\Models\Transaction::where('status', 'success')
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_amount');

        $totalUsers = \App\Models\User::where('role', 'member')->count();

        $successfulOrders = \App\Models\Transaction::where('status', 'success')->count();

        $complaintTickets = \App\Models\Ticket::where('status', 'open')->count();

        $stats = [
            'monthly_revenue' => 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'),
            'revenue_trend' => '+0%', // Can be calculated based on last month
            'total_users' => $totalUsers,
            'users_trend' => '+0',
            'successful_orders' => $successfulOrders,
            'orders_trend' => '+0%',
            'complaint_tickets' => $complaintTickets,
            'tickets_trend' => '-0',
        ];

        $recentTransactionsData = \App\Models\Transaction::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_transactions = [];
        foreach ($recentTransactionsData as $trx) {
            $statusMap = [
                'pending' => 'Menunggu',
                'success' => 'Sukses',
                'failed' => 'Gagal'
            ];
            
            $recent_transactions[] = [
                'user' => $trx->user->name,
                'product' => $trx->product->name,
                'total' => 'Rp ' . number_format($trx->total_amount, 0, ',', '.'),
                'payment' => $trx->payment_method,
                'status' => $statusMap[$trx->status] ?? $trx->status,
            ];
        }

        // We also need chart data for 'Statistik Pendapatan'
        // Grouping revenue by month for the last 6 months
        $chartData = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = \App\Models\Transaction::where('status', 'success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
            
            $chartLabels[] = $month->translatedFormat('M Y');
            // convert to millions for the chart (optional, but keeps numbers small)
            $chartData[] = round($revenue / 1000000, 2); 
        }

        return view('admin.dashboard', compact('admin', 'stats', 'recent_transactions', 'chartLabels', 'chartData'));
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
