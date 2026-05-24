<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Setting;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);
});

test('admin can access dashboard', function () {
    $response = $this->actingAs($this->admin)->get('/admin/dashboard');
    $response->assertOk();
});

test('admin can access product page', function () {
    $response = $this->actingAs($this->admin)->get('/admin/produk');
    $response->assertOk();
});

test('admin can store and update product', function () {
    $response = $this->actingAs($this->admin)->post('/admin/produk', [
        'name' => 'Premium Netflix',
        'category' => 'Streaming',
        'original_price' => 50000,
        'aksespro_price' => 45000,
        'duration_days' => 30,
        'stock' => 10,
        'max_stock' => 100,
        'description' => 'Netflix 4K Streaming Account',
    ]);
    $response->assertRedirect();

    $product = Product::where('name', 'Premium Netflix')->first();
    expect($product)->not->toBeNull();
    expect($product->category)->toBe('Streaming');

    // Update
    $updateResponse = $this->actingAs($this->admin)->post("/admin/produk/{$product->id}", [
        'name' => 'Premium Netflix Updated',
        'category' => 'Streaming',
        'original_price' => 55000,
        'aksespro_price' => 48000,
        'duration_days' => 30,
        'stock' => 15,
        'max_stock' => 100,
        'description' => 'Netflix 4K Streaming Account Updated',
    ]);
    $updateResponse->assertRedirect();

    $product->refresh();
    expect($product->name)->toBe('Premium Netflix Updated');
});

test('admin can toggle product active status', function () {
    $product = Product::create([
        'name' => 'Premium Spotify',
        'category' => 'Streaming',
        'original_price' => 30000,
        'aksespro_price' => 25000,
        'duration_days' => 30,
        'stock' => 10,
        'max_stock' => 100,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->post("/admin/produk/{$product->id}/toggle-active");
    $response->assertJson(['success' => true, 'is_active' => false]);

    $product->refresh();
    expect($product->is_active)->toBeFalse();
});

test('admin can delete product', function () {
    $product = Product::create([
        'name' => 'Premium Canva',
        'category' => 'Desain',
        'original_price' => 20000,
        'aksespro_price' => 15000,
        'duration_days' => 30,
        'stock' => 10,
        'max_stock' => 100,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->delete("/admin/produk/{$product->id}");
    $response->assertRedirect();

    expect(Product::find($product->id))->toBeNull();
});

test('admin can access transaction page and export CSV', function () {
    $response = $this->actingAs($this->admin)->get('/admin/transaksi');
    $response->assertOk();

    $exportResponse = $this->actingAs($this->admin)->get('/admin/transaksi/export');
    $exportResponse->assertStatus(200);
    $exportResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
});

test('admin can access users list and toggle status', function () {
    $member = User::factory()->create([
        'role' => 'member',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->get('/admin/pengguna');
    $response->assertOk();

    $toggleResponse = $this->actingAs($this->admin)->post("/admin/pengguna/{$member->id}/toggle-status");
    $toggleResponse->assertJson(['success' => true, 'is_active' => false]);

    $member->refresh();
    expect($member->is_active)->toBeFalse();
});

test('admin can access reports and export PDF', function () {
    $response = $this->actingAs($this->admin)->get('/admin/laporan');
    $response->assertOk();

    $pdfResponse = $this->actingAs($this->admin)->get('/admin/laporan/pdf');
    $pdfResponse->assertStatus(200);
    $pdfResponse->assertHeader('Content-Type', 'application/pdf');
});

test('admin can access settings and save configs', function () {
    $response = $this->actingAs($this->admin)->get('/admin/pengaturan');
    $response->assertOk();

    // General settings
    $umumResponse = $this->actingAs($this->admin)->post('/admin/pengaturan/umum', [
        'system_name' => 'AksesPro Brand New',
        'system_description' => 'Instantly vending digital stuff',
    ]);
    $umumResponse->assertRedirect();
    expect(Setting::get('system_name'))->toBe('AksesPro Brand New');

    // Payment settings
    $pembayaranResponse = $this->actingAs($this->admin)->post('/admin/pengaturan/pembayaran', [
        'midtrans_environment' => 'sandbox',
        'midtrans_merchant_id' => 'M123',
        'midtrans_client_key' => 'C123',
        'midtrans_server_key' => 'S123',
    ]);
    $pembayaranResponse->assertRedirect();
    expect(Setting::get('midtrans_merchant_id'))->toBe('M123');

    // Email settings
    $emailResponse = $this->actingAs($this->admin)->post('/admin/pengaturan/email', [
        'mail_mailer' => 'smtp',
        'mail_host' => 'smtp.test.com',
        'mail_port' => '587',
        'mail_encryption' => 'tls',
        'mail_username' => 'test@test.com',
        'mail_password' => 'secret_pass',
    ]);
    $emailResponse->assertRedirect();
    expect(Setting::get('mail_host'))->toBe('smtp.test.com');
});
