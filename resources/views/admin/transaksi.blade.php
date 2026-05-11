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
                <h1 class="text-2xl font-bold text-gray-900">Data Transaksi</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan verifikasi seluruh transaksi pembelian dari pengguna.</p>
            </div>
            <button class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </button>
        </div>

        <!-- Filter / Search -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-3" placeholder="Cari ID Transaksi atau Nama User...">
            </div>
            <div class="flex gap-2">
                <input type="date" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3">
                <select class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Sukses</option>
                    <option>Gagal</option>
                </select>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID Transaksi & Waktu</th>
                            <th scope="col" class="px-6 py-4">Pengguna</th>
                            <th scope="col" class="px-6 py-4">Produk</th>
                            <th scope="col" class="px-6 py-4">Metode Bayar</th>
                            <th scope="col" class="px-6 py-4">Total</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transactions as $trx)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-mono text-xs font-bold text-[#0A2540]">{{ $trx['id'] }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $trx['date'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $trx['user'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-700 line-clamp-1 max-w-[150px]" title="{{ $trx['product'] }}">{{ $trx['product'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-semibold">{{ $trx['method'] }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $trx['total'] }}
                            </td>
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
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($trx['status'] == 'Menunggu')
                                        <button class="p-2 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg transition-colors" title="Verifikasi Transaksi">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Tolak Transaksi">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                    <button class="p-2 bg-gray-50 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Placeholder -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-sm text-gray-500">Menampilkan 1 hingga 3 dari 3 data</span>
                <div class="flex gap-1">
                    <button class="px-3 py-1 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed text-sm" disabled>Prev</button>
                    <button class="px-3 py-1 rounded-lg border border-[#0A2540] bg-[#0A2540] text-white font-medium text-sm">1</button>
                    <button class="px-3 py-1 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed text-sm" disabled>Next</button>
                </div>
            </div>
        </div>

    </div>
</x-dashboard>
