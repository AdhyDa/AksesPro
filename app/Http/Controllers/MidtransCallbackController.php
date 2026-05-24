<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handleNotification(Request $request)
    {
        Log::info('Midtrans Webhook Received: ', $request->all());

        $signatureKeyReceived = $request->input('signature_key');
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $serverKey = config('midtrans.server_key');

        // 1. Calculate local signature key to verify authenticity
        $signatureKeyComputed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKeyReceived !== $signatureKeyComputed) {
            Log::warning('Midtrans Webhook: Invalid signature key validation failed.');
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // 2. Fetch corresponding transaction
        $transaction = Transaction::where('invoice_id', $orderId)->first();

        if (!$transaction) {
            Log::warning("Midtrans Webhook: Transaction {$orderId} not found in database.");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $paymentType = $request->input('payment_type');

        // 3. Process status transition automatically
        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            // Payment success
            $transaction->update([
                'status' => 'success',
                'paid_at' => now(),
                'payment_method' => $paymentType ?? 'Midtrans',
            ]);

            $product = $transaction->product;
            $user = $transaction->user;

            // Generate active subscription for the customer
            UserSubscription::create([
                'user_id' => $transaction->user_id,
                'product_id' => $transaction->product_id,
                'start_date' => now(),
                'end_date' => now()->addDays($product ? $product->duration_days : 30),
                'account_credentials' => [
                    'email' => strtolower(str_replace(' ', '', $user ? $user->name : 'user')) . '@aksespro.net',
                    'password' => 'AP-' . rand(1000, 9999),
                    'profile' => 'Profile ' . rand(1, 4)
                ],
                'status' => 'active',
            ]);

            // Add 10 points to customer loyalty profile
            if ($user) {
                $user->increment('points', 10);
            }

            Log::info("Midtrans Webhook: Transaction {$orderId} successfully completed and SaaS active.");

        } elseif ($transactionStatus === 'pending') {
            // Keep pending
            $transaction->update([
                'status' => 'pending'
            ]);
            Log::info("Midtrans Webhook: Transaction {$orderId} is currently pending.");

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failed'])) {
            // Payment failed
            $transaction->update([
                'status' => 'failed'
            ]);
            Log::info("Midtrans Webhook: Transaction {$orderId} marked as failed.");
        }

        return response()->json(['status' => 'success']);
    }
}
