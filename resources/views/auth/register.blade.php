<x-auth-split>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="text-center mb-4" x-show="isStudentMode" style="display: none;">
            <p class="text-sm text-gray-600">Masukkan Email Mahasiswa Anda!</p>
        </div>

        <!-- Name -->
        <div>
            <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3" type="email" name="email" :value="old('email')" required autocomplete="username" 
                x-bind:placeholder="isStudentMode ? 'nama@student.um.ac.id' : 'Masukkan Email'" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#1A3147] hover:bg-[#112233] text-white font-semibold rounded-lg py-3 px-4 transition duration-200">
                <span x-text="isStudentMode ? 'Lanjutkan dengan Akun Mahasiswa' : 'Daftar dengan Email'"></span>
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-500" x-show="isStudentMode" style="display: none;">
                Gunakan email instansi (.ac.id) untuk mendapatkan benefit poin tambahan.
            </p>
            <p class="text-sm text-gray-600 mt-4">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-[#1A3147] hover:underline">Masuk</a>
            </p>
        </div>
    </form>
</x-auth-split>
