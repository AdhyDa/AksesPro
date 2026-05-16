<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6" x-data="{ activeTab: 'umum', showToast: false, toastMessage: '' }">
        
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
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Konfigurasi umum, pembayaran, dan preferensi aplikasi.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
            
            <!-- Tabs Navigation (Sidebar on Desktop, Top on Mobile) -->
            <div class="w-full md:w-64 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 p-4 sm:p-6 flex-shrink-0">
                <nav class="flex md:flex-col gap-2 overflow-x-auto hide-scrollbar pb-2 md:pb-0">
                    <button @click="activeTab = 'umum'" :class="activeTab === 'umum' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' : 'text-gray-500 hover:bg-gray-100 border-transparent'" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Umum
                    </button>
                    <button @click="activeTab = 'pembayaran'" :class="activeTab === 'pembayaran' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' : 'text-gray-500 hover:bg-gray-100 border-transparent'" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Payment Gateway
                    </button>
                    <button @click="activeTab = 'email'" :class="activeTab === 'email' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' : 'text-gray-500 hover:bg-gray-100 border-transparent'" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        SMTP Email
                    </button>
                </nav>
            </div>

            <!-- Tab Contents -->
            <div class="flex-1 p-6 sm:p-8">
                
                <!-- Tab: Umum -->
                <div x-show="activeTab === 'umum'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Umum</h2>
                    
                    <form class="space-y-6 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                            <input type="text" value="AksesPro" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                            <textarea rows="3" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">Platform Vending Machine Lisensi Digital Premium untuk Mahasiswa.</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-[#0A2540] rounded-xl flex items-center justify-center p-2 border border-gray-200">
                                    <img src="{{ asset('Logo.png') }}" class="w-full h-full object-contain">
                                </div>
                                <button type="button" @click="toastMessage = 'Membuka dialog upload gambar...'; showToast = true; setTimeout(() => showToast = false, 3000)" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors">Ganti Logo</button>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-gray-100">
                            <button type="button" @click="toastMessage = 'Pengaturan umum berhasil disimpan'; showToast = true; setTimeout(() => showToast = false, 3000)" class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Payment Gateway -->
                <div x-show="activeTab === 'pembayaran'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Konfigurasi Payment Gateway</h2>
                    
                    <div class="bg-[#00E5FF]/10 border border-[#00E5FF]/30 rounded-xl p-4 mb-6 flex gap-3">
                        <svg class="w-6 h-6 text-[#00b8cc] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-[#0A2540]">Saat ini menggunakan Midtrans sebagai *payment gateway* utama. Pastikan Environment di set ke <strong>Sandbox</strong> saat pengembangan.</p>
                    </div>

                    <form class="space-y-6 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Midtrans Environment</label>
                            <select class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                                <option value="sandbox" selected>Sandbox (Testing)</option>
                                <option value="production">Production (Live)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant ID</label>
                            <input type="text" value="G45603405" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Client Key</label>
                            <input type="text" value="SB-Mid-client-xxxxxxxxxxxx" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Server Key</label>
                            <input type="password" value="SB-Mid-server-xxxxxxxxxxxx" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono">
                        </div>
                        <div class="pt-6 border-t border-gray-100 flex gap-4">
                            <button type="button" @click="toastMessage = 'Kredensial payment gateway disimpan'; showToast = true; setTimeout(() => showToast = false, 3000)" class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm flex-1 sm:flex-none">Simpan Kredensial</button>
                            <button type="button" @click="toastMessage = 'Koneksi ke Midtrans berhasil!'; showToast = true; setTimeout(() => showToast = false, 3000)" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold rounded-xl transition-colors hidden sm:block">Test Koneksi</button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Email -->
                <div x-show="activeTab === 'email'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Konfigurasi SMTP Email</h2>
                    
                    <form class="space-y-6 max-w-2xl">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Mailer</label>
                                <input type="text" value="smtp" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                                <input type="text" value="smtp.gmail.com" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                                <input type="text" value="465" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Encryption</label>
                                <select class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                                    <option value="tls">TLS</option>
                                    <option value="ssl" selected>SSL</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mail Username</label>
                            <input type="email" value="adhyaksa209@gmail.com" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mail App Password</label>
                            <input type="password" value="********" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3">
                        </div>
                        <div class="pt-6 border-t border-gray-100">
                            <button type="button" @click="toastMessage = 'Konfigurasi SMTP berhasil disimpan'; showToast = true; setTimeout(() => showToast = false, 3000)" class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">Simpan Konfigurasi</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    
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
