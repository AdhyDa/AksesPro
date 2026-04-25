<x-auth-split>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="text-center mb-4" x-show="isStudentMode" style="display: none;">
            <p class="text-sm text-gray-600">Masukkan Email Mahasiswa Anda!</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                x-bind:placeholder="isStudentMode ? 'nama@student.um.ac.id' : 'Masukkan Email'" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1A3147] shadow-sm focus:ring-[#1A3147]" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1A3147]" href="{{ route('password.request') }}">
                    {{ __('Lupa sandi?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#1A3147] hover:bg-[#112233] text-white font-semibold rounded-lg py-3 px-4 transition duration-200">
                <span x-text="isStudentMode ? 'Lanjutkan dengan Akun Mahasiswa' : 'Lanjutkan dengan Email'"></span>
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-500" x-show="isStudentMode" style="display: none;">
                Gunakan email instansi (.ac.id) untuk mendapatkan benefit poin tambahan.
            </p>
            <p class="text-sm text-gray-600 mt-4">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-[#1A3147] hover:underline">Daftar</a>
            </p>
        </div>
    </form>
</x-auth-split>
