<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">
        
        <!-- Greeting Banner -->
        <div class="bg-[#0A2540] rounded-2xl p-6 sm:p-10 relative overflow-hidden shadow-lg border border-[#0A2540]/50">
            <!-- Decorative background circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-[#00E5FF]/10 blur-3xl"></div>
            <div class="absolute bottom-0 right-40 w-40 h-40 rounded-full bg-blue-500/10 blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Selamat datang kembali, {{ $user['name'] }}! 👋</h1>
                    <p class="text-blue-100 text-sm sm:text-base max-w-xl">
                        Kelola langganan digital premium Anda, nikmati akses tanpa batas, dan kumpulkan poin untuk ditukarkan dengan potongan harga menarik.
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-4 flex items-center gap-4 shadow-inner min-w-[200px]">
                    <div class="w-12 h-12 rounded-full bg-[#00E5FF]/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <div>
                        <p class="text-white/70 text-xs uppercase tracking-wider font-semibold">Total Poin Anda</p>
                        <p class="text-2xl font-bold text-white">{{ $user['points'] }} <span class="text-sm text-[#00E5FF] font-medium">Pts</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Active Subscriptions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Langganan Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['active_subscriptions'] }}</h3>
                    <p class="text-green-500 text-xs font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        Aktif bulan ini
                    </p>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_transactions'] }}</h3>
                    <p class="text-green-500 text-xs font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +2 dari bulan lalu
                    </p>
                </div>
            </div>

            <!-- Points Collected -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Poin Terkumpul</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['points_collected'] }}</h3>
                    <p class="text-green-500 text-xs font-medium mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +50 dari Transaksi
                    </p>
                </div>
            </div>

            <!-- Estimated Savings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Estimasi Penghematan</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['estimated_savings'] }}</h3>
                    <p class="text-gray-400 text-xs font-medium mt-1">
                        Bulan ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h2 class="text-lg font-bold text-gray-900">Langganan Aktif Saya</h2>
                <a href="#" class="px-4 py-2 bg-[#00E5FF]/10 text-[#00b8cc] hover:bg-[#00E5FF]/20 font-semibold rounded-lg text-sm transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Aplikasi</th>
                            <th scope="col" class="px-6 py-4">Paket</th>
                            <th scope="col" class="px-6 py-4">Tanggal Berakhir</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $sub)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($sub['name']) }}&background=f3f4f6&color=4b5563&font-size=0.4" alt="{{ $sub['name'] }}" class="w-full h-full object-cover">
                                </div>
                                {{ $sub['name'] }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-semibold">{{ $sub['package'] }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $sub['end_date'] }}</td>
                            <td class="px-6 py-4">
                                @if($sub['status'] == 'Aktif')
                                    <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> {{ $sub['status'] }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button class="p-2 text-gray-400 hover:text-[#00E5FF] hover:bg-[#00E5FF]/10 rounded-lg transition-colors" title="Perpanjang">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard>
