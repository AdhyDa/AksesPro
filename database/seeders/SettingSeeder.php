<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('system_name', 'AksesPro');
        Setting::set('system_description', 'Akses instan layanan streaming premium, musik, desain, dan produktivitas terbaik.');
        Setting::set('logo', 'logo.png');
        
        Setting::set('midtrans_merchant_id', 'G123456789');
        Setting::set('midtrans_client_key', 'SB-Mid-client-dummyClientKey123');
        Setting::set('midtrans_server_key', 'SB-Mid-server-dummyServerKey456');
        Setting::set('midtrans_is_production', 'false');
        Setting::set('midtrans_is_sanitized', 'true');
        Setting::set('midtrans_is_3ds', 'true');

        Setting::set('smtp_host', 'smtp.mailtrap.io');
        Setting::set('smtp_port', '2525');
        Setting::set('smtp_username', 'dummy_user');
        Setting::set('smtp_password', 'dummy_pass');
        Setting::set('smtp_encryption', 'tls');
        Setting::set('smtp_from_address', 'noreply@aksespro.com');
        Setting::set('smtp_from_name', 'AksesPro Support');
    }
}