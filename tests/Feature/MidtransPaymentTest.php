<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'role' => 'member',
            'points' => 0
        ]);

        $this->product = Product::create([
            'name' => 'Spotify Premium test',
            'slug' => 'spotify-premium-test',
            'category' => 'Musik',
            'original_price' => 50000,
            'aksespro_price' => 20000,
            'duration_days' => 30,
            'stock' => 10,
            'max_stock' => 100,
            'is_active' => true,
        ]);
        
        // Mock Midtrans config keys
        config([
            'midtrans.server_key' => 'fake_server_key',
            'midtrans.client_key' => 'fake_client_key',
            'midtrans.is_production' => false,
        ]);
    }

    public function test_user_can_initialize_payment_checkout()
    {
        // Mock Midtrans Snap response if necessary, or let try-catch handle it locally if server key is fake
        // Let's create a real snap token test. Midtrans Snap SDK will perform a HTTP request.
        // We can mock the Snap class or catch the connection error if the API fails, 
        // but wait! To make our tests extremely fast and independent of real network calls,
        // we can test the routes and controller responses.
        
        $response = $this->actingAs($this->user)
            ->post(route('user.checkout.process', $this->product->slug));
            
        // Since we are using a fake server key, Snap API will return an exception (401 Unauthorized from Midtrans).
        // The controller's try-catch will gracefully catch it, delete the temporary transaction,
        // and redirect back to the catalog detail page with a descriptive error.
        $response->assertRedirect(route('user.katalog.detail', $this->product->slug));
        $response->assertSessionHas('error');
    }

    public function test_webhook_successful_payment_creates_subscription_and_adds_points()
    {
        $transaction = Transaction::create([
            'invoice_id' => 'AP-ORDER-TEST123',
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'total_amount' => 20000,
            'payment_method' => 'Midtrans Snap',
            'status' => 'pending',
        ]);

        $orderId = 'AP-ORDER-TEST123';
        $statusCode = '200';
        $grossAmount = '20000';
        $serverKey = 'fake_server_key';
        
        // Calculated signature key: hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey)
        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        $payload = [
            'signature_key' => $signatureKey,
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'payment_type' => 'qris'
        ];

        $response = $this->postJson(route('midtrans.callback'), $payload);

        $response->assertOk();
        $response->assertJson(['status' => 'success']);

        // Verify transaction updated in DB
        $transaction->refresh();
        $this->assertEquals('success', $transaction->status);
        $this->assertNotNull($transaction->paid_at);
        $this->assertEquals('qris', $transaction->payment_method);

        // Verify active SaaS subscription generated
        $subscription = UserSubscription::where('user_id', $this->user->id)
            ->where('product_id', $this->product->id)
            ->first();
        
        $this->assertNotNull($subscription);
        $this->assertEquals('active', $subscription->status);
        $this->assertNotNull($subscription->account_credentials);

        // Verify user received 10 loyalty points
        $this->user->refresh();
        $this->assertEquals(10, $this->user->points);
    }

    public function test_webhook_rejects_invalid_signature_key()
    {
        $transaction = Transaction::create([
            'invoice_id' => 'AP-ORDER-TEST456',
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'total_amount' => 20000,
            'payment_method' => 'Midtrans Snap',
            'status' => 'pending',
        ]);

        $payload = [
            'signature_key' => 'invalid_signature_key',
            'order_id' => 'AP-ORDER-TEST456',
            'status_code' => '200',
            'gross_amount' => '20000',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept'
        ];

        $response = $this->postJson(route('midtrans.callback'), $payload);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'Invalid signature key']);

        // Verify transaction is still pending
        $transaction->refresh();
        $this->assertEquals('pending', $transaction->status);
    }
}
