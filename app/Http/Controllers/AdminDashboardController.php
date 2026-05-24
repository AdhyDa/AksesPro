<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = [
            'name' => $adminModel ? $adminModel->name : 'Superadmin',
        ];

        $periode = $request->get('periode', 'bulan-ini');

        // Ranges setup
        if ($periode === 'bulan-lalu') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
            $prevStartDate = now()->subMonths(2)->startOfMonth();
            $prevEndDate = now()->subMonths(2)->endOfMonth();
        } elseif ($periode === 'tahun-ini') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            $prevStartDate = now()->subYear()->startOfYear();
            $prevEndDate = now()->subYear()->endOfYear();
        } else { // bulan-ini
            $periode = 'bulan-ini';
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
            $prevStartDate = now()->subMonth()->startOfMonth();
            $prevEndDate = now()->subMonth()->endOfMonth();
        }

        // 1. Revenue
        $revenue = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $prevRevenue = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum('total_amount');

        if ($prevRevenue > 0) {
            $revTrendVal = round((($revenue - $prevRevenue) / $prevRevenue) * 100);
            $revenue_trend = ($revTrendVal >= 0 ? '+' : '') . $revTrendVal . '%';
        } else {
            $revenue_trend = $revenue > 0 ? '+100%' : '+0%';
        }

        // 2. Total Users
        $totalUsers = User::where('role', 'member')
            ->where('created_at', '<=', $endDate)
            ->count();

        $newUsersThisPeriod = User::where('role', 'member')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $users_trend = '+' . $newUsersThisPeriod;

        // 3. Successful Orders
        $successfulOrders = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $prevSuccessfulOrders = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->count();

        if ($prevSuccessfulOrders > 0) {
            $ordersTrendVal = round((($successfulOrders - $prevSuccessfulOrders) / $prevSuccessfulOrders) * 100);
            $orders_trend = ($ordersTrendVal >= 0 ? '+' : '') . $ordersTrendVal . '%';
        } else {
            $orders_trend = $successfulOrders > 0 ? '+100%' : '+0%';
        }

        // 4. Complaint Tickets
        $complaintTickets = Ticket::where('status', 'open')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $prevComplaintTickets = Ticket::where('status', 'open')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->count();

        $ticketDiff = $complaintTickets - $prevComplaintTickets;
        $tickets_trend = ($ticketDiff >= 0 ? '+' : '') . $ticketDiff;

        $stats = [
            'monthly_revenue' => 'Rp ' . number_format($revenue, 0, ',', '.'),
            'revenue_trend' => $revenue_trend,
            'total_users' => $totalUsers,
            'users_trend' => $users_trend,
            'successful_orders' => $successfulOrders,
            'orders_trend' => $orders_trend,
            'complaint_tickets' => $complaintTickets,
            'tickets_trend' => $tickets_trend,
        ];

        // Transaksi terbaru
        $recentTransactionsData = Transaction::with(['user', 'product'])
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
                'user' => $trx->user ? $trx->user->name : 'N/A',
                'product' => $trx->product ? $trx->product->name : 'N/A',
                'total' => 'Rp ' . number_format($trx->total_amount, 0, ',', '.'),
                'payment' => $trx->payment_method,
                'status' => $statusMap[$trx->status] ?? $trx->status,
            ];
        }

        // Chart Data - Dynamic based on period
        $chartData = [];
        $chartLabels = [];
        
        if ($periode === 'tahun-ini') {
            // Monthly for the current year (Jan - Dec)
            for ($m = 1; $m <= 12; $m++) {
                $monthObj = now()->month($m);
                // Skip future months in current year to keep graph clean
                if ($monthObj->isFuture() && $monthObj->year === now()->year) {
                    continue;
                }
                $monthRevenue = Transaction::where('status', 'success')
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', $m)
                    ->sum('total_amount');
                
                $chartLabels[] = $monthObj->translatedFormat('M');
                $chartData[] = (int)$monthRevenue;
            }
        } elseif ($periode === 'bulan-lalu') {
            // Daily for last month
            $lastMonth = now()->subMonth();
            $daysInMonth = $lastMonth->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dayRevenue = Transaction::where('status', 'success')
                    ->whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->whereDay('created_at', $d)
                    ->sum('total_amount');
                
                $chartLabels[] = str_pad($d, 2, '0', STR_PAD_LEFT);
                $chartData[] = (int)$dayRevenue;
            }
        } else { // bulan-ini
            // Daily for this month
            $daysInMonth = now()->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dayRevenue = Transaction::where('status', 'success')
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->whereDay('created_at', $d)
                    ->sum('total_amount');
                
                $chartLabels[] = str_pad($d, 2, '0', STR_PAD_LEFT);
                $chartData[] = (int)$dayRevenue;
            }
        }

        // Kategori Produk Terlaris (Doughnut Chart) filtered by period
        $categoriesDataQuery = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->selectRaw('products.category, count(*) as total')
            ->groupBy('products.category')
            ->get();

        $categoryLabels = [];
        $categoryData = [];
        foreach ($categoriesDataQuery as $catRow) {
            $categoryLabels[] = $catRow->category;
            $categoryData[] = $catRow->total;
        }

        if (empty($categoryLabels)) {
            $categoryLabels = ['Streaming', 'Musik', 'Desain', 'Produktivitas'];
            $categoryData = [0, 0, 0, 0];
        }

        // Pengguna baru terdaftar
        $recentUsersData = User::where('role', 'member')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentUsers = [];
        foreach ($recentUsersData as $usr) {
            $recentUsers[] = [
                'name' => $usr->name,
                'email' => $usr->email,
                'points' => $usr->points,
                'date' => $usr->created_at->format('d M Y'),
                'status' => 'Aktif',
            ];
        }

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'stats' => $stats,
                'recent_transactions' => $recent_transactions,
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'categoryLabels' => $categoryLabels,
                'categoryData' => $categoryData,
                'recentUsers' => $recentUsers,
                'periode' => $periode,
            ]);
        }

        return view('admin.dashboard', compact(
            'admin', 
            'stats', 
            'recent_transactions', 
            'chartLabels', 
            'chartData', 
            'categoryLabels', 
            'categoryData',
            'recentUsers',
            'periode'
        ));
    }

    public function produk()
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = ['name' => $adminModel ? $adminModel->name : 'Superadmin'];

        $products = Product::all();
        return view('admin.produk', compact('admin', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'aksespro_price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'original_price' => $validated['original_price'],
            'aksespro_price' => $validated['aksespro_price'],
            'duration_days' => $validated['duration_days'],
            'stock' => $validated['stock'],
            'max_stock' => $validated['max_stock'],
            'description' => $validated['description'] ?? '',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'aksespro_price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleProductActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active
        ]);
    }

    public function transaksi(Request $request)
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = ['name' => $adminModel ? $adminModel->name : 'Superadmin'];

        $query = Transaction::with(['user', 'product']);

        $query->orderBy('created_at', 'desc');

        $transactionsData = $query->get();

        $transactions = [];
        $statusMap = [
            'pending' => 'Menunggu',
            'success' => 'Sukses',
            'failed' => 'Gagal'
        ];

        foreach ($transactionsData as $trx) {
            $transactions[] = [
                'id' => $trx->invoice_id,
                'date' => $trx->created_at->format('Y-m-d H:i'),
                'user' => $trx->user ? $trx->user->name : 'N/A',
                'product' => $trx->product ? $trx->product->name : 'N/A',
                'total' => 'Rp ' . number_format($trx->total_amount, 0, ',', '.'),
                'method' => $trx->payment_method,
                'status' => $statusMap[$trx->status] ?? $trx->status,
            ];
        }

        return view('admin.transaksi', compact('admin', 'transactions'));
    }

    public function verifyTransaction($id)
    {
        $trx = Transaction::where('invoice_id', $id)->firstOrFail();
        if ($trx->status === 'pending') {
            $trx->status = 'success';
            $trx->paid_at = now();
            $trx->save();

            $user = $trx->user;
            if ($user) {
                $user->points = ($user->points ?? 0) + round($trx->total_amount / 10);
                $user->save();
            }

            \App\Models\UserSubscription::create([
                'user_id' => $trx->user_id,
                'product_id' => $trx->product_id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($trx->product ? $trx->product->duration_days : 30),
                'status' => 'active',
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function rejectTransaction($id)
    {
        $trx = Transaction::where('invoice_id', $id)->firstOrFail();
        if ($trx->status === 'pending') {
            $trx->status = 'failed';
            $trx->save();
        }

        return response()->json(['success' => true]);
    }

    public function exportTransactionsCsv(Request $request)
    {
        $query = Transaction::with(['user', 'product'])->orderBy('created_at', 'desc');
        $transactions = $query->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=transactions_export_" . date('Ymd_His') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($transactions) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, ['ID Transaksi', 'Waktu', 'Pengguna', 'Email', 'Produk', 'Total', 'Metode Bayar', 'Status']);

            $statusMap = [
                'pending' => 'Menunggu',
                'success' => 'Sukses',
                'failed' => 'Gagal'
            ];

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->invoice_id,
                    $trx->created_at->format('Y-m-d H:i'),
                    $trx->user ? $trx->user->name : 'N/A',
                    $trx->user ? $trx->user->email : 'N/A',
                    $trx->product ? $trx->product->name : 'N/A',
                    'Rp ' . number_format($trx->total_amount, 0, ',', '.'),
                    $trx->payment_method,
                    $statusMap[$trx->status] ?? $trx->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function pengguna(Request $request)
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = ['name' => $adminModel ? $adminModel->name : 'Superadmin'];

        $usersData = User::where('role', 'member')->get();

        $users = [];
        foreach ($usersData as $u) {
            $users[] = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => 'Member',
                'points' => $u->points ?? 0,
                'join_date' => $u->created_at->format('Y-m-d'),
                'status' => $u->is_active ? 'Aktif' : 'Suspended',
            ];
        }

        return view('admin.pengguna', compact('admin', 'users'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active
        ]);
    }

    public function laporan(Request $request)
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = ['name' => $adminModel ? $adminModel->name : 'Superadmin'];

        $periode = $request->get('periode', 'bulan-ini');

        // Ranges setup
        if ($periode === 'bulan-lalu') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } elseif ($periode === 'tahun-ini') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        } else {
            $periode = 'bulan-ini';
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        }

        $successTrxs = Transaction::with('product')
            ->where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $grossRevenue = $successTrxs->sum('total_amount');
        $netProfit = $successTrxs->sum(function($trx) {
            $originalPrice = $trx->product ? $trx->product->original_price : ($trx->total_amount * 0.7);
            return $trx->total_amount - $originalPrice;
        });

        $failedTransactions = Transaction::where('status', 'failed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Group by product category
        $categoryData = [];
        foreach ($successTrxs as $trx) {
            if ($trx->product) {
                $cat = $trx->product->category;
                $categoryData[$cat] = ($categoryData[$cat] ?? 0) + $trx->total_amount;
            }
        }
        $categoryLabels = array_keys($categoryData);
        $categoryValues = array_values($categoryData);

        // Group by payment method
        $paymentData = [];
        foreach ($successTrxs as $trx) {
            $method = $trx->payment_method ?: 'Transfer';
            $paymentData[$method] = ($paymentData[$method] ?? 0) + 1;
        }
        $paymentLabels = array_keys($paymentData);
        $paymentValues = array_values($paymentData);

        return view('admin.laporan', compact(
            'admin', 'grossRevenue', 'netProfit', 'failedTransactions', 
            'categoryLabels', 'categoryValues', 'paymentLabels', 'paymentValues', 'periode'
        ));
    }

    public function exportLaporanPdf(Request $request)
    {
        $periode = $request->get('periode', 'bulan-ini');

        // Ranges setup
        if ($periode === 'bulan-lalu') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
            $periodeText = 'Bulan Lalu (' . $startDate->translatedFormat('F Y') . ')';
        } elseif ($periode === 'tahun-ini') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            $periodeText = 'Tahun Ini (' . $startDate->translatedFormat('Y') . ')';
        } else {
            $periode = 'bulan-ini';
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
            $periodeText = 'Bulan Ini (' . $startDate->translatedFormat('F Y') . ')';
        }

        $successTrxs = Transaction::with(['user', 'product'])
            ->where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $grossRevenue = $successTrxs->sum('total_amount');
        $netProfit = $successTrxs->sum(function($trx) {
            $originalPrice = $trx->product ? $trx->product->original_price : ($trx->total_amount * 0.7);
            return $trx->total_amount - $originalPrice;
        });

        $failedTransactions = Transaction::where('status', 'failed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();

        $data = [
            'periodeText' => $periodeText,
            'grossRevenue' => $grossRevenue,
            'netProfit' => $netProfit,
            'failedTransactions' => $failedTransactions,
            'totalTransactions' => $totalTransactions,
            'transactions' => $successTrxs,
        ];

        $pdf = Pdf::loadView('admin.laporan_pdf', $data);
        return $pdf->download('Laporan_AksesPro_' . str_replace(' ', '_', $periodeText) . '.pdf');
    }

    public function pengaturan()
    {
        $adminModel = \Illuminate\Support\Facades\Auth::user() ?? User::where('role', 'admin')->first();
        $admin = ['name' => $adminModel ? $adminModel->name : 'Superadmin'];

        return view('admin.pengaturan', compact('admin'));
    }

    public function saveSettingsUmum(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'required|string|max:255',
            'system_description' => 'required|string|max:1000',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        Setting::set('system_name', $validated['system_name']);
        Setting::set('system_description', $validated['system_description']);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file->move(public_path('uploads'), 'logo.png');
            Setting::set('logo', 'logo.png');
        }

        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }

    public function saveSettingsPembayaran(Request $request)
    {
        $validated = $request->validate([
            'midtrans_environment' => 'required|string|in:sandbox,production',
            'midtrans_merchant_id' => 'required|string|max:255',
            'midtrans_client_key' => 'required|string|max:255',
            'midtrans_server_key' => 'required|string|max:255',
        ]);

        Setting::set('midtrans_environment', $validated['midtrans_environment']);
        Setting::set('midtrans_merchant_id', $validated['midtrans_merchant_id']);
        Setting::set('midtrans_client_key', $validated['midtrans_client_key']);
        Setting::set('midtrans_server_key', $validated['midtrans_server_key']);

        return redirect()->back()->with('success', 'Kredensial payment gateway berhasil disimpan.');
    }

    public function saveSettingsEmail(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|string|max:255',
            'mail_encryption' => 'required|string|in:tls,ssl',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
        ]);

        Setting::set('mail_mailer', $validated['mail_mailer']);
        Setting::set('mail_host', $validated['mail_host']);
        Setting::set('mail_port', $validated['mail_port']);
        Setting::set('mail_encryption', $validated['mail_encryption']);
        Setting::set('mail_username', $validated['mail_username']);
        Setting::set('mail_password', $validated['mail_password']);

        return redirect()->back()->with('success', 'Konfigurasi SMTP email berhasil disimpan.');
    }
}