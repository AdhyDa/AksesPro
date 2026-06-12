## Restorasi UI React.js + Inertia.js

**[SYSTEM ROLE & CONTEXT]** Bertindaklah sebagai _Senior UI/UX Engineer_ yang ahli dalam React, Tailwind CSS, Inertia.js, dan transisi dari Alpine.js.

Saat ini, proyek "AksesPro" mengalami kerusakan _layout_ (UI) setelah bermigrasi dari Laravel Blade ke React + Inertia.js. Tugas utamamu adalah **merestorasi total** tampilan _frontend_ React agar bentuk visual, jarak (_spacing_), warna, dan animasinya **IDENTIK 100%** dengan tampilan asli versi Blade.

Saya melampirkan referensi kode asli (Blade) dan/atau gambar UI sedia kala (terlampir di bagian "LAMPIRAN"). Gunakan ini sebagai _Absolute Source of Truth_.

**[TASK 1: TAILWIND & ASSET CONFIGURATION FIX]**

1. Periksa dan perbarui `tailwind.config.js`. Pastikan pada bagian `content: [...]` sudah mencakup jalur _file_ React: `content: ['./resources/js/**/*.jsx', './resources/js/**/*.tsx']`.
    
2. Pastikan file `resources/js/app.jsx` sudah mengimpor _file_ CSS utama yang berisi direktif `@tailwind` (misalnya: `import '../css/app.css';`).
    

**[TASK 2: STRICT HTML TO JSX CONVERSION]**

1. Terjemahkan kode HTML dari Blade ke JSX secara presisi. Ubah semua `class="..."` menjadi `className="..."`.
    
2. Jangan ubah satu pun _class_ Tailwind bawaan dari referensi asli. Jika tombol aslinya menggunakan `bg-cyan-500 hover:bg-cyan-600 rounded-xl shadow-sm`, pertahankan persis seperti itu.
    
3. Perbaiki penulisan atribut SVG (misalnya `stroke-width` menjadi `strokeWidth`, `fill-rule` menjadi `fillRule`) agar tidak memunculkan _error_ di konsol React.
    

**[TASK 3: ALPINE.JS TO REACT STATE & ANIMATION]** Animasi interaktif yang sebelumnya menggunakan Alpine.js (`x-data`, `x-show`, `x-transition`) harus dikonversi menjadi React!

1. Gunakan `useState` untuk mengontrol buka/tutup elemen (misal: _Dropdown Profil_, _Sidebar Mobile_, atau _Modal Midtrans_).
    
2. **Implementasi Animasi:** Untuk mempertahankan animasi yang mulus (`fade-in`, `slide-up`), gunakan _Headless UI_ (`@headlessui/react`) komponen `<Transition>` ATAU gunakan _conditional rendering_ standar yang digabungkan dengan kelas transisi Tailwind (`transition-all duration-300 ease-in-out`).
    
3. Buat contoh penerapan `useState` yang mengendalikan _sidebar toggle_ di _file_ `DashboardLayout.jsx`.
    

**[TASK 4: REUSABLE COMPONENTS REFRACTORING]** Agar kode rapi, pecah bagian UI yang berulang menjadi komponen React kecil di dalam _folder_ `resources/js/Components/`. Misalnya:

- `PrimaryButton.jsx`
    
- `ProductCard.jsx` (Lengkap dengan label "🔥 Hemat X%" dari data _props_ backend).
    
- `StatCard.jsx`
    

**[LAMPIRAN]**
#### Home
![[Screenshot 2026-06-11 111834.png]]

#### PLATFORM YANG DIDUKUNG
harus menggunakan animasi infinite carousel yang bergerak dari kanan ke kiri secara horizontal
![[Screenshot 2026-06-11 111852.png]]

#### KENAPA KAMI
![[Screenshot 2026-06-11 111915.png]]

#### KATALOG PRODUK
![[Screenshot 2026-06-11 111948.png]]

#### KATALOG PRODUK
![[Screenshot 2026-06-11 111959.png]]

#### CARA KERJA
![[Screenshot 2026-06-11 112012.png]]

#### TESTIMONI
![[Screenshot 2026-06-11 112023.png]]

#### TESTIMONI
![[Screenshot 2026-06-11 112033.png]]

#### FOOTER
![[Screenshot 2026-06-11 112044.png]]

Berikan saya revisi kode untuk `tailwind.config.js`, `app.jsx`, `DashboardLayout.jsx`, dan salah satu halaman utama (`User/Dashboard.jsx`) agar saya bisa melihat hasil restorasinya berjalan mulus beserta animasinya.