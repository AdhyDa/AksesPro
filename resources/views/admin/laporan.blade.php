<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Pendapatan</h1>
                <p class="text-sm text-gray-500 mt-1">Analisis performa penjualan dan tren pendapatan.</p>
            </div>
            
            <div class="flex gap-2">
                <button class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-xl transition-colors shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Bulan Ini
                </button>
                <button class="px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF
                </button>
            </div>
        </div>

        <!-- 3 Metrik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gross Revenue -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Gross Revenue</p>
                <h3 class="text-3xl font-black text-[#0A2540] relative z-10">Rp 12.500.000</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-green-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        15.3%
                    </span>
                    <span class="text-gray-400 ml-2">vs bulan lalu</span>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Estimasi Net Profit (Margin 30%)</p>
                <h3 class="text-3xl font-black text-[#00b8cc] relative z-10">Rp 3.750.000</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-green-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        12.1%
                    </span>
                    <span class="text-gray-400 ml-2">vs bulan lalu</span>
                </div>
            </div>

            <!-- Refund / Gagal -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                <p class="text-sm font-semibold text-gray-500 mb-1 relative z-10">Transaksi Batal / Refund</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">Rp 450.000</h3>
                <div class="mt-4 flex items-center text-sm relative z-10">
                    <span class="text-red-500 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        2.5%
                    </span>
                    <span class="text-gray-400 ml-2">vs bulan lalu</span>
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
                    labels: ['Streaming', 'Musik', 'Desain', 'Produktivitas'],
                    datasets: [{
                        label: 'Penjualan (Juta Rp)',
                        data: [6.5, 3.2, 1.8, 1.0],
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
                    labels: ['QRIS', 'Transfer Bank', 'E-Wallet', 'Retail'],
                    datasets: [{
                        data: [45, 30, 20, 5],
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
                                    return ' ' + context.label + ': ' + context.parsed + '%';
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
