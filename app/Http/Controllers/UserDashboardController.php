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
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $activeSubsData = \App\Models\UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->get();

        $subscriptions = [];
        foreach ($activeSubsData as $sub) {
            $subscriptions[] = [
                'name' => $sub->product->name,
                'package' => $sub->product->duration_days . ' Hari',
                'start_date' => $sub->start_date->format('Y-m-d'),
                'end_date' => $sub->end_date->format('Y-m-d'),
                'status' => ucfirst($sub->status),
                'auto_renew' => $sub->auto_renew,
            ];
        }

        return view('user.langganan', compact('user', 'subscriptions'));
    }

    public function transaksi()
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $transactionsData = \App\Models\Transaction::with('product')
            ->where('user_id', $userModel->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $transactions = [];
        foreach ($transactionsData as $trx) {
            $statusMap = [
                'pending' => 'Menunggu',
                'success' => 'Berhasil',
                'failed' => 'Gagal'
            ];
            
            $transactions[] = [
                'id' => $trx->invoice_id,
                'date' => $trx->created_at->format('Y-m-d H:i'),
                'product' => $trx->product->name,
                'amount' => $trx->total_amount,
                'method' => $trx->payment_method,
                'status' => $statusMap[$trx->status] ?? $trx->status,
            ];
        }

        return view('user.transaksi', compact('user', 'transactions'));
    }

    public function poin()
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $products = \App\Models\Product::where('is_active', true)->get();

        return view('user.poin', compact('user', 'products'));
    }

    public function showPoinProduct($id)
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $product = \App\Models\Product::findOrFail($id);

        return view('user.poin-detail', compact('user', 'product'));
    }

    public function redeemPoin(Request $request, $id)
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $product = \App\Models\Product::findOrFail($id);

        if ($userModel->points < $product->aksespro_price) {
            return redirect()->back()->with('error', 'Poin tidak mencukupi untuk menukar produk ini.');
        }

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis.');
        }

        // Deduct points
        $userModel->points -= $product->aksespro_price;
        $userModel->save();

        // Reduce stock
        $product->stock -= 1;
        $product->save();

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'invoice_id' => 'INV-POIN-' . now()->format('Ymd') . '-' . rand(100, 999),
            'user_id' => $userModel->id,
            'product_id' => $product->id,
            'total_amount' => $product->aksespro_price, // the price in points
            'payment_method' => 'Tukar Poin',
            'status' => 'success',
        ]);

        // Create subscription
        \App\Models\UserSubscription::create([
            'user_id' => $userModel->id,
            'product_id' => $product->id,
            'transaction_id' => $transaction->id,
            'account_credentials' => [
                'email' => strtolower(str_replace(' ', '', $product->name)) . rand(100,999) . '@aksespro.com',
                'password' => 'AksesPro' . rand(1000,9999)
            ],
            'start_date' => now(),
            'end_date' => now()->addDays($product->duration_days),
            'status' => 'active',
            'auto_renew' => false,
        ]);

        return redirect()->route('user.poin')->with('success', 'Berhasil menukar ' . $product->name . '. Poin Anda telah dipotong.');
    }

    public function bantuan()
    {
        $userModel = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];
        return view('user.bantuan', compact('user'));
    }
}
