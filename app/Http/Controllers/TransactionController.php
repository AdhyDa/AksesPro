<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function processPayment(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        // 1. Create a pending transaction record
        $invoiceId = 'AP-ORDER-'.strtoupper(Str::random(6)).'-'.time();
        $transaction = Transaction::create([
            'invoice_id' => $invoiceId,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'total_amount' => $product->aksespro_price,
            'payment_method' => 'Midtrans Snap',
            'status' => 'pending',
            'snap_token' => null,
        ]);

        try {
            // 2. Configure Midtrans Snap
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = filter_var(config('midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // 3. Prepare parameters for Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $invoiceId,
                    'gross_amount' => (int) $product->aksespro_price,
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => (int) $product->aksespro_price,
                        'quantity' => 1,
                        'name' => Str::limit($product->name, 50),
                    ],
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            // 4. Request snap token from Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 5. Save Snap Token to transaction
            $transaction->update([
                'snap_token' => $snapToken,
            ]);

            // Pass user role variables matching standard layout component
            $admin = auth()->user() && auth()->user()->role === 'admin';
            $userName = $user->name;
            $userRole = $user->role === 'admin' ? 'Administrator' : 'Member';

            return view('user.checkout', compact('snapToken', 'transaction', 'product', 'userName', 'userRole'));

        } catch (\Exception $e) {
            // If anything goes wrong, delete/cancel the transaction and show error
            $transaction->delete();

            return redirect()->route('user.katalog.detail', $product->slug)
                ->with('error', 'Gagal memicu pembayaran Midtrans: '.$e->getMessage());
        }
    }
}
