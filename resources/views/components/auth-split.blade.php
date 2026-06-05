<x-guest-layout>
    <div class="min-h-screen flex" x-data="{ isStudentMode: false }">
        <!-- Left Side: Hero / Promo -->
        <div class="hidden lg:flex w-1/2 bg-[#1A3147] flex-col justify-center items-center relative overflow-hidden" style="background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 30px 30px;">
            <div class="relative z-10 text-center">
                <img src="{{ asset('image/mockup.png') }}" alt="AksesPro Preview" class="w-full max-w-md mx-auto drop-shadow-2xl mb-8 transform transition hover:scale-105 duration-500">
                <h1 class="text-4xl font-bold text-white mb-4 leading-tight">Akses Premium<br>Harga Mahasiswa</h1>
                <p class="text-blue-200 text-lg">One access to all your professional tools.</p>
            </div>
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#112233] to-transparent opacity-80 pointer-events-none"></div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white px-6 py-12 sm:px-12">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <img src="{{ asset('image/Logo.png') }}" alt="AksesPro Logo" class="h-12 mx-auto mb-6" onerror="this.outerHTML='<div class=\'text-3xl font-extrabold text-blue-600 mb-6\'>AksesPro</div>'">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang di AksesPro!</h2>
                    <p class="text-gray-500">Masuk atau daftar untuk mulai berhemat hari ini.</p>
                </div>

                <!-- SSO Buttons -->
                <div class="space-y-4 mb-8">
                    <!-- Google SSO -->
                    <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 rounded-full py-3 px-4 text-gray-700 font-semibold hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            <path d="M1 1h22v22H1z" fill="none"/>
                        </svg>
                        Continue with Google
                    </a>

                    <!-- Student Account -->
                    <button type="button" @click="isStudentMode = !isStudentMode" 
                        :class="isStudentMode ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-300 bg-white hover:bg-gray-50'"
                        class="w-full flex flex-col items-center justify-center gap-1 border rounded-full py-2 px-4 text-gray-700 font-semibold transition shadow-sm">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-colors" :class="isStudentMode ? 'text-blue-600' : 'text-gray-700'">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                            <span :class="isStudentMode ? 'text-blue-600' : ''">Continue with Student Account</span>
                        </div>
                        <span class="text-[10px]" :class="isStudentMode ? 'text-blue-500' : 'text-gray-400'">Dapatkan bonus +100 poin</span>
                    </button>
                </div>

                <div class="relative flex items-center py-5 mb-4">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-400 text-sm">atau</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</x-guest-layout>
