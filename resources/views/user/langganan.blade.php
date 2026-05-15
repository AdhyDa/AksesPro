<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div x-data="{ showCredential: false, activeCredName: '', activeCredEmail: '', activeCredPass: '' }" class="space-y-6">
        
        <!-- Credential Modal -->
        <div x-show="showCredential" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Backdrop -->
                <div x-show="showCredential" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-sm" @click="showCredential = false"></div>

                <!-- Modal Panel -->
                <div x-show="showCredential" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:my-8">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900" x-text="'Kredensial ' + activeCredName">Kredensial Akun</h3>
                        <button @click="showCredential = false" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-1 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Email Akun</label>
                            <div class="relative">
                                <input type="text" readonly :value="activeCredEmail" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono font-medium">
                                <button @click="navigator.clipboard.writeText(activeCredEmail); alert('Email disalin!')" class="absolute right-2 top-2 p-1 text-gray-400 hover:text-[#0A2540] hover:bg-white rounded-lg border border-transparent hover:border-gray-200 transition-colors" title="Salin Email">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Password</label>
                            <div class="relative" x-data="{ showPass: false }">
                                <input :type="showPass ? 'text' : 'password'" readonly :value="activeCredPass" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono font-medium">
                                <div class="absolute right-2 top-2 flex items-center gap-1">
                                    <button @click="showPass = !showPass" class="p-1 text-gray-400 hover:text-[#0A2540] hover:bg-white rounded-lg border border-transparent hover:border-gray-200 transition-colors" title="Lihat Password">
                                        <svg x-show="!showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                    <button @click="navigator.clipboard.writeText(activeCredPass); alert('Password disalin!')" class="p-1 text-gray-400 hover:text-[#0A2540] hover:bg-white rounded-lg border border-transparent hover:border-gray-200 transition-colors" title="Salin Password">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-blue-800 leading-relaxed">Gunakan kredensial ini untuk login ke aplikasi <strong><span x-text="activeCredName"></span></strong>. Dilarang mengganti password atau membagikan akun ini ke orang lain.</p>
                    </div>
                </div>
            </div>
        </div>
        
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
                        <button @click="activeCredName = '{{ $sub['name'] }}'; activeCredEmail = 'user{{ $loop->iteration }}@aksespro.com'; activeCredPass = 'AksesPro{{ date('Y') }}{{ $loop->iteration }}'; showCredential = true" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-xs font-bold transition-colors">Credential</button>
                        <a href="{{ route('user.katalog') }}" class="px-4 py-2 bg-[#0A2540] text-white hover:bg-[#0d2e59] rounded-xl text-xs font-bold transition-colors shadow-sm text-center">Perpanjang</a>
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
