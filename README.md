# AksesPro - Platform Otomatisasi Lisensi Digital & SaaS Sharing

---

![Laravel](https://img.shields.io/badge/LARAVEL-13.X-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![React](https://img.shields.io/badge/REACT-18.X-61DAFB?style=for-the-badge&logo=react&logoColor=black)
![Inertia.js](https://img.shields.io/badge/INERTIA.JS-1.X-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/TAILWIND_CSS-3.X-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Category](https://img.shields.io/badge/CATEGORY-SAAS%20%26%20E--COMMERCE-689F38?style=for-the-badge)

**AksesPro** adalah platform *digital vending machine* dan *sharing economy* berbasis web yang dirancang untuk mendemokratisasi akses terhadap berbagai perangkat lunak produktivitas dan lisensi digital premium. Proyek ini dikembangkan untuk menghadirkan solusi teknologi yang transparan, otomatis, dan terjangkau bagi kalangan mahasiswa dan pelaku UMKM dengan sistem transaksi berstandar *ACID Properties*.

---
## ✨ Fitur Utama
- ⚡ **Automated Direct Checkout:** Pengguna dapat memilih produk dan langsung menyelesaikan pembayaran secara real-time via Midtrans Snap (QRIS, Virtual Account, E-Wallet).
- 🛡️ **ACID-Compliant Webhook System:** Pemrosesan callback pembayaran otomatis menggunakan database transaction (`DB::transaction`) dengan perlindungan *rollback* otomatis jika terjadi kegagalan sistem, validasi *signature key*, dan pengecekan *gross amount*.
- 🎓 **Student Verification & Loyalty System:** Pendaftaran menggunakan akun/email institusi akademik (`.ac.id`) mendapatkan bonus reward awal, poin transaksi, dan fitur penukaran poin langsung ke layanan premium.
- 📊 **Smart Price & Savings Calculator:** Logika otomatisasi *pricing* cerdas yang menghitung persentase penghematan (*Hemat X%*) dibanding harga resmi non-sharing.
- 🖥️ **Modern SPA Interface:** Dibangun menggunakan perpaduan **Laravel 13**, **Inertia.js**, dan **React 18** untuk navigasi cepat tanpa reload halaman.
- 📈 **Dual Dashboard View:** Antarmuka terisolasi untuk **User** (manajemen langganan aktif, katalog, penukaran poin) dan **Admin** (monitoring metrik pendapatan, data transaksi, dan kontrol katalog).

---
## 🛠️ Tech Stack

| Layer | Teknologi |
| :--- | :--- |
| **Backend Framework** | Laravel 13 (PHP 8.2+) |
| **Frontend Framework** | React 18, Inertia.js |
| **Styling & Icons** | Tailwind CSS, Lucide React / Heroicons |
| **Database & Engine** | MySQL (InnoDB Engine) / PostgreSQL |
| **Payment Gateway** | Midtrans PHP SDK & Snap JS |
| **Automated Testing** | PHPUnit / Pest (Feature Testing), Laravel Dusk (E2E Testing) |

---
## 📂 Struktur Proyek Utama

```text
AksesPro/
├── app/
│   ├── Http/Controllers/
│   │   ├── MidtransCallbackController.php   # Penanganan Webhook & Transaksi ACID
│   │   ├── TransactionController.php        # Pembuatan Snap Token Midtrans
│   │   └── ...
│   └── Models/
│       ├── Product.php                      # Model Produk & Accessor Persentase Diskon
│       ├── Transaction.php
│       └── UserSubscription.php
├── database/
│   ├── migrations/                          # Skema tabel database (InnoDB)
│   └── seeders/                             # Data seeder katalog & import CSV
├── resources/
│   └── js/
│       ├── Components/                      # Komponen modular React
│       ├── Layouts/                         # DashboardLayout (Sidebar & Topbar)
│       └── Pages/                           # Halaman Inertia (User & Admin Pages)
├── routes/
│   ├── api.php                              # Endpoint webhook (midtrans-callback)
│   └── web.php                              # Rute SPA Inertia
└── tests/
    ├── Browser/                             # Laravel Dusk E2E Tests
    └── Feature/                             # Midtrans Payment & ACID Unit Tests
```

## 🚀 Panduan Instalasi & Menjalankan Lokal
### 1. Prasyarat Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB (dengan engine InnoDB)
- Web Server Lokal (Laragon, XAMPP, atau Laravel Herd)
### 2. Kloning Repositori & Instalasi Dependensi
```bash
# Clone repositori
git clone [https://github.com/AdhyDa/AksesPro.git](https://github.com/AdhyDa/AksesPro.git)
cd AksesPro

# Instal dependensi backend
composer install

# Instal dependensi frontend
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```Bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan kredensial database serta Midtrans Sandbox:
```Code snippet
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aksespro_db
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Midtrans Sandbox
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

### 4. Migrasi & Seeding Database
Jalankan migrasi database untuk membangun tabel dan memuat produk awal:
```Bash
php artisan migrate:fresh --seed
```

### 5. Kompilasi Aset & Menjalankan Server
Buka dua terminal terpisah:
**Terminal 1 (Asset Compiler):**
```Bash
npm run dev
```

**Terminal 2 (Laravel Server):**
```Bash
php artisan serve
```
Akses aplikasi melalui peramban di: `http://127.0.0.1:8000`

## 🧪 Pengujian Sistem (Testing)

### **Automated Feature & ACID Tests**
Proyek ini dilengkapi pengujian otomatis untuk memverifikasi integritas signature key, validasi anti-fraud, dan mekanisme _database rollback_ saat terjadi kegagalan:

```Bash
php artisan test --filter=MidtransPaymentTest
```

### **End-to-End (E2E) Browser Testing (Laravel Dusk)**
Pengujian simulasi peramban interaktif dari alur pendaftaran, pembelian produk, hingga dashboard admin:

```Bash
# Sesuaikan driver Chrome jika diperlukan
php artisan dusk:chrome-driver --detect

# Jalankan pengujian E2E
php artisan dusk
```

## 👥 Tim Pengembang
Platform ini dikembangkan oleh tim mahasiswa **Universitas Negeri Malang (UM)**:
- **Adhyaksa Daudi M. A.** - _Project Lead, Full-Stack Architecture & Editing_
- **Alfando Ahmad Ghani** - _Financial Engineering & Documentation_
- **Azahra Brilian Kusuma** - _SWOT Analysis & Marketing Strategy_
- **Daffa Rikza Mansuri** - _Product Management & Operations_
