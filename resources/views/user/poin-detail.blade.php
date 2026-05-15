<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">
        
        <!-- Back Button -->
        <div>
            <a href="{{ route('user.katalog') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#0A2540] transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Header Box & Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Header Gradient Box -->
                <div class="bg-gradient-to-br from-[#0A2540] to-[#163b63] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-sm">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 -mr-12 -mt-12 w-40 h-40 rounded-full bg-[#00E5FF] opacity-10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-5 blur-xl"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Product Initial/Icon -->
                        <div class="w-20 h-20 bg-white rounded-2xl p-2 shadow-lg flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&background=00E5FF&color=0A2540&font-size=0.4&bold=true" alt="{{ $product->name }}" class="w-full h-full object-contain rounded-xl">
                        </div>
                        
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black mb-2 text-white">{{ $product->name }}</h1>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="bg-[#00E5FF]/20 text-[#00E5FF] font-semibold px-3 py-1 rounded-md text-sm">{{ $product->category }}</span>
                                <span class="text-gray-300 text-sm flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Masa aktif {{ $product->duration_days }} Hari
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Details -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Produk</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm sm:text-base">
                        {{ $product->description }}
                    </p>

                    <hr class="border-gray-100 mb-8">

                    <h3 class="text-lg font-bold text-gray-900 mb-4">Keuntungan Layanan</h3>
                    <ul class="space-y-4">
                        @php
                            $benefits = [
                                'Akses premium penuh tanpa batasan fitur',
                                'Akun legal 100% bergaransi selama masa aktif',
                                'Dukungan bantuan (Support) 24/7 jika terjadi kendala',
                                'Sistem cost-sharing yang sangat menghemat biaya',
                            ];
                            if ($product->category == 'Streaming') {
                                array_unshift($benefits, 'Streaming kualitas Ultra HD / 4K');
                                array_unshift($benefits, 'Akses semua film & series terbaru tanpa iklan');
                                array_unshift($benefits, 'Download konten untuk ditonton offline');
                            } elseif ($product->category == 'Musik') {
                                array_unshift($benefits, 'Kualitas audio tertinggi HD (320 kbps)');
                                array_unshift($benefits, 'Jutaan lagu & podcast eksklusif tanpa jeda iklan');
                                array_unshift($benefits, 'Download lagu & putar secara offline');
                            } elseif ($product->category == 'Desain') {
                                array_unshift($benefits, 'Akses ratusan ribu template premium & aset grafis');
                                array_unshift($benefits, 'Fitur eksklusif: Background Remover & Magic Resize');
                                array_unshift($benefits, 'Penyimpanan cloud ekstra besar');
                            }
                        @endphp
                        @foreach($benefits as $benefit)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 bg-emerald-100 text-emerald-600 rounded-full p-1 flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-gray-700 text-sm sm:text-base">{{ $benefit }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Right Column: Sticky Card (Desktop) / Bottom Card (Mobile) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl shadow-[#0A2540]/5 border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 pb-4 border-b border-gray-100">Rincian Paket</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Produk</span>
                            <span class="font-medium text-gray-900 truncate max-w-[150px]">{{ $product->name }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Masa Aktif</span>
                            <span class="font-medium text-gray-900">{{ $product->duration_days }} Hari</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Status Stok</span>
                            @if($product->stock > 0)
                                <span class="font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs">Tersedia ({{ $product->stock }})</span>
                            @else
                                <span class="font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-md text-xs">Habis</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Total Harga</p>
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-1">
                            <div>
                                <p class="text-3xl font-black text-[#0A2540]">Rp {{ number_format($product->aksespro_price, 0, ',', '.') }}</p>
                            </div>
                            @if($product->original_price)
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                    @php
                                        $discount = round((($product->original_price - $product->aksespro_price) / $product->original_price) * 100);
                                    @endphp
                                    <span class="text-xs font-bold text-red-500 block">Hemat {{ $discount }}%</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('user.poin.redeem', $product->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-[#0A2540] hover:bg-[#0d2e59] text-white py-3.5 rounded-xl font-bold text-lg transition-all transform hover:scale-[1.02] shadow-md flex items-center justify-center gap-2 {{ $product->stock <= 0 || $user['points'] < $product->aksespro_price ? 'opacity-50 cursor-not-allowed hover:scale-100' : '' }}" {{ $product->stock <= 0 || $user['points'] < $product->aksespro_price ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            Tukar Sekarang
                        </button>
                    </form>
                    <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Transaksi dijamin 100% aman
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-dashboard>
