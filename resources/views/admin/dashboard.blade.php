<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Periode:</span>
                <select class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#00E5FF] focus:border-[#00E5FF] block px-3 py-2">
                    <option>Bulan Ini</option>
                    <option>Bulan Lalu</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
        </div>

        <!-- 4 Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pendapatan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['monthly_revenue'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-500 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        {{ $stats['revenue_trend'] }}
                    </span>
                    <span class="text-gray-400 ml-2">vs bulan lalu</span>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-500 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        {{ $stats['users_trend'] }}
                    </span>
                    <span class="text-gray-400 ml-2">pengguna baru</span>
                </div>
            </div>

            <!-- Pesanan Sukses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pesanan Sukses</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['successful_orders'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-500 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        {{ $stats['orders_trend'] }}
                    </span>
                    <span class="text-gray-400 ml-2">vs bulan lalu</span>
                </div>
            </div>

            <!-- Tiket Komplain -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Komplain</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['complaint_tickets'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-500 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        {{ $stats['tickets_trend'] }}
                    </span>
                    <span class="text-gray-400 ml-2">menurun</span>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900">Statistik Pendapatan (6 Bulan Terakhir)</h2>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Main Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h2 class="text-lg font-bold text-gray-900">Transaksi Masuk Terbaru</h2>
                <a href="#" class="px-4 py-2 bg-[#00E5FF]/10 text-[#00b8cc] hover:bg-[#00E5FF]/20 font-semibold rounded-lg text-sm transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama User</th>
                            <th scope="col" class="px-6 py-4">Produk</th>
                            <th scope="col" class="px-6 py-4">Total Harga</th>
                            <th scope="col" class="px-6 py-4">Metode Bayar</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_transactions as $trx)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($trx['user']) }}&background=fff&color=0A2540" alt="{{ $trx['user'] }}" class="w-full h-full object-cover">
                                </div>
                                {{ $trx['user'] }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $trx['product'] }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $trx['total'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $trx['payment'] }}</td>
                            <td class="px-6 py-4">
                                @if($trx['status'] == 'Sukses')
                                    <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Sukses
                                    </span>
                                @elseif($trx['status'] == 'Menunggu')
                                    <span class="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Menunggu
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
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

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Gradient for the line area
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(0, 229, 255, 0.5)'); // Electric Cyan with opacity
            gradient.addColorStop(1, 'rgba(0, 229, 255, 0.0)');

            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Pendapatan (Juta Rupiah)',
                        data: [12.5, 15.2, 28.4, 22.1, 35.6, 29.8],
                        borderColor: '#0A2540', // Tech Navy Blue
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#00E5FF', // Electric Cyan
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Curve the line
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend to match design
                        },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y + ' Juta';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 40,
                            grid: {
                                color: '#f3f4f6', // Light gray grid lines
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af', // Gray text
                                stepSize: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false, // Hide vertical grid lines
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af' // Gray text
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
    @endpush
</x-dashboard>
