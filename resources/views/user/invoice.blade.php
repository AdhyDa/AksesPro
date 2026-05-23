<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_id }} - AksesPro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }

            .invoice-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }

        .glow-green {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }

        .grid-bg {
            background-image: radial-gradient(rgba(0, 229, 255, 0.03) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800 min-h-screen py-10 px-4 sm:px-6 grid-bg">

    <!-- Actions Bar (Hidden on print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('user.transaksi') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#0A2540] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <!-- Main Invoice Container -->
    <div
        class="max-w-3xl mx-auto bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden invoice-card relative">
        <!-- Top Colored Strip -->
        <div class="h-3 bg-gradient-to-r from-[#0A2540] via-[#00E5FF] to-[#0A2540]"></div>

        <div class="p-8 sm:p-12 space-y-10">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-slate-100 pb-8">
                <!-- Branding -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <img src="{{ asset('Logo.png') }}" alt="AksesPro" class="w-10 h-10 w-auto object-contain">
                        <span class="text-xl font-bold text-gray-900 flex items-center">Akses
                            <p class="text-[#FFD700]">Pro</p>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 font-semibold tracking-wider uppercase mb-1">Disediakan Oleh</p>
                    <p class="text-sm font-bold text-slate-700">CV AksesPro Indonesia</p>
                    <p class="text-xs text-slate-500 max-w-xs mt-0.5">Layanan patungan premium mahasiswa yang legal,
                        aman, & terpercaya.</p>
                </div>

                <!-- Invoice Details -->
                <div class="sm:text-right">
                    <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight mb-2">INVOICE</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Nomor Invoice</p>
                    <p class="text-sm font-mono font-bold text-slate-900 mb-3">{{ $transaction->invoice_id }}</p>

                    @if ($transaction->status == 'success')
                        <span
                            class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-xs font-bold uppercase tracking-wider glow-green">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Berhasil
                        </span>
                    @elseif($transaction->status == 'pending')
                        <span
                            class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-full text-xs font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Menunggu
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-xs font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            Gagal
                        </span>
                    @endif
                </div>
            </div>

            <!-- Billing Details -->
            <div class="grid sm:grid-cols-2 gap-8 text-sm">
                <!-- Bill To -->
                <div>
                    <h3 class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-3">Ditagihkan Kepada</h3>
                    <p class="text-base font-bold text-slate-900">{{ $transaction->user->name }}</p>
                    <p class="text-slate-500 mt-1">{{ $transaction->user->email }}</p>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Role:
                        {{ ucfirst($transaction->user->role) }}</p>
                </div>

                <!-- Info Column -->
                <div class="sm:pl-8 sm:border-l border-slate-100 space-y-3">
                    <div>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Tanggal
                            Transaksi</span>
                        <span class="font-semibold text-slate-800">{{ $transaction->created_at->format('d M Y, H:i') }}
                            WIB</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Metode
                            Pembayaran</span>
                        <span class="font-semibold text-slate-800">{{ $transaction->payment_method }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-slate-50 text-xs text-slate-500 uppercase font-bold tracking-wider border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">Deskripsi Produk</th>
                            <th scope="col" class="px-6 py-4 text-center">Durasi</th>
                            <th scope="col" class="px-6 py-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="bg-white">
                            <td class="px-6 py-5">
                                <p class="font-bold text-slate-900 text-base">{{ $transaction->product->name }}</p>
                                <p class="text-xs text-slate-400 mt-1">Kategori: {{ $transaction->product->category }}
                                </p>
                            </td>
                            <td class="px-6 py-5 text-center font-medium text-slate-700">
                                {{ $transaction->product->duration_days }} Hari
                            </td>
                            <td class="px-6 py-5 text-right font-bold text-slate-900 text-base">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Section -->
            <div class="flex justify-end pt-4">
                <div class="w-full sm:w-64 space-y-3 text-sm">
                    <div class="flex justify-between text-slate-500 font-semibold">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500 font-semibold border-b border-slate-100 pb-3">
                        <span>Pajak (0%)</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-slate-800 font-bold text-base">Total Bayar</span>
                        <span class="text-2xl font-black text-[#0A2540]">Rp
                            {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="border-t border-slate-100 pt-8 text-center text-xs text-slate-600 space-y-1">
                <p class="font-semibold">Terima kasih atas kepercayaan Anda bertransaksi di AksesPro!</p>
                <p>Jika ada kendala dalam klaim akun atau garansi, hubungi tim support kami melalui WhatsApp CS.</p>
                <p class="text-[10px] text-slate-500 mt-2 font-mono">Invoice ini diterbitkan secara resmi melalui sistem
                    otomasi AksesPro.</p>
            </div>
        </div>
    </div>

</body>

</html>
