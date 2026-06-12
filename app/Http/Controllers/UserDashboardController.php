<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Midtrans\Config;
use Midtrans\Transaction;

class UserDashboardController extends Controller
{
    public function index()
    {
        // For development/demonstration, we fetch the first member user if not authenticated
        $userModel = Auth::user() ?? User::where('role', 'member')->first();

        $this->syncPendingTransactions($userModel);

        $user = [
            'name' => $userModel->fresh()->name,
            'points' => $userModel->fresh()->points,
        ];

        $activeSubscriptions = UserSubscription::where('user_id', $userModel->id)
            ->where('status', 'active')
            ->count();

        $totalTransactions = \App\Models\Transaction::where('user_id', $userModel->id)
            ->where('status', 'success')
            ->count();

        // Calculate Estimated Savings
        $estimatedSavings = 0;
        $userSubs = UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->get();

        foreach ($userSubs as $sub) {
            $estimatedSavings += ($sub->product->original_price - $sub->product->aksespro_price);
        }

        $stats = [
            'active_subscriptions' => $activeSubscriptions,
            'total_transactions' => $totalTransactions,
            'points_collected' => $userModel->fresh()->points,
            'estimated_savings' => 'Rp '.number_format($estimatedSavings, 0, ',', '.'),
        ];

        $activeSubsData = UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->where('status', 'active')
            ->get();

        $subscriptions = [];
        foreach ($activeSubsData as $sub) {
            $subscriptions[] = [
                'name' => $sub->product->name,
                'package' => $sub->product->duration_days.' Hari',
                'end_date' => $sub->end_date->format('Y-m-d'),
                'status' => 'Aktif',
                'product_slug' => $sub->product->slug,
                'logo_path' => $sub->product->logo_path,
            ];
        }

        return Inertia::render('User/Dashboard', compact('user', 'stats', 'subscriptions'));
    }

    public function katalog(Request $request)
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('category', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }

        $productsRaw = $query->get();

        $products = $productsRaw->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'category' => $p->category,
            'description' => $p->description,
            'original_price' => $p->original_price,
            'aksespro_price' => $p->aksespro_price,
            'duration_days' => $p->duration_days,
            'logo_path' => $p->logo_path,
            'stock' => $p->stock,
        ])->values()->toArray();

        return Inertia::render('User/Katalog', [
            'user' => $user,
            'products' => $products,
            'search' => $request->search ?? '',
        ]);
    }

    public function showProduct($slug)
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $productModel = Product::where('slug', $slug)->firstOrFail();

        $product = [
            'id' => $productModel->id,
            'name' => $productModel->name,
            'slug' => $productModel->slug,
            'category' => $productModel->category,
            'description' => $productModel->description,
            'original_price' => $productModel->original_price,
            'aksespro_price' => $productModel->aksespro_price,
            'duration_days' => $productModel->duration_days,
            'logo_path' => $productModel->logo_path,
            'stock' => $productModel->stock,
        ];

        return Inertia::render('User/KatalogDetail', [
            'user' => $user,
            'product' => $product,
        ]);
    }

    public function langganan()
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $activeSubsData = UserSubscription::with('product')
            ->where('user_id', $userModel->id)
            ->get();

        $subscriptions = [];
        foreach ($activeSubsData as $sub) {
            $subscriptions[] = [
                'name' => $sub->product->name,
                'package' => $sub->product->duration_days.' Hari',
                'start_date' => $sub->start_date->format('Y-m-d'),
                'end_date' => $sub->end_date->format('Y-m-d'),
                'status' => ucfirst($sub->status),
                'auto_renew' => $sub->auto_renew,
                'product_slug' => $sub->product->slug,
                'logo_path' => $sub->product->logo_path,
            ];
        }

        return Inertia::render('User/Langganan', [
            'user' => $user,
            'subscriptions' => $subscriptions,
        ]);
    }

    public function transaksi()
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();

        $this->syncPendingTransactions($userModel);

        $user = ['name' => $userModel->fresh()->name, 'points' => $userModel->fresh()->points];

        $transactionsData = \App\Models\Transaction::with('product')
            ->where('user_id', $userModel->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $statusMap = [
            'pending' => 'Menunggu',
            'success' => 'Berhasil',
            'failed' => 'Gagal',
        ];
        $transactions = [];
        foreach ($transactionsData as $trx) {
            $transactions[] = [
                'id' => $trx->invoice_id,
                'date' => $trx->created_at->format('Y-m-d H:i'),
                'product' => $trx->product->name,
                'amount' => $trx->total_amount,
                'method' => $trx->payment_method,
                'status' => $statusMap[$trx->status] ?? $trx->status,
            ];
        }

        return Inertia::render('User/Transaksi', [
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }

    public function downloadInvoice($invoiceId)
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $transaction = \App\Models\Transaction::with(['product', 'user'])
            ->where('invoice_id', $invoiceId)
            ->where('user_id', $userModel->id)
            ->firstOrFail();

        // Invoice still rendered as Blade PDF — no Inertia needed here
        return view('user.invoice', compact('transaction'));
    }

    public function poin()
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $productsRaw = Product::where('is_active', true)->get();

        $products = $productsRaw->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'category' => $p->category,
            'description' => $p->description,
            'aksespro_price' => $p->aksespro_price,
            'duration_days' => $p->duration_days,
            'logo_path' => $p->logo_path,
            'stock' => $p->stock,
        ])->values()->toArray();

        return Inertia::render('User/Poin', [
            'user' => $user,
            'products' => $products,
        ]);
    }

    public function showPoinProduct($slug)
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        $productModel = Product::where('slug', $slug)->firstOrFail();

        $product = [
            'id' => $productModel->id,
            'name' => $productModel->name,
            'slug' => $productModel->slug,
            'category' => $productModel->category,
            'description' => $productModel->description,
            'aksespro_price' => $productModel->aksespro_price,
            'duration_days' => $productModel->duration_days,
            'logo_path' => $productModel->logo_path,
            'stock' => $productModel->stock,
        ];

        return Inertia::render('User/PoinDetail', [
            'user' => $user,
            'product' => $product,
        ]);
    }

    public function redeemPoin(Request $request, $id)
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $product = Product::findOrFail($id);

        if ($userModel->points < $product->aksespro_price) {
            return back()->with('error', 'Poin tidak mencukupi untuk menukar produk ini.');
        }

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        // Deduct points
        $userModel->points -= $product->aksespro_price;
        $userModel->save();

        // Reduce stock
        $product->stock -= 1;
        $product->save();

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'invoice_id' => 'INV-POIN-'.now()->format('Ymd').'-'.rand(100, 999),
            'user_id' => $userModel->id,
            'product_id' => $product->id,
            'total_amount' => $product->aksespro_price,
            'payment_method' => 'Tukar Poin',
            'status' => 'success',
        ]);

        // Create subscription
        UserSubscription::create([
            'user_id' => $userModel->id,
            'product_id' => $product->id,
            'transaction_id' => $transaction->id,
            'account_credentials' => [
                'email' => strtolower(str_replace(' ', '', $product->name)).rand(100, 999).'@aksespro.com',
                'password' => 'AksesPro'.rand(1000, 9999),
            ],
            'start_date' => now(),
            'end_date' => now()->addDays($product->duration_days),
            'status' => 'active',
            'auto_renew' => false,
        ]);

        return redirect()->route('user.poin')->with('success', 'Berhasil menukar '.$product->name.'. Poin Anda telah dipotong.');
    }

    public function bantuan()
    {
        $userModel = Auth::user() ?? User::where('role', 'member')->first();
        $user = ['name' => $userModel->name, 'points' => $userModel->points];

        return Inertia::render('User/Bantuan', [
            'user' => $user,
        ]);
    }

    private function syncPendingTransactions($userModel)
    {
        $pendingTransactions = \App\Models\Transaction::where('user_id', $userModel->id)
            ->where('status', 'pending')
            ->where('payment_method', 'Midtrans Snap')
            ->get();

        if ($pendingTransactions->isEmpty()) {
            return;
        }

        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = filter_var(config('midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            foreach ($pendingTransactions as $trx) {
                try {
                    $statusResponse = Transaction::status($trx->invoice_id);
                } catch (\Exception $e) {
                    continue; // Skip if transaction order ID doesn't exist yet on Midtrans side
                }

                if (isset($statusResponse->transaction_status)) {
                    $txStatus = $statusResponse->transaction_status;
                    $fraudStatus = $statusResponse->fraud_status ?? null;

                    if ($txStatus === 'settlement' || ($txStatus === 'capture' && $fraudStatus === 'accept')) {
                        $trx->update([
                            'status' => 'success',
                            'paid_at' => now(),
                            'payment_method' => $statusResponse->payment_type ?? $trx->payment_method,
                        ]);

                        $product = $trx->product;

                        // Prevent duplicate subscription
                        $existingSub = UserSubscription::where('user_id', $trx->user_id)
                            ->where('product_id', $trx->product_id)
                            ->where('start_date', '>=', now()->startOfDay())
                            ->first();

                        if (! $existingSub) {
                            UserSubscription::create([
                                'user_id' => $trx->user_id,
                                'product_id' => $trx->product_id,
                                'start_date' => now(),
                                'end_date' => now()->addDays($product ? $product->duration_days : 30),
                                'account_credentials' => [
                                    'email' => strtolower(str_replace(' ', '', $userModel->name)).'@aksespro.net',
                                    'password' => 'AP-'.rand(1000, 9999),
                                    'profile' => 'Profile '.rand(1, 4),
                                ],
                                'status' => 'active',
                            ]);

                            $userModel->increment('points', 10);
                        }
                    } elseif (in_array($txStatus, ['deny', 'expire', 'cancel', 'failed'])) {
                        $trx->update([
                            'status' => 'failed',
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to sync pending transaction statuses: '.$e->getMessage());
        }
    }
}
