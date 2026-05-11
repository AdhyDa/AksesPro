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
                <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar anggota terdaftar dan riwayat aktivitas mereka.</p>
            </div>
            <button class="px-5 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Filter / Search -->
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-3" placeholder="Cari nama atau email pengguna...">
            </div>
            <select class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3 min-w-[150px]">
                <option>Semua Peran</option>
                <option>Member</option>
                <option>Admin</option>
            </select>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">Pengguna</th>
                            <th scope="col" class="px-6 py-4">Peran</th>
                            <th scope="col" class="px-6 py-4">Total Poin</th>
                            <th scope="col" class="px-6 py-4">Tanggal Daftar</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $u)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($u['name']) }}&background=f3f4f6&color=0A2540" alt="{{ $u['name'] }}" class="w-10 h-10 rounded-full border border-gray-200">
                                <div>
                                    <div class="font-bold text-gray-900">{{ $u['name'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $u['email'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-[#0A2540]/5 text-[#0A2540] border border-[#0A2540]/10 rounded-md text-xs font-semibold">{{ $u['role'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-[#00b8cc] flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ number_format($u['points'], 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ date('d M Y', strtotime($u['join_date'])) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($u['status'] == 'Aktif')
                                    <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div> Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 bg-gray-50 text-gray-500 hover:bg-[#00E5FF]/10 hover:text-[#00b8cc] rounded-lg transition-colors" title="Edit Pengguna">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="p-2 bg-gray-50 text-gray-500 hover:bg-red-100 hover:text-red-600 rounded-lg transition-colors" title="Banned / Suspend">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
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
                <span class="text-sm text-gray-500">Menampilkan 1 hingga 3 dari 3 pengguna</span>
            </div>
        </div>

    </div>
</x-dashboard>
