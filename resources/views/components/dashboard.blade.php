<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AksesPro') }} - Dashboard</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-[#0A2540] overflow-hidden" x-data="{ sidebarOpen: false, profileOpen: false }">

    <div class="flex h-screen bg-gray-50">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-[#0A2540] text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col">
            <!-- Sidebar Header -->
            <div class="flex h-20 border-b border-white/10 px-6">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('Logo.png') }}" alt="AksesPro Logo" class="h-10 w-auto flex-shrink-0 object-contain group-hover:brightness-110 transition-all duration-300" />
                </a>
            </div>

            <!-- Sidebar Menu Slot -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                {{ $sidebarMenu ?? '' }}
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white/10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/10 hover:text-white rounded-xl transition-colors w-full group">
                    <svg class="w-5 h-5 text-white/50 group-hover:text-[#00E5FF] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="font-medium">Kembali ke Beranda</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="flex items-center justify-between h-20 px-6 bg-white border-b border-gray-200 relative z-40">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="hidden sm:block relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-64 pl-10 p-2.5 transition-shadow" placeholder="Cari sesuatu...">
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-[#00E5FF]/20 text-[#0A2540] flex items-center justify-center font-bold border border-[#00E5FF]/50 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($userName ?? 'User') }}&background=0A2540&color=fff" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-800 leading-none">{{ $userName ?? 'User' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $userRole ?? 'Member' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-transition style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#0A2540]">Profil Saya</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
