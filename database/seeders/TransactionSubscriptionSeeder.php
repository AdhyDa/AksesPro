<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $users = \App\Models\User::where('role', 'member')->get();
        $products = \App\Models\Product::all();

        // Generate 60 transactions over the last 6 months
        for ($i = 0; $i < 60; $i++) {
            $user = $users->random();
            $product = $products->random();
            $status = $faker->randomElement(['pending', 'success', 'success', 'success', 'failed']); // 60% success rate
            $createdAt = $faker->dateTimeBetween('-6 months', 'now');
            
            $transaction = \App\Models\Transaction::create([
                'invoice_id' => 'INV-' . strtoupper($faker->bothify('???###')) . '-' . time(),
                'user_id' => $user->id,
                'product_id' => $product->id,
                'total_amount' => $product->aksespro_price,
                'payment_method' => $faker->randomElement(['QRIS', 'Gopay', 'Transfer BCA', 'Mandiri Virtual Account']),
                'status' => $status,
                'paid_at' => $status == 'success' ? $createdAt : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            if ($status == 'success') {
                // Add 10% points
                $pointsEarned = $product->aksespro_price * 0.10;
                $user->increment('points', $pointsEarned);

                // Create subscription
                $startDate = \Carbon\Carbon::parse($createdAt);
                $endDate = $startDate->copy()->addDays($product->duration_days);
                
                // Determine if active or expired based on end_date
                $subStatus = $endDate->isPast() ? 'expired' : 'active';

                \App\Models\UserSubscription::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'account_credentials' => [
                        'email' => $faker->userName . '@' . $faker->freeEmailDomain,
                        'password' => $faker->password,
                        'profile' => 'Profile ' . $faker->numberBetween(1, 4)
                    ],
                    'status' => $subStatus,
                    'auto_renew' => $faker->boolean(30), // 30% chance auto renew
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Create some random tickets
            if ($faker->boolean(15)) { // 15% chance to create a ticket
                \App\Models\Ticket::create([
                    'user_id' => $user->id,
                    'transaction_id' => $transaction->id,
                    'subject' => $faker->sentence(4),
                    'message' => $faker->paragraph,
                    'status' => $faker->randomElement(['open', 'resolved', 'closed']),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
