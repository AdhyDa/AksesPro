<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <!-- Page Content -->
    <div x-data="adminDashboard()" class="space-y-6">

        <!-- Toast Notification -->
        <div x-show="showToast" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3"
            style="display: none;">
            <svg class="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="toastMessage" class="text-sm font-medium"></span>
        </div>
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-[#0A2540]">Dashboard Overview</h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Periode:</span>
                <select
                    @change="changePeriode($event.target.value)"
                    class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#00E5FF] focus:border-[#00E5FF] block px-3 py-2 pr-10 font-medium cursor-pointer shadow-sm hover:border-gray-300 transition-colors">
                    <option value="bulan-ini" :selected="periode === 'bulan-ini'">Bulan Ini</option>
                    <option value="bulan-lalu" :selected="periode === 'bulan-lalu'">Bulan Lalu</option>
                    <option value="tahun-ini" :selected="periode === 'tahun-ini'">Tahun Ini</option>
                </select>
            </div>
        </div>

        <!-- 4 Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pendapatan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition-all duration-300 hover:shadow-md group">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-6 h-6 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1" x-text="periode === 'tahun-ini' ? 'Pendapatan Tahun Ini' : (periode === 'bulan-lalu' ? 'Pendapatan Bulan Lalu' : 'Pendapatan Bulan Ini')">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900 transition-all duration-300" x-text="stats.monthly_revenue">{{ $stats['monthly_revenue'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span :class="stats.revenue_trend.startsWith('-') ? 'text-red-500' : 'text-emerald-500'" class="font-semibold flex items-center gap-1 transition-colors duration-300">
                        <svg x-show="!stats.revenue_trend.startsWith('-')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <svg x-show="stats.revenue_trend.startsWith('-')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        <span x-text="stats.revenue_trend">{{ $stats['revenue_trend'] }}</span>
                    </span>
                    <span class="text-gray-400 ml-2" x-text="periode === 'tahun-ini' ? 'vs tahun lalu' : 'vs bulan lalu'">vs bulan lalu</span>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition-all duration-300 hover:shadow-md group">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-6 h-6 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-gray-900 transition-all duration-300" x-text="stats.total_users">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-500 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span x-text="stats.users_trend">{{ $stats['users_trend'] }}</span>
                    </span>
                    <span class="text-gray-400 ml-2" x-text="periode === 'tahun-ini' ? 'pengguna baru tahun ini' : (periode === 'bulan-lalu' ? 'pengguna baru bulan lalu' : 'pengguna baru bulan ini')">pengguna baru</span>
                </div>
            </div>

            <!-- Pesanan Sukses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition-all duration-300 hover:shadow-md group">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-6 h-6 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pesanan Sukses</p>
                        <h3 class="text-2xl font-bold text-gray-900 transition-all duration-300" x-text="stats.successful_orders">{{ $stats['successful_orders'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span :class="stats.orders_trend.startsWith('-') ? 'text-red-500' : 'text-emerald-500'" class="font-semibold flex items-center gap-1 transition-colors duration-300">
                        <svg x-show="!stats.orders_trend.startsWith('-')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <svg x-show="stats.orders_trend.startsWith('-')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        <span x-text="stats.orders_trend">{{ $stats['orders_trend'] }}</span>
                    </span>
                    <span class="text-gray-400 ml-2" x-text="periode === 'tahun-ini' ? 'vs tahun lalu' : 'vs bulan lalu'">vs bulan lalu</span>
                </div>
            </div>

            <!-- Tiket Komplain -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition-all duration-300 hover:shadow-md group">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-6 h-6 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Komplain</p>
                        <h3 class="text-2xl font-bold text-gray-900 transition-all duration-300" x-text="stats.complaint_tickets">{{ $stats['complaint_tickets'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span :class="stats.tickets_trend.startsWith('-') ? 'text-emerald-500' : (stats.tickets_trend.startsWith('+') ? 'text-red-500' : 'text-gray-500')" class="font-semibold flex items-center gap-1 transition-colors duration-300">
                        <svg x-show="stats.tickets_trend.startsWith('-')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        <svg x-show="stats.tickets_trend.startsWith('+')" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span x-text="stats.tickets_trend">{{ $stats['tickets_trend'] }}</span>
                    </span>
                    <span class="text-gray-400 ml-2" x-text="stats.tickets_trend.startsWith('-') ? 'menurun vs periode lalu' : (stats.tickets_trend.startsWith('+') ? 'meningkat vs periode lalu' : 'stabil')">menurun</span>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Statistik Pendapatan (Line Chart) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-md">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-8 h-8 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-[#0A2540]">Statistik Pendapatan</h2>
                    <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-2.5 py-1 rounded-lg transition-all duration-300" x-text="periode === 'tahun-ini' ? 'Tahun Ini (Bulanan)' : (periode === 'bulan-lalu' ? 'Bulan Lalu (Harian)' : 'Bulan Ini (Harian)')">Bulan Ini (Harian)</span>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Kategori Produk Terlaris (Doughnut Chart) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-md">
                <div x-show="isLoading" x-transition class="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
                    <div class="w-8 h-8 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-50 pb-3">
                    <h2 class="text-lg font-bold text-[#0A2540]">Kategori Terlaris</h2>
                    <span class="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-lg">Volume</span>
                </div>
                <div class="relative h-44 w-full flex items-center justify-center my-2">
                    <canvas id="categoryChart"></canvas>
                </div>
                <!-- Legends -->
                <div class="flex flex-wrap justify-center gap-3 text-xs font-bold text-gray-500 mt-2">
                    <template x-for="(label, index) in categoryLabels" :key="index">
                        <div x-show="categoryData[index] > 0" x-transition class="flex items-center gap-1.5 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100/50">
                            <span class="w-2.5 h-2.5 rounded-full" :style="'background-color: ' + ['#0A2540', '#00E5FF', '#4F46E5', '#10B981'][index % 4]"></span>
                            <span x-text="label"></span>
                        </div>
                    </template>
                    <div x-show="categoryData.reduce((a, b) => a + b, 0) === 0" class="text-gray-400 text-xs py-1" style="display: none;">Tidak ada penjualan di periode ini</div>
                </div>
            </div>
        </div>

        <!-- Tables & Lists Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Transaksi Masuk Terbaru (2/3 width) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2 flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                <div>
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <h2 class="text-lg font-bold text-[#0A2540]">Transaksi Masuk Terbaru</h2>
                        <a href="{{ url('/admin/transaksi') }}"
                            class="px-4 py-2 bg-[#00E5FF]/10 text-[#00b8cc] hover:bg-[#00E5FF]/20 font-semibold rounded-lg text-sm transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nama User</th>
                                    <th scope="col" class="px-6 py-4">Produk</th>
                                    <th scope="col" class="px-6 py-4">Total</th>
                                    <th scope="col" class="px-6 py-4">Metode</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_transactions as $trx)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-semibold text-gray-900 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($trx['user']) }}&background=fff&color=0A2540"
                                                    alt="{{ $trx['user'] }}" class="w-full h-full object-cover">
                                            </div>
                                            {{ $trx['user'] }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">{{ $trx['product'] }}</td>
                                        <td class="px-6 py-4 font-bold text-[#0A2540]">{{ $trx['total'] }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-semibold">{{ $trx['payment'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($trx['status'] == 'Sukses' || $trx['status'] == 'success')
                                                <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-green-100">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div> Sukses
                                                </span>
                                            @elseif($trx['status'] == 'Menunggu' || $trx['status'] == 'pending')
                                                <span class="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-orange-100">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Menunggu
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-red-100">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div> Gagal
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Pengguna Baru Terdaftar (1/3 width) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                <div>
                    <div class="border-b border-gray-50 pb-4 mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-[#0A2540]">Pengguna Baru</h2>
                        <a href="{{ url('/admin/pengguna') }}" class="text-xs font-bold text-[#00b8cc] hover:underline bg-[#00E5FF]/10 px-2 py-1 rounded-md">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentUsers as $usr)
                        <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50/70 transition-colors border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-100 text-[#0a2540] flex items-center justify-center font-bold border border-gray-200 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($usr['name']) }}&background=0A2540&color=fff" alt="{{ $usr['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 leading-tight">{{ $usr['name'] }}</h4>
                                    <p class="text-xs text-gray-400 font-mono mt-0.5 leading-none">{{ Str::limit($usr['email'], 20) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-semibold">{{ $usr['date'] }}</p>
                                <span class="inline-flex text-[9px] font-bold text-[#00b8cc] bg-[#00E5FF]/10 px-2 py-0.5 rounded-md mt-1">{{ number_format($usr['points'], 0, ',', '.') }} Pts</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-500 text-center py-6">Belum ada pengguna baru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Helper function to format currency as IDR
            function formatRupiah(value) {
                if (value === 0) return 'Rp 0';
                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function adminDashboard() {
                return {
                    showToast: false,
                    toastMessage: '',
                    isLoading: false,
                    
                    stats: {
                        monthly_revenue: '{{ $stats['monthly_revenue'] }}',
                        revenue_trend: '{{ $stats['revenue_trend'] }}',
                        total_users: '{{ $stats['total_users'] }}',
                        users_trend: '{{ $stats['users_trend'] }}',
                        successful_orders: '{{ $stats['successful_orders'] }}',
                        orders_trend: '{{ $stats['orders_trend'] }}',
                        complaint_tickets: '{{ $stats['complaint_tickets'] }}',
                        tickets_trend: '{{ $stats['tickets_trend'] }}',
                    },
                    
                    periode: '{{ $periode }}',
                    categoryLabels: {!! json_encode($categoryLabels) !!},
                    categoryData: {!! json_encode($categoryData) !!},
                    
                    async changePeriode(newPeriode) {
                        if (this.isLoading) return;
                        
                        this.periode = newPeriode;
                        this.isLoading = true;
                        this.toastMessage = 'Memuat data untuk periode: ' + this.getPeriodeLabel(newPeriode);
                        this.showToast = true;
                        
                        try {
                            const response = await fetch('{{ route('admin.dashboard') }}?periode=' + newPeriode + '&ajax=1', {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                            const data = await response.json();
                            
                            // 300ms delay to allow micro-animations of layouts
                            setTimeout(() => {
                                this.stats = data.stats;
                                this.categoryLabels = data.categoryLabels;
                                this.categoryData = data.categoryData;
                                
                                // 1. Update Revenue Line Chart datasets
                                if (window.revenueChart) {
                                    window.revenueChart.data.labels = data.chartLabels;
                                    window.revenueChart.data.datasets[0].data = data.chartData;
                                    
                                    // Dynamic chart labels
                                    if (newPeriode === 'tahun-ini') {
                                        window.revenueChart.data.datasets[0].label = 'Pendapatan (Rp)';
                                    } else {
                                        window.revenueChart.data.datasets[0].label = 'Pendapatan Harian (Rp)';
                                    }
                                    
                                    window.revenueChart.update('active'); // triggering smooth built-in transit update
                                }
                                
                                // 2. Update Category Doughnut Chart datasets
                                if (window.categoryChart) {
                                    window.categoryChart.data.labels = data.categoryLabels;
                                    window.categoryChart.data.datasets[0].data = data.categoryData;
                                    window.categoryChart.update('active');
                                }
                                
                                this.isLoading = false;
                                setTimeout(() => this.showToast = false, 1500);
                            }, 300);
                            
                        } catch (error) {
                            console.error('Failed to load dashboard data:', error);
                            this.isLoading = false;
                            this.toastMessage = 'Gagal memuat data rekap!';
                            setTimeout(() => this.showToast = false, 3000);
                        }
                    },
                    
                    getPeriodeLabel(val) {
                        if (val === 'bulan-lalu') return 'Bulan Lalu';
                        if (val === 'tahun-ini') return 'Tahun Ini';
                        return 'Bulan Ini';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // 1. Line Chart: Pendapatan
                const ctx = document.getElementById('revenueChart').getContext('2d');

                let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(0, 229, 255, 0.4)'); 
                gradient.addColorStop(1, 'rgba(0, 229, 255, 0.0)');

                window.revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: '{{ $periode === "tahun-ini" ? "Pendapatan (Rp)" : "Pendapatan Harian (Rp)" }}',
                            data: {!! json_encode($chartData) !!},
                            borderColor: '#0A2540',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#00E5FF',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0A2540',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return formatRupiah(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f8fafc',
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        weight: '600',
                                        size: 10
                                    },
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                        } else if (value >= 1000) {
                                            return 'Rp ' + (value / 1000).toFixed(0) + ' k';
                                        }
                                        return 'Rp ' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        weight: '600',
                                        size: 10
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                    }
                });

                // 2. Doughnut Chart: Kategori Terlaris
                const catCtx = document.getElementById('categoryChart').getContext('2d');
                
                window.categoryChart = new Chart(catCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($categoryLabels) !!},
                        datasets: [{
                            data: {!! json_encode($categoryData) !!},
                            backgroundColor: ['#0A2540', '#00E5FF', '#4F46E5', '#10B981'],
                            borderWidth: 3,
                            borderColor: '#fff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0A2540',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.label + ': ' + context.parsed + ' pesanan';
                                    }
                                }
                            }
                        },
                        cutout: '72%'
                    }
                });
            });
        </script>
    @endpush
</x-dashboard>
