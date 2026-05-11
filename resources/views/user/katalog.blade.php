<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Katalog Produk</h1>
                <p class="text-sm text-gray-500 mt-1">Pilih layanan premium favorit Anda dengan harga pelajar.</p>
            </div>
            
            <!-- Category Filter -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 hide-scrollbar">
                <button class="px-4 py-2 bg-[#0A2540] text-white rounded-full text-sm font-medium whitespace-nowrap transition-colors">Semua</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Streaming</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Musik</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Desain</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Produktivitas</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
                <!-- Top / Banner Part -->
                <div class="h-24 bg-gradient-to-r from-gray-50 to-gray-100 relative flex justify-end p-4">
                    <!-- Discount Badge -->
                    @if(isset($product['original_price']))
                    @php
                        $discount = round((($product['original_price'] - $product['price']) / $product['original_price']) * 100);
                    @endphp
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-lg">
                        Hemat {{ $discount }}%
                    </div>
                    @endif
                    <!-- Icon / Initial -->
                    <div class="absolute -bottom-8 left-6 w-16 h-16 bg-white rounded-xl shadow-md border border-gray-50 flex items-center justify-center overflow-hidden p-2 group-hover:-translate-y-1 transition-transform">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product['name']) }}&background=00E5FF&color=0A2540&font-size=0.4&bold=true" alt="{{ $product['name'] }}" class="w-full h-full object-contain rounded-lg">
                    </div>
                </div>

                <!-- Body -->
                <div class="pt-12 p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-md">{{ $product['category'] }}</span>
                        <span class="text-xs font-medium text-gray-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $product['duration'] }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-1">{{ $product['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">Akses fitur premium tanpa batas, nikmati layanan terbaik dengan harga super hemat.</p>
                    
                    <!-- Pricing & Action -->
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between">
                        <div>
                            @if(isset($product['original_price']))
                                <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product['original_price'], 0, ',', '.') }}</p>
                            @endif
                            <p class="text-xl font-black text-[#0A2540]">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                        </div>
                        <button class="bg-[#0A2540] hover:bg-[#0d2e59] text-white p-2.5 rounded-xl transition-colors shadow-sm group-hover:shadow-md" title="Beli Sekarang">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <!-- Hide scrollbar for category filter -->
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-dashboard>
