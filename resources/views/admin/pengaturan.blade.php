<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6" x-data="{ activeTab: localStorage.getItem('setting_tab') || 'umum', showToast: false, toastMessage: '' }">

        <!-- Toast Notification -->
        <div x-show="showToast" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3"
            style="display: none;">
            <svg class="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="toastMessage" class="text-sm font-medium"></span>
        </div>

        <!-- Header Section -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Konfigurasi umum, pembayaran, dan preferensi aplikasi.</p>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-red-800">Harap perbaiki kesalahan input berikut:</p>
                        <ul class="list-disc list-inside text-xs text-red-700 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row min-h-[600px]">

            <!-- Tabs Navigation -->
            <div
                class="w-full md:w-64 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 p-4 sm:p-6 flex-shrink-0">
                <nav class="flex md:flex-col gap-2 overflow-x-auto hide-scrollbar pb-2 md:pb-0">
                    <button @click="activeTab = 'umum'; localStorage.setItem('setting_tab', 'umum')"
                        :class="activeTab === 'umum' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' :
                            'text-gray-500 hover:bg-gray-100 border-transparent'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Umum
                    </button>
                    <button @click="activeTab = 'pembayaran'; localStorage.setItem('setting_tab', 'pembayaran')"
                        :class="activeTab === 'pembayaran' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' :
                            'text-gray-500 hover:bg-gray-100 border-transparent'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payment Gateway
                    </button>
                    <button @click="activeTab = 'email'; localStorage.setItem('setting_tab', 'email')"
                        :class="activeTab === 'email' ? 'bg-white text-[#0A2540] shadow-sm border-gray-200' :
                            'text-gray-500 hover:bg-gray-100 border-transparent'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        SMTP Email
                    </button>
                </nav>
            </div>

            <!-- Tab Contents -->
            <div class="flex-1 p-6 sm:p-8">

                <!-- Tab: Umum -->
                <div x-show="activeTab === 'umum'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Umum</h2>

                    <form action="{{ route('admin.pengaturan.umum') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6 max-w-2xl">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                            <input type="text" name="system_name"
                                value="{{ \App\Models\Setting::get('system_name', 'AksesPro') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                            <textarea name="system_description" rows="3"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                required>{{ \App\Models\Setting::get('system_description', 'Platform Vending Machine Lisensi Digital Premium untuk Mahasiswa.') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-[#0A2540] rounded-xl flex items-center justify-center p-2 border border-gray-200">
                                    <img src="{{ \App\Models\Setting::get('logo') ? asset('uploads/' . \App\Models\Setting::get('logo')) : asset('Logo.png') }}"
                                        class="w-full h-full object-contain">
                                </div>
                                <input type="file" name="logo" id="logo-input" class="hidden"
                                    onchange="document.getElementById('logo-file-name').textContent = this.files[0].name">
                                <button type="button" onclick="document.getElementById('logo-input').click()"
                                    class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors">Pilih
                                    Logo</button>
                                <span id="logo-file-name" class="text-xs text-gray-500 font-mono"></span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-gray-100">
                            <button type="submit"
                                class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Payment Gateway -->
                <div x-show="activeTab === 'pembayaran'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Konfigurasi Payment Gateway</h2>

                    <div class="bg-[#00E5FF]/10 border border-[#00E5FF]/30 rounded-xl p-4 mb-6 flex gap-3">
                        <svg class="w-6 h-6 text-[#00b8cc] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-[#0A2540]">Saat ini menggunakan Midtrans sebagai *payment gateway*
                            utama.
                            Pastikan Environment di set ke <strong>Sandbox</strong> saat pengembangan.</p>
                    </div>

                    <form action="{{ route('admin.pengaturan.pembayaran') }}" method="POST"
                        class="space-y-6 max-w-2xl">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Midtrans Environment</label>
                            <select name="midtrans_environment"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                required>
                                <option value="sandbox"
                                    {{ \App\Models\Setting::get('midtrans_environment', 'sandbox') === 'sandbox' ? 'selected' : '' }}>
                                    Sandbox (Testing)</option>
                                <option value="production"
                                    {{ \App\Models\Setting::get('midtrans_environment') === 'production' ? 'selected' : '' }}>
                                    Production (Live)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant ID</label>
                            <input type="text" name="midtrans_merchant_id"
                                value="{{ \App\Models\Setting::get('midtrans_merchant_id', 'G45603405') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Client Key</label>
                            <input type="text" name="midtrans_client_key"
                                value="{{ \App\Models\Setting::get('midtrans_client_key', 'SB-Mid-client-xxxxxxxxxxxx') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Server Key</label>
                            <input type="text" name="midtrans_server_key"
                                value="{{ \App\Models\Setting::get('midtrans_server_key', 'SB-Mid-server-xxxxxxxxxxxx') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                required>
                        </div>
                        <div class="pt-6 border-t border-gray-100 flex gap-4">
                            <button type="submit"
                                class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm flex-1 sm:flex-none">Simpan
                                Kredensial</button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Email -->
                <div x-show="activeTab === 'email'" style="display: none;" x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Konfigurasi SMTP Email</h2>

                    <form action="{{ route('admin.pengaturan.email') }}" method="POST" class="space-y-6 max-w-2xl">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Mailer</label>
                                <input type="text" name="mail_mailer"
                                    value="{{ \App\Models\Setting::get('mail_mailer', 'smtp') }}"
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                                <input type="text" name="mail_host"
                                    value="{{ \App\Models\Setting::get('mail_host', 'smtp.gmail.com') }}"
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                    required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                                <input type="text" name="mail_port"
                                    value="{{ \App\Models\Setting::get('mail_port', '465') }}"
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mail Encryption</label>
                                <select name="mail_encryption"
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                    required>
                                    <option value="tls"
                                        {{ \App\Models\Setting::get('mail_encryption', 'ssl') === 'tls' ? 'selected' : '' }}>
                                        TLS</option>
                                    <option value="ssl"
                                        {{ \App\Models\Setting::get('mail_encryption', 'ssl') === 'ssl' ? 'selected' : '' }}>
                                        SSL</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mail Username</label>
                            <input type="email" name="mail_username"
                                value="{{ \App\Models\Setting::get('mail_username', 'adhyaksa209@gmail.com') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mail App Password</label>
                            <input type="password" name="mail_password"
                                value="{{ \App\Models\Setting::get('mail_password', 'password') }}"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                required>
                        </div>
                        <div class="pt-6 border-t border-gray-100">
                            <button type="submit"
                                class="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto">Simpan
                                Konfigurasi</button>
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
