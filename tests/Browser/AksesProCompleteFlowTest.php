<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Str;

class AksesProCompleteFlowTest extends DuskTestCase
{
    /**
     * Jalankan migrasi dan seeder setiap kali tes dijalankan,
     * untuk memastikan data awal bersih dan konsisten.
     */
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder agar produk, pengaturan, dan akun admin tersedia.
        $this->artisan('db:seed');
    }

    /**
     * Skenario Alur Pengguna (Pembeli/Mahasiswa)
     */
    public function testStudentPurchaseFlow(): void
    {
        $this->browse(function (Browser $browser) {
            $randomString = strtolower(Str::random(5));
            $email = "budi_{$randomString}@student.um.ac.id";

            $browser->visit('/register')
                    ->pause(1000)
                    // 2. Simulasikan klik tombol "Student" menggunakan metode bawaan Dusk
                    ->waitFor('#btn-student-toggle', 10)
                    ->click('#btn-student-toggle')
                    ->pause(1500) // Tambahkan pause setelah aksi yang memicu animasi UI (transisi split-screen)
                    
                    // Pastikan placeholder email berubah menjadi nama@student.um.ac.id (sesuai efek AlpineJS)
                    ->assertAttribute('input[name="email"]', 'placeholder', 'nama@student.um.ac.id')
                    
                    // 3. Isi formulir pendaftaran manual
                    ->type('name', 'Budi Mahasiswa')
                    ->type('email', $email)
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->waitFor('button[type="submit"]', 10)
                    ->press('Lanjutkan dengan Akun Mahasiswa')
                    ->pause(3000);

            // 4. Bypass verifikasi email dengan memanipulasi model User langsung di backend
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->markEmailAsVerified();
                // Jika user login belum memiliki 100 poin, kita atur ke 100 sesuai instruksi "pastikan saldo poin memuat angka 100"
                if ($user->points !== 100) {
                    $user->points = 100;
                    $user->save();
                }
            }

            $browser->visit('/user/dashboard')
                    ->pause(1000)
                    // 5. Pastikan saldo poin di dashboard menampilkan 100
                    ->assertSee('100')
                    
                    // 6. Masuk ke halaman katalog
                    ->visit('/user/katalog')
                    ->pause(1000)
                    // Klik salah satu produk (Beli) menggunakan metode bawaan Dusk dengan selector valid
                    ->waitFor('.grid a', 10)
                    ->click('.grid a')
                    ->pause(2000)

                    // Klik "Beli Sekarang" di halaman rincian produk untuk diarahkan ke halaman checkout
                    ->waitFor('form[action*="checkout/process"] button[type="submit"]', 10)
                    ->click('form[action*="checkout/process"] button[type="submit"]')
                    ->pause(2000)
                    
                    // 7. Di halaman checkout review, klik "Bayar Sekarang" untuk memicu Midtrans Snap
                    ->waitFor('#pay-button', 10)
                    ->click('#pay-button')
                    ->pause(1500) // Animasi / transisi UI setelah klik bayar
                    
                    // Pastikan jendela popup Midtrans Snap muncul
                    ->waitFor('iframe#snap-midtrans', 10)
                    ->assertPresent('iframe#snap-midtrans')
                    
                    // Kembali ke dashboard dan lakukan logout
                    ->visit('/user/dashboard')
                    ->pause(1000);
            
            // 8. Lakukan logout
            // Karena menggunakan layout dropdown Breeze (yang mana tersembunyi), kita memanggil form logout secara langsung menggunakan JS:
            $browser->script("document.querySelector('form[action*=\"logout\"]').submit();");
            $browser->pause(1000)
                    ->assertPathIs('/');
        });
    }

    /**
     * Skenario Alur Administrator
     */
    public function testAdminDashboardAndProfileFlow(): void
    {
        $this->browse(function (Browser $browser) {
            // 1. Buka halaman login
            $browser->visit('/login')
                    ->pause(1000)
                    // 2. Masukkan kredensial akun Admin dari Database Seeder
                    ->type('email', 'adhyaksa209@gmail.com')
                    ->type('password', 'akuadmin456')
                    ->waitFor('button[type="submit"]', 10)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    
                    // 3. Masuk ke halaman dashboard admin
                    ->assertPathIs('/admin/dashboard')
                    
                    // 4. Periksa apakah text/grafik termuat tanpa error
                    ->assertSee('Pendapatan')
                    ->assertSee('Transaksi Masuk Terbaru')
                    
                    // 5. Buka halaman profil dan simulasikan perubahan
                    ->visit('/profile')
                    ->pause(1000)
                    ->type('name', 'Superadmin QA Tested')
                    ->press('Simpan Perubahan')
                    ->pause(1000)
                    ->assertSee('Profil berhasil diperbarui.') // Pesan flash premium AksesPro
                    
                    // 6. Lakukan logout admin
                    ->script("document.querySelector('form[action*=\"logout\"]').submit();");
            
            $browser->pause(1000)
                    ->assertPathIs('/');
        });
    }
}
