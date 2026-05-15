<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-8">
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Header Section -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tukar Poin</h1>
            <p class="text-sm text-gray-500 mt-1">Gunakan poin Anda untuk mendapatkan akses premium secara gratis.</p>
        </div>

        <!-- Point Concept Banner -->
        <div class="bg-gradient-to-br from-[#0A2540] to-[#1a3a6e] rounded-3xl p-8 sm:p-12 relative overflow-hidden shadow-xl border border-[#0A2540]/20 flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#00E5FF]/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#00E5FF]/20 rounded-full blur-2xl -ml-10 -mb-10"></div>
            
            <div class="relative z-10 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-[#00E5FF] text-xs font-bold uppercase tracking-wider mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Sistem Poin Baru
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white mb-4 leading-tight">1 Poin <span class="text-[#00E5FF]">=</span> 1 Rupiah</h2>
                <p class="text-blue-100 text-base sm:text-lg">
                    Lebih simpel, lebih transparan. Kini Anda dapat langsung menukarkan poin Anda dengan paket berlangganan premium di bawah ini. Tidak perlu pusing menghitung konversi!
                </p>
            </div>

            <!-- Current Balance Card -->
            <div class="relative z-10 bg-white rounded-2xl p-6 shadow-2xl w-full md:w-auto min-w-[280px] text-center transform hover:scale-105 transition-transform duration-300">
                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Saldo Poin Anda</p>
                <div class="flex items-center justify-center gap-2 mb-1">
                    <svg class="w-8 h-8 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-4xl font-black text-[#0A2540]">{{ number_format($user['points'], 0, ',', '.') }}</h3>
                </div>
                <p class="text-[#00b8cc] font-medium text-sm">Senilai Rp {{ number_format($user['points'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Redeem Catalog Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Tersedia untuk Ditukar</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                @php
                    $canRedeem = $user['points'] >= $product->aksespro_price;
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border {{ $canRedeem ? 'border-[#00E5FF]/30' : 'border-gray-100' }} overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full relative">
                    
                    @if($canRedeem)
                    <div class="absolute top-0 right-0 bg-[#00E5FF] text-[#0A2540] text-xs font-bold px-3 py-1 rounded-bl-lg z-10 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Bisa Ditukar
                    </div>
                    @endif

                    <!-- Top / Banner Part -->
                    <div class="h-24 bg-gradient-to-r from-gray-50 to-gray-100 relative flex justify-end p-4">
                        <!-- Icon / Initial -->
                        <div class="absolute -bottom-8 left-6 w-16 h-16 bg-white rounded-xl shadow-md border border-gray-50 flex items-center justify-center overflow-hidden p-2 group-hover:-translate-y-1 transition-transform">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&background=00E5FF&color=0A2540&font-size=0.4&bold=true" alt="{{ $product->name }}" class="w-full h-full object-contain rounded-lg">
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="pt-12 p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-md">{{ $product->category }}</span>
                            <span class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $product->duration_days }} Hari
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-1">{{ $product->name }}</h3>
                        
                        <!-- Pricing & Action -->
                        <div class="mt-auto pt-4 border-t border-gray-50 flex flex-col gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga Penukaran:</p>
                                <div class="flex items-end gap-2">
                                    <p class="text-2xl font-black {{ $canRedeem ? 'text-[#0A2540]' : 'text-gray-400' }}">{{ number_format($product->aksespro_price, 0, ',', '.') }}</p>
                                    <p class="text-sm font-semibold {{ $canRedeem ? 'text-[#00b8cc]' : 'text-gray-400' }} mb-1">Poin</p>
                                </div>
                            </div>
                            
                            @if($canRedeem)
                                <a href="{{ route('user.poin.detail', $product->id) }}" class="w-full bg-[#0A2540] hover:bg-[#0d2e59] text-white py-2.5 rounded-xl font-bold transition-colors shadow-sm flex justify-center items-center gap-2">
                                    Tukar Sekarang
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @else
                                @php $shortfall = $product->aksespro_price - $user['points']; @endphp
                                <button disabled class="w-full bg-gray-100 text-gray-400 py-2.5 rounded-xl font-bold cursor-not-allowed">
                                    Kurang {{ number_format($shortfall, 0, ',', '.') }} Poin
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-dashboard>
