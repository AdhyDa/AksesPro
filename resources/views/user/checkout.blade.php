<x-dashboard>
    <x-slot name="userName">{{ $userName }}</x-slot>
    <x-slot name="userRole">{{ $userRole }}</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6 max-w-4xl mx-auto">
        <!-- Back Button -->
        <div>
            <a href="{{ route('user.katalog.detail', $product->slug) }}"
                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#0A2540] transition-colors bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Detail Produk
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Checkout Summary -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-12 -mt-12 w-40 h-40 rounded-full bg-[#00E5FF] opacity-5 blur-2xl"></div>
                    
                    <h2 class="text-xl font-bold text-[#0A2540] mb-6 pb-4 border-b border-gray-100">Ringkasan Pesanan</h2>

                    <div class="flex items-center gap-5 mb-6">
                        <div class="w-16 h-16 bg-gray-50 rounded-xl flex-shrink-0 border border-gray-100 flex items-center justify-center p-2">
                            @php
                                $pName = strtolower($product->name);
                                $imagePath = 'image/zoom.jpg';
                                if (str_contains($pName, 'netflix')) {
                                    $imagePath = 'image/netflix.jpg';
                                } elseif (str_contains($pName, 'spotify')) {
                                    $imagePath = 'image/spotify.jpg';
                                } elseif (str_contains($pName, 'canva')) {
                                    $imagePath = 'image/canva.jpg';
                                } elseif (str_contains($pName, 'youtube')) {
                                    $imagePath = 'image/youtube.webp';
                                } elseif (str_contains($pName, 'chatgpt')) {
                                    $imagePath = 'image/chatgpt.jpg';
                                } elseif (str_contains($pName, 'zoom')) {
                                    $imagePath = 'image/zoom.jpg';
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}" class="w-full h-full object-contain rounded-lg">
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $product->name }}</h3>
                            <p class="text-sm text-[#00b8cc] font-medium mt-1">{{ $product->category }} • Masa Aktif {{ $product->duration_days }} Hari</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100/80 space-y-3 text-sm">
                        <div class="flex justify-between items-center text-slate-500 font-medium">
                            <span>Harga Patungan</span>
                            <span class="text-slate-950">Rp {{ number_format($product->aksespro_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 font-medium">
                            <span>Pajak & Biaya Transaksi</span>
                            <span class="text-emerald-500 font-semibold">FREE (Rp 0)</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 font-medium border-t border-slate-200/60 pt-3">
                            <span class="text-base font-bold text-[#0A2540]">Total Bayar</span>
                            <span class="text-xl font-black text-[#0A2540]">Rp {{ number_format($product->aksespro_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Guarantee Information Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex gap-4 items-start">
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Garansi Legalitas 100%</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Semua paket patungan di AksesPro dijamin legal, aman, dan bergaransi penuh selama masa aktif. Tim support kami siap melayani 24/7 jika Anda mengalami kendala akses.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sticky Action Box -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-[#0A2540]/5 p-6 sticky top-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Metode Pembayaran</h3>
                        <p class="text-xs text-gray-400 mt-1">Midtrans Snap secure gateway</p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4 flex items-center justify-between bg-slate-50/50">
                        <span class="text-xs font-semibold text-slate-500">Order ID:</span>
                        <span class="text-xs font-mono font-bold text-slate-700">{{ $transaction->invoice_id }}</span>
                    </div>

                    <button id="pay-button" class="w-full bg-[#00E5FF] hover:bg-[#00b8cc] text-[#0A2540] py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-[1.02] shadow-lg shadow-[#00E5FF]/20 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm-5-4h.01M6 16h.01" />
                        </svg>
                        Bayar Sekarang
                    </button>

                    <p class="text-center text-[10px] text-gray-400 leading-relaxed flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Enkripsi keamanan SSL 256-bit
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @php
            $isProduction = filter_var(config('midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
            $snapJsUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        <script type="text/javascript" src="{{ $snapJsUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(e) {
                e.preventDefault();
                
                // Invoke Midtrans payment popup using Snap Token
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('user.transaksi') }}?payment=success&order_id=" + result.order_id;
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('user.transaksi') }}?payment=pending&order_id=" + result.order_id;
                    },
                    onError: function(result) {
                        window.location.href = "{{ route('user.transaksi') }}?payment=error&order_id=" + result.order_id;
                    },
                    onClose: function() {
                        // Customer closed the popup without paying
                    }
                });
            };
        </script>
    @endpush
</x-dashboard>
