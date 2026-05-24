<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div x-data="{ showToast: false, toastMessage: '' }" class="space-y-6">
        
        <!-- Toast Notification -->
        <div x-show="showToast" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3"
            style="display: none;">
            <svg class="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span x-text="toastMessage" class="text-sm font-medium"></span>
        </div>
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Pendapatan</h1>
                <p class="text-sm text-gray-500 mt-1">Analisis performa penjualan dan tren pendapatan.</p>
            </div>
            
            <div class="flex gap-2">
                <select
                    onchange="window.location.href = '?periode=' + this.value"
                    class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block px-3 py-2 pr-10">
                    <option value="bulan-ini" {{ ($periode ?? 'bulan-ini') === 'bulan-ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="bulan-lalu" {{ ($periode ?? '') === 'bulan-lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                    <option value="tahun-ini" {{ ($periode ?? '') === 'tahun-ini' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
                <a href="{{ route('admin.laporan.pdf', ['periode' => request('periode', 'bulan-ini')]) }}" class="px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF
                </a>
            </div>
        </div>

        <!-- 3 Metrik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gross Revenue -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Gross Revenue</p>
                <h3 class="text-3xl font-black text-[#0A2540] relative z-10">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-green-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        Aktif
                    </span>
                    <span class="text-gray-400 ml-2">periode terpilih</span>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Keuntungan Bersih (AksesPro)</p>
                <h3 class="text-3xl font-black text-[#00b8cc] relative z-10">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-green-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        Aktif
                    </span>
                    <span class="text-gray-400 ml-2">selisih harga jual & modal</span>
                </div>
            </div>

            <!-- Refund / Gagal -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Transaksi Gagal</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">{{ $failedTransactions }} Transaksi</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-red-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        Gagal
                    </span>
                    <span class="text-gray-400 ml-2">perlu diperhatikan</span>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Bar Chart: Penjualan per Kategori -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Penjualan per Kategori</h2>
                <div class="relative h-64 w-full">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart: Metode Pembayaran -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran Terpopuler</h2>
                <div class="relative h-64 w-full flex justify-center">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Bar Chart
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        label: 'Penjualan (Rupiah)',
                        data: {!! json_encode($categoryValues) !!},
                        backgroundColor: '#00E5FF',
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            },
                            ticks: { color: '#9ca3af' }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#6b7280', font: { weight: '600' } }
                        }
                    }
                }
            });

            // Payment Doughnut Chart
            const ctxPayment = document.getElementById('paymentChart').getContext('2d');
            new Chart(ctxPayment, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($paymentLabels) !!},
                    datasets: [{
                        data: {!! json_encode($paymentValues) !!},
                        backgroundColor: [
                            '#00E5FF', // Electric Cyan
                            '#0A2540', // Tech Navy Blue
                            '#60a5fa', // Light Blue
                            '#e5e7eb'  // Gray
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#4b5563',
                                font: { weight: '600', size: 12 },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed + ' transaksi';
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    @endpush
</x-dashboard>