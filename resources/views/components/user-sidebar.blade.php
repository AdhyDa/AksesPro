<a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('user.dashboard') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    <span class="font-semibold">Beranda</span>
</a>
<a href="{{ route('user.katalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('user.katalog') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
    <span class="font-medium">Katalog Produk</span>
</a>
<a href="{{ route('user.langganan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('user.langganan') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span class="font-medium">Langganan Aktif</span>
</a>
<a href="{{ route('user.transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('user.transaksi') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span class="font-medium">Riwayat Transaksi</span>
</a>
<a href="{{ route('user.poin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('user.poin') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span class="font-medium">Tukar Poin</span>
</a>
<a href="{{ route('user.bantuan') }}" class="flex items-center gap-3 px-4 py-3 mt-4 border-t border-white/10 pt-4 rounded-xl transition-colors {{ request()->routeIs('user.bantuan') ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    <span class="font-medium">Bantuan & Support</span>
</a>
