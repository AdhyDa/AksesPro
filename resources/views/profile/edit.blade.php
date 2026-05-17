<x-dashboard>
    <x-slot name="userName">{{ $user->name }}</x-slot>
    <x-slot name="userRole">{{ ucfirst($user->role ?? 'Member') }}</x-slot>

    <!-- Sidebar Menu dynamically based on role -->
    <x-slot name="sidebarMenu">
        @if($user->role === 'admin' || $user->role === 'superadmin')
            <x-admin-sidebar />
        @else
            <x-user-sidebar />
        @endif
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-6">

        <!-- Greeting Banner -->
        <div class="bg-gradient-to-r from-slate-900 to-[#0A2540] rounded-2xl shadow-sm border border-slate-800 p-8 relative overflow-hidden flex items-center justify-between">
            <div class="absolute right-0 top-0 w-64 h-64 bg-cyan-500 rounded-full blur-3xl opacity-10 -mr-20 -mt-20"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-white mb-2">Halo, {{ $user->name }}!</h1>
                <p class="text-cyan-400 text-sm">Kelola informasi profil dan pengaturan keamanan akun Anda di sini.</p>
            </div>
            <div class="hidden sm:flex w-16 h-16 bg-white/10 rounded-2xl border border-white/20 items-center justify-center backdrop-blur-sm relative z-10">
                <svg class="w-8 h-8 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
        </div>

        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-medium text-sm">Profil berhasil diperbarui.</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Profile Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Informasi Profil</h2>
                        <p class="text-sm text-gray-500 mt-1">Perbarui nama lengkap dan alamat email akun Anda.</p>
                    </div>
                    <!-- AksesPro Exclusive: Points Badge -->
                    <div class="bg-cyan-50 border border-cyan-100 px-4 py-2 rounded-xl flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-wider leading-none mb-1">Total Poin Anda</p>
                            <p class="text-sm font-black text-slate-900 leading-none">{{ number_format($user->points ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus class="bg-slate-50 border border-gray-200 text-slate-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-3 transition-colors">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="bg-slate-50 border border-gray-200 text-slate-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-3 transition-colors">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-3 text-sm text-amber-600 bg-amber-50 p-3 rounded-lg border border-amber-100 flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <p>Email Anda belum diverifikasi.</p>
                                    <button form="send-verification" class="underline text-amber-700 hover:text-amber-900 font-semibold mt-1">Klik di sini untuk mengirim ulang email verifikasi.</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto text-sm">Simpan Perubahan</button>
                    </div>
                </form>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
                    @csrf
                </form>
            </div>

            <!-- Security Card (Password) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-900">
                        @if(is_null($user->password))
                            Set Password Akun
                        @else
                            Ubah Password
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
                </div>

                <form method="post" action="{{ route('profile.password') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    @if(!is_null($user->password))
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" required class="bg-slate-50 border border-gray-200 text-slate-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-3 transition-colors">
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password" required class="bg-slate-50 border border-gray-200 text-slate-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-3 transition-colors">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="bg-slate-50 border border-gray-200 text-slate-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-3 transition-colors">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto text-sm">
                            @if(is_null($user->password))
                                Set Password
                            @else
                                Update Password
                            @endif
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-dashboard>
