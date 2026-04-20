<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'AksesPro') }} — Langganan Premium, Harga Mahasiswa</title>
  <meta name="description" content="AksesPro adalah platform patungan langganan digital yang aman, legal, dan bergaransi. Nikmati Netflix, Canva, Spotify & 50+ aplikasi premium dengan harga yang terjangkau." />
  <meta property="og:title" content="AksesPro — Langganan Premium, Harga Mahasiswa" />
  <meta property="og:description" content="Platform patungan langganan digital yang aman, legal, dan bergaransi untuk mahasiswa dan UMKM Indonesia." />
  <meta property="og:type" content="website" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <style>
    * { box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      background-color: #ffffff;
      color: #0A2540;
      overflow-x: hidden;
    }

    /* Navbar scroll effect */
    .navbar-scrolled {
      background: rgba(10, 37, 64, 0.95) !important;
      backdrop-filter: blur(20px);
      box-shadow: 0 4px 32px rgba(0,0,0,0.3);
    }

    /* Glow effects */
    .glow-cyan {
      box-shadow: 0 0 40px rgba(0, 229, 255, 0.25), 0 0 80px rgba(0, 229, 255, 0.1);
    }
    .glow-cyan-sm {
      box-shadow: 0 0 20px rgba(0, 229, 255, 0.2);
    }
    .text-glow {
      text-shadow: 0 0 30px rgba(0, 229, 255, 0.4);
    }

    /* Gradient text */
    .gradient-text {
      background: linear-gradient(135deg, #ffffff 0%, #00E5FF 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .gradient-text-cyan {
      background: linear-gradient(135deg, #00E5FF 0%, #4DF0FF 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Blob animations */
    .blob {
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.15;
      animation: float 8s ease-in-out infinite;
    }
    .blob-2 {
      animation-delay: -3s;
    }
    .blob-3 {
      animation-delay: -5s;
    }

    /* Hero bg noise overlay */
    .hero-noise::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      opacity: 0.4;
    }

    /* Grid lines bg */
    .grid-bg {
      background-image:
        linear-gradient(rgba(0, 229, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 229, 255, 0.05) 1px, transparent 1px);
      background-size: 50px 50px;
    }

    /* Trust badge hover */
    .trust-badge {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .trust-badge:hover {
      transform: translateY(-4px) scale(1.05);
      filter: brightness(1.2);
    }

    /* Pricing card */
    .pricing-card {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }
    .pricing-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 1.5rem;
      padding: 1px;
      background: linear-gradient(135deg, rgba(0,229,255,0.3), rgba(0,229,255,0));
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .pricing-card:hover::before {
      opacity: 1;
    }
    .pricing-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 32px 64px rgba(0,0,0,0.4), 0 0 60px rgba(0,229,255,0.15);
    }
    .pricing-card.featured {
      transform: scale(1.05);
    }
    .pricing-card.featured:hover {
      transform: scale(1.05) translateY(-12px);
    }
    .pricing-card.featured::before {
      background: linear-gradient(135deg, rgba(0,229,255,0.8), rgba(0,229,255,0.2));
      opacity: 1;
    }

    /* Pillar card */
    .pillar-card {
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .pillar-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 24px 48px rgba(0,0,0,0.2), 0 0 30px rgba(0,229,255,0.08);
    }

    /* CTA button */
    .btn-primary {
      background: linear-gradient(135deg, #00E5FF, #00b8cc);
      color: #0A2540;
      font-weight: 700;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    .btn-primary::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .btn-primary:hover::after {
      opacity: 1;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px rgba(0, 229, 255, 0.5);
    }
    .btn-primary:active {
      transform: translateY(0);
    }

    /* Outline button */
    .btn-outline {
      border: 2px solid rgba(0, 229, 255, 0.4);
      color: #00E5FF;
      transition: all 0.3s ease;
    }
    .btn-outline:hover {
      border-color: #00E5FF;
      background: rgba(0, 229, 255, 0.1);
      transform: translateY(-2px);
    }

    /* Step connector */
    .step-connector {
      border-left: 2px dashed rgba(0, 229, 255, 0.3);
    }

    /* Scroll observer animation */
    .reveal {
      opacity: 0;
      transform: translateY(32px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }
    .reveal-delay-4 { transition-delay: 0.4s; }

    /* Marquee track */
    .marquee-track {
      display: flex;
      width: max-content;
      animation: marquee 28s linear infinite;
    }
    .marquee-track:hover {
      animation-play-state: paused;
    }

    /* Mobile nav */
    #mobile-menu {
      transition: all 0.3s ease;
    }

    /* Diagonal divider */
    .diagonal-divider {
      clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }
    .diagonal-divider-bottom {
      clip-path: polygon(0 15%, 100% 0, 100% 100%, 0 100%);
    }

    /* App icon badge */
    .app-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 800;
    }

    /* Pricing badge */
    .badge-popular {
      background: linear-gradient(135deg, #00E5FF, #00b8cc);
      color: #0A2540;
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.25rem 0.75rem;
      border-radius: 999px;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #0A2540; }
    ::-webkit-scrollbar-thumb { background: rgba(0,229,255,0.4); border-radius: 999px; }
    ::-webkit-scrollbar-thumb:hover { background: #00E5FF; }

    /* WhatsApp float */
    .wa-float {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 999;
      width: 56px;
      height: 56px;
      background: #25D366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 32px rgba(37, 211, 102, 0.5);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .wa-float:hover {
      transform: scale(1.1);
      box-shadow: 0 12px 40px rgba(37, 211, 102, 0.7);
    }

    /* Section label */
    .section-label {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(0, 229, 255, 0.08);
      border: 1px solid rgba(0, 229, 255, 0.2);
      border-radius: 999px;
      padding: 0.35rem 1rem;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #00E5FF;
    }

    /* Stat counter */
    .stat-item {
      text-align: center;
    }
  </style>

  <!-- Tailwind CSS & JS via Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-[#0A2540] bg-[#ffffff] overflow-x-hidden">

  @if(View::hasSection('content'))
    <!-- LANDING PAGE LAYOUT -->
    <!-- NAVBAR -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-4 px-6 lg:px-12">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="/" id="nav-logo" class="flex items-center gap-3 group">
          <img src="{{ asset('Logo.png') }}" alt="AksesPro Logo" class="h-10 w-auto flex-shrink-0 object-contain group-hover:brightness-110 transition-all duration-300" />
        </a>

        <!-- Desktop Nav Links -->
        <ul class="hidden lg:flex items-center gap-8" role="navigation" aria-label="Menu utama">
          <li><a href="#kenapa-kami" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Kenapa Kami</a></li>
          <li><a href="#produk" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Produk</a></li>
          <li><a href="#cara-kerja" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Cara Kerja</a></li>
          <li><a href="#kontak" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Kontak</a></li>
        </ul>

        <!-- CTA & Auth -->
        <div class="hidden lg:flex items-center gap-4">
          @auth
            <div class="text-white font-semibold text-sm mr-2 flex items-center gap-1">
               <span class="text-cyan-accent">Poin:</span> 150
            </div>
          @endauth

          @guest
            <a href="/login" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Login</a>
          @endguest

          @auth
            <a href="{{ route('dashboard') }}" class="text-white/70 hover:text-cyan-accent text-sm font-medium transition-colors duration-200">Dashboard</a>
          @endauth

          <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" id="nav-cta"
            class="btn-primary px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            Chat WhatsApp
          </a>
        </div>

        <!-- Hamburger -->
        <button id="hamburger" class="lg:hidden text-white p-2 rounded-lg hover:bg-white/10 transition" aria-label="Toggle menu" aria-expanded="false">
          <svg id="ham-open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          <svg id="ham-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div id="mobile-menu" class="hidden lg:hidden mt-4 pb-4 border-t border-white/10">
        <ul class="flex flex-col gap-1 pt-4 px-2">
          <li><a href="#kenapa-kami" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Kenapa Kami</a></li>
          <li><a href="#produk" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Produk</a></li>
          <li><a href="#cara-kerja" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Cara Kerja</a></li>
          <li><a href="#kontak" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Kontak</a></li>

          @guest
            <li><a href="/login" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Login</a></li>
          @endguest

          @auth
            <li>
               <div class="block text-white/80 py-2.5 px-3 rounded-lg text-sm font-medium">Saldo Poin: <span class="text-cyan-accent">150</span></div>
            </li>
            <li><a href="{{ route('dashboard') }}" class="mobile-nav-link block text-white/80 hover:text-cyan-accent py-2.5 px-3 rounded-lg hover:bg-white/5 text-sm font-medium transition-colors">Dashboard</a></li>
          @endauth

          <li class="pt-2">
            <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener"
              class="btn-primary w-full block text-center px-5 py-3 rounded-xl text-sm font-bold">
              Chat WhatsApp
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- CONTENT -->
    <main>
      @yield('content')
    </main>

    <!-- FOOTER -->
    <footer id="footer" class="bg-[#06192b] border-t border-white/5 py-12 lg:py-16">
      <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid lg:grid-cols-4 gap-10 lg:gap-12 mb-12">
          <!-- Brand col -->
          <div class="lg:col-span-2">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-4">
              <img src="{{ asset('Logo.png') }}" alt="AksesPro Logo" class="h-10 w-auto object-contain" />
            </div>

            <p class="text-white/45 text-sm leading-relaxed max-w-xs mb-6">
              Misi kami: mendemokratisasi akses teknologi premium untuk semua — mahasiswa, UMKM, dan pelaku kreatif Indonesia.
            </p>

            <!-- Mission pillars -->
            <div class="space-y-2">
              <div class="flex items-center gap-2 text-white/50 text-xs">
                <div class="w-1.5 h-1.5 rounded-full bg-cyan-accent"></div>
                <span>Sharing Economy yang bertanggung jawab</span>
              </div>
              <div class="flex items-center gap-2 text-white/50 text-xs">
                <div class="w-1.5 h-1.5 rounded-full bg-cyan-accent"></div>
                <span>Transparansi harga tanpa biaya tersembunyi</span>
              </div>
              <div class="flex items-center gap-2 text-white/50 text-xs">
                <div class="w-1.5 h-1.5 rounded-full bg-cyan-accent"></div>
                <span>Teknologi otomatis untuk pengalaman terbaik</span>
              </div>
            </div>
          </div>

          <!-- Navigation -->
          <div>
            <h3 class="text-white font-semibold text-sm uppercase tracking-widest mb-4">Navigasi</h3>
            <ul class="space-y-2.5">
              <li><a href="#hero" class="text-white/45 hover:text-cyan-accent text-sm transition-colors">Beranda</a></li>
              <li><a href="#kenapa-kami" class="text-white/45 hover:text-cyan-accent text-sm transition-colors">Kenapa Kami</a></li>
              <li><a href="#produk" class="text-white/45 hover:text-cyan-accent text-sm transition-colors">Katalog Produk</a></li>
              <li><a href="#cara-kerja" class="text-white/45 hover:text-cyan-accent text-sm transition-colors">Cara Kerja</a></li>
              <li><a href="#kontak" class="text-white/45 hover:text-cyan-accent text-sm transition-colors">Kontak</a></li>
            </ul>
          </div>

          <!-- Contact & Legal -->
          <div>
            <h3 class="text-white font-semibold text-sm uppercase tracking-widest mb-4">Kontak & Legal</h3>
            <ul class="space-y-2.5">
              <li>
                <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" class="text-white/45 hover:text-cyan-accent text-sm transition-colors flex items-center gap-2">
                  <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                  WhatsApp Customer Service
                </a>
              </li>
              <li>
                <a href="https://instagram.com/aksespro_id" target="_blank" rel="noopener" class="text-white/45 hover:text-cyan-accent text-sm transition-colors flex items-center gap-2">
                  <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                  @aksespro_id
                </a>
              </li>
              <li class="pt-2">
                <div class="h-px bg-white/8 mb-3"></div>
                <a href="#" class="text-white/25 hover:text-white/50 text-xs transition-colors">Syarat & Ketentuan</a>
              </li>
              <li><a href="#" class="text-white/25 hover:text-white/50 text-xs transition-colors">Kebijakan Privasi</a></li>
              <li><a href="#" class="text-white/25 hover:text-white/50 text-xs transition-colors">Kebijakan Pengembalian</a></li>
            </ul>
          </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-white/8 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
          <p class="text-white/25 text-xs">
            © 2024 AksesPro. Semua hak dilindungi. Dibuat dengan ♡ di Indonesia 🇮🇩
          </p>
          <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-white/25 text-xs">Sistem aktif & beroperasi</span>
          </div>
        </div>
      </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" id="wa-float-btn"
      class="wa-float" title="Chat WhatsApp" aria-label="Chat via WhatsApp">
      <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
    </a>

    <!-- JAVASCRIPT -->
    <script>
      // Navbar scroll effect
      const navbar = document.getElementById('navbar');
      if (navbar) {
        window.addEventListener('scroll', () => {
          if (window.scrollY > 60) {
            navbar.classList.add('navbar-scrolled');
          } else {
            navbar.classList.remove('navbar-scrolled');
            // On top keep transparent with subtle bg
            if (window.scrollY === 0) {
              navbar.style.background = '';
            }
          }
        });
      }

      // Mobile menu toggle
      const hamburger = document.getElementById('hamburger');
      const mobileMenu = document.getElementById('mobile-menu');
      const hamOpen = document.getElementById('ham-open');
      const hamClose = document.getElementById('ham-close');
      let menuOpen = false;

      if (hamburger) {
        hamburger.addEventListener('click', () => {
          menuOpen = !menuOpen;
          if (menuOpen) {
            mobileMenu.classList.remove('hidden');
            hamOpen.classList.add('hidden');
            hamClose.classList.remove('hidden');
            hamburger.setAttribute('aria-expanded', 'true');
          } else {
            mobileMenu.classList.add('hidden');
            hamOpen.classList.remove('hidden');
            hamClose.classList.add('hidden');
            hamburger.setAttribute('aria-expanded', 'false');
          }
        });

        // Close menu on mobile nav link click
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
          link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            hamOpen.classList.remove('hidden');
            hamClose.classList.add('hidden');
            menuOpen = false;
            hamburger.setAttribute('aria-expanded', 'false');
          });
        });
      }

      // Intersection Observer for reveal animations
      const revealEls = document.querySelectorAll('.reveal');
      if (revealEls.length > 0) {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.12,
          rootMargin: '0px 0px -40px 0px',
        });
        revealEls.forEach(el => observer.observe(el));
      }

      // Pricing card 3D tilt effect (subtle)
      document.querySelectorAll('.pricing-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
          const rect = card.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          const centerX = rect.width / 2;
          const centerY = rect.height / 2;
          const rotateX = ((y - centerY) / centerY) * -4;
          const rotateY = ((x - centerX) / centerX) * 4;
          card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px)`;
        });

        card.addEventListener('mouseleave', () => {
          if (card.classList.contains('featured')) {
            card.style.transform = 'scale(1.05)';
          } else {
            card.style.transform = '';
          }
        });
      });

      // Active nav section highlighting
      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('nav a[href^="#"]');
      if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', () => {
          let current = '';
          sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.pageYOffset >= sectionTop) {
              current = section.getAttribute('id');
            }
          });

          navLinks.forEach(link => {
            link.classList.remove('text-cyan-accent');
            link.classList.add('text-white/70');
            if (link.getAttribute('href') === `#${current}`) {
              link.classList.add('text-cyan-accent');
              link.classList.remove('text-white/70');
            }
          });
        });
      }
    </script>
  @else
    <!-- BREEZE DASHBOARD LAYOUT -->
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
  @endif

</body>
</html>
