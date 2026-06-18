<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

        // Idempotency: skip processing if already successful to prevent duplicate points or subscriptions
        if ($transaction->status === 'success') {
            Log::info("Midtrans Webhook: Transaction {$orderId} is already marked as success. Skipping processing.");
            return response()->json(['status' => 'success', 'message' => 'Transaction already processed']);
        }

        // Data Consistency: Validate gross amount to prevent price tampering/corruption
        if ((int) $transaction->total_amount !== (int) $grossAmount) {
            Log::error("Midtrans Webhook: Gross amount mismatch for order {$orderId}. Expected: {$transaction->total_amount}, Got: {$grossAmount}");
            return response()->json(['message' => 'Gross amount mismatch'], 400);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $paymentType = $request->input('payment_type');

        $product = $transaction->product;
        $user = $transaction->user;

        // Strict Consistency Check before database operations
        if (!$user) {
            Log::error("Midtrans Webhook: Associated user not found for transaction {$orderId}");
            return response()->json(['message' => 'Associated user not found'], 422);
        }

        if (!$product) {
            Log::error("Midtrans Webhook: Associated product not found for transaction {$orderId}");
            return response()->json(['message' => 'Associated product not found'], 422);
        }

        // 3. Process status transition automatically with ACID database transactions
        try {
            DB::beginTransaction();

            if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                // Payment success
                $transaction->update([
                    'status' => 'success',
                    'paid_at' => now(),
                    'payment_method' => $paymentType ?? 'Midtrans',
                ]);

                // Generate active subscription for the customer
                UserSubscription::create([
                    'user_id' => $transaction->user_id,
                    'product_id' => $transaction->product_id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($product->duration_days ?? 30),
                    'account_credentials' => [
                        'email' => strtolower(str_replace(' ', '', $user->name ?? 'user')) . '@aksespro.net',
                        'password' => 'AP-' . rand(1000, 9999),
                        'profile' => 'Profile ' . rand(1, 4)
                    ],
                    'status' => 'active',
                ]);

                // Add 10 points to customer loyalty profile
                $user->increment('points', 10);

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

            DB::commit();
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Midtrans Webhook: Processing failed for transaction {$orderId}. Database rolled back. Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Database transaction failed. Webhook execution rolled back.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

