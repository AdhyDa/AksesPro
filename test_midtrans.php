<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = config('midtrans.server_key');
Config::$isProduction = false;

echo "USING SERVER KEY: " . Config::$serverKey . "\n";

try {
    $token = Snap::getSnapToken([
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000
        ]
    ]);
    echo "SUCCESS TOKEN: " . $token . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TRACE:\n" . $e->getTraceAsString() . "\n";
}
