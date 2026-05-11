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
                <h1 class="text-2xl font-bold text-gray-900">Langganan Aktif</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau semua layanan langganan Anda yang sedang berjalan.</p>
            </div>
            <a href="{{ route('user.katalog') }}" class="px-5 py-2.5 bg-[#00E5FF] hover:bg-[#00c9e0] text-[#0A2540] font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Langganan
            </a>
        </div>

        <!-- Subscription Cards List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($subscriptions as $sub)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <!-- Card Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center overflow-hidden p-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($sub['name']) }}&background=f3f4f6&color=4b5563&font-size=0.4" alt="{{ $sub['name'] }}" class="w-full h-full object-contain rounded-lg">
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $sub['name'] }}</h3>
                            <p class="text-sm text-gray-500">Paket: {{ $sub['package'] }}</p>
                        </div>
                    </div>
                    @if($sub['status'] == 'Aktif')
                        <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold border border-green-100">Aktif</span>
                    @else
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold border border-orange-100">{{ $sub['status'] }}</span>
                    @endif
                </div>

                <!-- Progress / Timeline -->
                @php
                    $start = strtotime($sub['start_date']);
                    $end = strtotime($sub['end_date']);
                    $now = time();
                    
                    if($now < $start) $percent = 0;
                    elseif($now > $end) $percent = 100;
                    else $percent = round((($now - $start) / ($end - $start)) * 100);
                    
                    $daysLeft = round(($end - $now) / 86400);
                    if($daysLeft < 0) $daysLeft = 0;
                @endphp
                <div class="mb-6">
                    <div class="flex justify-between text-xs font-semibold text-gray-500 mb-2">
                        <span>Aktif sejak: {{ date('d M Y', $start) }}</span>
                        <span class="{{ $daysLeft <= 7 ? 'text-orange-500' : 'text-[#00b8cc]' }}">{{ $daysLeft }} hari tersisa</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full {{ $daysLeft <= 7 ? 'bg-orange-500' : 'bg-[#0A2540]' }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="flex justify-end text-xs font-semibold text-gray-400 mt-2">
                        <span>Berakhir: {{ date('d M Y', $end) }}</span>
                    </div>
                </div>

                <!-- Footer / Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <div class="flex items-center gap-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" {{ $sub['auto_renew'] ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#00E5FF]"></div>
                            <span class="ml-3 text-xs font-medium text-gray-600">Auto-Renew</span>
                        </label>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-xs font-bold transition-colors">Credential</button>
                        <button class="px-4 py-2 bg-[#0A2540] text-white hover:bg-[#0d2e59] rounded-xl text-xs font-bold transition-colors shadow-sm">Perpanjang</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada langganan aktif</h3>
                <p class="text-gray-500 mb-6 max-w-sm">Anda belum memiliki paket langganan yang sedang berjalan. Mulai berlangganan sekarang untuk menikmati akses premium.</p>
                <a href="{{ route('user.katalog') }}" class="px-6 py-3 bg-[#00E5FF] hover:bg-[#00c9e0] text-[#0A2540] font-bold rounded-xl transition-colors shadow-sm">Jelajahi Katalog</a>
            </div>
            @endforelse
        </div>
    </div>
</x-dashboard>
