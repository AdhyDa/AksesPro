@extends('layouts.app')
@section('content')
  <!-- ============================================================
      HERO SECTION
  ============================================================ -->
  <section id="hero" class="relative min-h-screen bg-hero-gradient flex items-center overflow-hidden hero-noise grid-bg">

    <!-- Animated blobs -->
    <div class="blob absolute -top-32 -left-32 w-96 h-96 bg-cyan-accent"></div>
    <div class="blob blob-2 absolute top-1/2 -right-48 w-[500px] h-[500px] bg-blue-400"></div>
    <div class="blob blob-3 absolute bottom-0 left-1/3 w-72 h-72 bg-cyan-accent"></div>

    <!-- Decorative circle glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-cyan-glow pointer-events-none" style="background: radial-gradient(ellipse, rgba(0,229,255,0.07) 0%, transparent 70%);"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 py-32 lg:py-0 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

      <!-- Left: Copy -->
      <div class="text-center lg:text-left">
        <!-- Headline -->
        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-[1.08] tracking-tight text-white mb-6 pt-14">
          Kerja Pro,<br />
          Nonton Nyaman,<br />
          <span class="gradient-text">Harga Mahasiswa.</span>
        </h1>

        <!-- Sub-headline -->
        <p class="text-white/65 text-lg lg:text-xl leading-relaxed max-w-lg mx-auto lg:mx-0 mb-10">
          Hentikan pemborosan biaya langganan. Bergabung dengan sistem patungan yang
          <strong class="text-white/90 font-semibold">aman, legal & bergaransi</strong> —
          hemat hingga <strong class="text-cyan-accent font-semibold">80%</strong> dari harga resmi.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-6">
          <a href="#produk" id="hero-cta-primary"
            class="btn-primary px-8 py-4 rounded-2xl text-base font-bold inline-flex items-center justify-center gap-2.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Lihat Katalog
          </a>
          <a href="#cara-kerja" id="hero-cta-secondary"
            class="btn-outline px-8 py-4 rounded-2xl text-base font-semibold inline-flex items-center justify-center gap-2.5">
            Cara Kerjanya
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </a>
        </div>

        <!-- Stats Row -->
        <div class="flex items-center justify-center lg:justify-start gap-3 sm:gap-4 pb-6">
          <div class="text-center rounded-2xl px-5 py-3" style="background: rgba(10,37,64,0.65); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);">
            <div class="text-2xl font-bold text-white">500+</div>
            <div class="text-white/70 text-xs mt-0.5">Pelanggan Aktif</div>
          </div>
          <div class="text-center rounded-2xl px-5 py-3" style="background: rgba(10,37,64,0.65); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15);">
            <div class="text-2xl font-bold text-white">50+</div>
            <div class="text-white/70 text-xs mt-0.5">Aplikasi Premium</div>
          </div>
          <div class="text-center rounded-2xl px-5 py-3" style="background: rgba(0,229,255,0.12); backdrop-filter: blur(12px); border: 1px solid rgba(0,229,255,0.3);">
            <div class="text-2xl font-bold text-cyan-accent">80%</div>
            <div class="text-white/70 text-xs mt-0.5">Lebih Hemat</div>
          </div>
        </div>
      </div>

      <!-- Right: Hero visual — Maskot -->
      <div class="hidden lg:flex items-center justify-center relative">
        <!-- Decorative glow rings -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
          <div class="w-80 h-80 rounded-full border border-cyan-accent/15 animate-ping" style="animation-duration: 3.5s;"></div>
        </div>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
          <div class="w-64 h-64 rounded-full border border-cyan-accent/25"></div>
        </div>
        <!-- Glow blob behind mascot -->
        <div class="absolute w-72 h-72 rounded-full pointer-events-none" style="background: radial-gradient(ellipse, rgba(0,229,255,0.12) 0%, transparent 70%);"></div>

        <!-- Maskot container -->
        <div class="relative animate-float z-10">
          <img
            src="{{ asset('Maskot.png') }}"
            alt="AksesPro Maskot — Karakter kunci gembok yang profesional dan ramah"
            class="w-80 h-auto object-contain drop-shadow-2xl"
            style="filter: drop-shadow(0 0 32px rgba(0,229,255,0.25)) drop-shadow(0 20px 40px rgba(0,0,0,0.5));"
          />

          <!-- Floating badge ⚡ Instan -->
          <div class="absolute top-6 -right-4 bg-cyan-accent font-bold text-xs px-3 py-1.5 rounded-full shadow-lg animate-float" style="color:#0A2540; animation-delay: -1s;">
            ⚡ Instan
          </div>

          <!-- Floating notification card -->
          <div class="absolute -bottom-4 -left-8 bg-navy-800/90 backdrop-blur-xl border border-white/10 rounded-2xl p-3 flex items-center gap-3 animate-float" style="animation-delay: -2s; background: rgba(13,46,89,0.92);">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-sm flex-shrink-0">✓</div>
            <div>
              <div class="text-white text-xs font-semibold">Pembayaran Diterima</div>
              <div class="text-white/45 text-xs">Login dikirim otomatis</div>
            </div>
          </div>

          <!-- Floating savings badge -->
          <div class="absolute top-1/2 -left-10 -translate-y-1/2 bg-[#0A2540]/90 backdrop-blur-xl border border-cyan-accent/20 rounded-2xl p-3 animate-float" style="animation-delay: -3s;">
            <div class="text-white/40 text-xs mb-0.5">Hemat hingga</div>
            <div class="text-cyan-accent font-bold text-lg leading-none">80%</div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================================
      TRUST BADGES / SOCIAL PROOF
  ============================================================ -->
  <section id="trust" class="bg-white py-16 lg:py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="text-center mb-10 reveal">
        <p class="text-navy/40 text-sm font-semibold uppercase tracking-widest mb-3">Platform yang kami dukung</p>
        <h2 class="text-2xl lg:text-3xl font-bold text-navy">50+ Aplikasi Premium Tersedia</h2>
      </div>

      <!-- Marquee wrapper -->
      <div class="overflow-hidden relative">
        <!-- Fade edges -->
        <div class="absolute left-0 top-0 bottom-0 w-20 z-10 pointer-events-none" style="background: linear-gradient(to right, white, transparent);"></div>
        <div class="absolute right-0 top-0 bottom-0 w-20 z-10 pointer-events-none" style="background: linear-gradient(to left, white, transparent);"></div>

        <div class="marquee-track gap-6 py-4 reveal">
          <!-- Set 1 -->
          <div class="flex gap-6 items-center">
            <!-- Netflix -->
            <div class="trust-badge flex items-center gap-3 bg-[#141414] rounded-2xl px-6 py-4 min-w-max shadow-md">
              <div class="text-red-600 font-black text-2xl leading-none" style="font-family: 'Arial Black', sans-serif; letter-spacing:-1px;">NETFLIX</div>
            </div>
            <!-- Spotify -->
            <div class="trust-badge flex items-center gap-3 bg-[#1DB954]/10 border border-[#1DB954]/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-[#1DB954]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
              <span class="text-[#1DB954] font-bold text-sm">Spotify</span>
            </div>
            <!-- Canva -->
            <div class="trust-badge flex items-center gap-3 bg-[#7C3AED]/10 border border-[#7C3AED]/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#7C3AED"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-.459 17.564c-1.098 0-2.025-.384-2.781-1.152-.756-.768-1.134-1.739-1.134-2.913 0-1.188.384-2.163 1.152-2.925.768-.762 1.749-1.143 2.943-1.143 1.056 0 1.959.309 2.709.927l-.756 1.107c-.576-.468-1.179-.702-1.809-.702-.72 0-1.32.258-1.8.774-.48.516-.72 1.161-.72 1.935 0 .786.243 1.437.729 1.953.486.516 1.095.774 1.827.774.558 0 1.176-.189 1.854-.567v-1.296h-1.512v-1.269h2.952v3.213c-.918.723-1.908 1.284-2.654 1.284z"/></svg>
              <span class="text-[#7C3AED] font-bold text-sm">Canva Pro</span>
            </div>
            <!-- Zoom -->
            <div class="trust-badge flex items-center gap-3 bg-blue-500/10 border border-blue-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zM5.999 8.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5h8a.5.5 0 00.5-.5V9a.5.5 0 00-.5-.5H6zm2.751 0v7h5.25V8.5h-5.25zm7.5 1.5a.25.25 0 00-.25.25v4a.25.25 0 00.384.211l2.999-2a.25.25 0 000-.422l-2.999-2a.25.25 0 00-.134-.039z"/></svg>
              <span class="text-blue-500 font-bold text-sm">Zoom Pro</span>
            </div>
            <!-- ChatGPT -->
            <div class="trust-badge flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"><path d="M22.282 9.821a5.985 5.985 0 00-.516-4.91 6.046 6.046 0 00-6.51-2.9A6.065 6.065 0 004.981 4.18a5.985 5.985 0 00-3.998 2.9 6.046 6.046 0 00.743 7.097 5.98 5.98 0 00.51 4.911 6.051 6.051 0 006.515 2.9A5.985 5.985 0 0013.26 24a6.056 6.056 0 005.772-4.206 5.99 5.99 0 003.997-2.9 6.056 6.056 0 00-.747-7.073zM13.26 22.43a4.476 4.476 0 01-2.876-1.04l.141-.081 4.779-2.758a.795.795 0 00.392-.681v-6.737l2.02 1.168a.071.071 0 01.038.052v5.583a4.504 4.504 0 01-4.494 4.494zM3.6 18.304a4.47 4.47 0 01-.535-3.014l.142.085 4.783 2.759a.771.771 0 00.78 0l5.843-3.369v2.332a.08.08 0 01-.033.062L9.74 19.95a4.5 4.5 0 01-6.14-1.646zM2.34 7.896a4.485 4.485 0 012.366-1.973V11.6a.766.766 0 00.388.676l5.815 3.355-2.02 1.168a.076.076 0 01-.071 0L4.06 13.6a4.501 4.501 0 01-1.72-5.704zm16.597 3.855l-5.833-3.387L15.119 7.2a.076.076 0 01.071 0l4.766 2.756a4.501 4.501 0 01-.692 8.12v-5.678a.79.79 0 00-.387-.647zm2.01-3.023l-.141-.085-4.774-2.782a.776.776 0 00-.785 0L9.409 9.23V6.897a.066.066 0 01.028-.061l4.766-2.752a4.5 4.5 0 016.693 4.66zm-12.64 4.135l-2.02-1.164a.08.08 0 01-.038-.057V6.075a4.5 4.5 0 017.375-3.453l-.142.08-4.778 2.758a.795.795 0 00-.393.681l-.004 6.737zm1.097-2.365l2.602-1.5 2.607 1.5v2.999l-2.597 1.5-2.607-1.5-.005-2.999z"/></svg>
              <span class="text-emerald-500 font-bold text-sm">ChatGPT Plus</span>
            </div>
            <!-- YouTube Premium -->
            <div class="trust-badge flex items-center gap-3 bg-red-500/10 border border-red-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              <span class="text-red-500 font-bold text-sm">YouTube Premium</span>
            </div>
            <!-- Grammarly -->
            <div class="trust-badge flex items-center gap-3 bg-green-600/10 border border-green-600/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm0 4.714a7.286 7.286 0 110 14.572A7.286 7.286 0 0112 4.714zm-1.143 3.429v3.857h4.572v1.714h-4.572v.858h5.143v1.714H9.143v-8.143h1.714z"/></svg>
              <span class="text-green-600 font-bold text-sm">Grammarly</span>
            </div>
            <!-- Adobe -->
            <div class="trust-badge flex items-center gap-3 bg-red-600/10 border border-red-600/30 rounded-2xl px-6 py-4 min-w-max">
              <span class="text-red-600 font-black text-lg" style="font-family: 'Arial Black';">Ai</span>
              <span class="text-red-600 font-bold text-sm">Adobe CC</span>
            </div>
          </div>

          <!-- Set 2 (duplicate for seamless loop) -->
          <div class="flex gap-6 items-center" aria-hidden="true">
            <div class="trust-badge flex items-center gap-3 bg-[#141414] rounded-2xl px-6 py-4 min-w-max shadow-md">
              <div class="text-red-600 font-black text-2xl leading-none" style="font-family: 'Arial Black', sans-serif; letter-spacing:-1px;">NETFLIX</div>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-[#1DB954]/10 border border-[#1DB954]/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-[#1DB954]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
              <span class="text-[#1DB954] font-bold text-sm">Spotify</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-[#7C3AED]/10 border border-[#7C3AED]/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#7C3AED"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-.459 17.564c-1.098 0-2.025-.384-2.781-1.152-.756-.768-1.134-1.739-1.134-2.913 0-1.188.384-2.163 1.152-2.925.768-.762 1.749-1.143 2.943-1.143 1.056 0 1.959.309 2.709.927l-.756 1.107c-.576-.468-1.179-.702-1.809-.702-.72 0-1.32.258-1.8.774-.48.516-.72 1.161-.72 1.935 0 .786.243 1.437.729 1.953.486.516 1.095.774 1.827.774.558 0 1.176-.189 1.854-.567v-1.296h-1.512v-1.269h2.952v3.213c-.918.723-1.908 1.284-2.654 1.284z"/></svg>
              <span class="text-[#7C3AED] font-bold text-sm">Canva Pro</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-blue-500/10 border border-blue-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12c0 6.627-5.373 12-12 12S0 18.627 0 12 5.373 0 12 0s12 5.373 12 12zM5.999 8.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5h8a.5.5 0 00.5-.5V9a.5.5 0 00-.5-.5H6zm2.751 0v7h5.25V8.5h-5.25zm7.5 1.5a.25.25 0 00-.25.25v4a.25.25 0 00.384.211l2.999-2a.25.25 0 000-.422l-2.999-2a.25.25 0 00-.134-.039z"/></svg>
              <span class="text-blue-500 font-bold text-sm">Zoom Pro</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"><path d="M22.282 9.821a5.985 5.985 0 00-.516-4.91 6.046 6.046 0 00-6.51-2.9A6.065 6.065 0 004.981 4.18a5.985 5.985 0 00-3.998 2.9 6.046 6.046 0 00.743 7.097 5.98 5.98 0 00.51 4.911 6.051 6.051 0 006.515 2.9A5.985 5.985 0 0013.26 24a6.056 6.056 0 005.772-4.206 5.99 5.99 0 003.997-2.9 6.056 6.056 0 00-.747-7.073zM13.26 22.43a4.476 4.476 0 01-2.876-1.04l.141-.081 4.779-2.758a.795.795 0 00.392-.681v-6.737l2.02 1.168a.071.071 0 01.038.052v5.583a4.504 4.504 0 01-4.494 4.494zM3.6 18.304a4.47 4.47 0 01-.535-3.014l.142.085 4.783 2.759a.771.771 0 00.78 0l5.843-3.369v2.332a.08.08 0 01-.033.062L9.74 19.95a4.5 4.5 0 01-6.14-1.646zM2.34 7.896a4.485 4.485 0 012.366-1.973V11.6a.766.766 0 00.388.676l5.815 3.355-2.02 1.168a.076.076 0 01-.071 0L4.06 13.6a4.501 4.501 0 01-1.72-5.704zm16.597 3.855l-5.833-3.387L15.119 7.2a.076.076 0 01.071 0l4.766 2.756a4.501 4.501 0 01-.692 8.12v-5.678a.79.79 0 00-.387-.647zm2.01-3.023l-.141-.085-4.774-2.782a.776.776 0 00-.785 0L9.409 9.23V6.897a.066.066 0 01.028-.061l4.766-2.752a4.5 4.5 0 016.693 4.66zm-12.64 4.135l-2.02-1.164a.08.08 0 01-.038-.057V6.075a4.5 4.5 0 017.375-3.453l-.142.08-4.778 2.758a.795.795 0 00-.393.681l-.004 6.737zm1.097-2.365l2.602-1.5 2.607 1.5v2.999l-2.597 1.5-2.607-1.5-.005-2.999z"/></svg>
              <span class="text-emerald-500 font-bold text-sm">ChatGPT Plus</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-red-500/10 border border-red-500/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              <span class="text-red-500 font-bold text-sm">YouTube Premium</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-green-600/10 border border-green-600/30 rounded-2xl px-6 py-4 min-w-max">
              <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm0 4.714a7.286 7.286 0 110 14.572A7.286 7.286 0 0112 4.714zm-1.143 3.429v3.857h4.572v1.714h-4.572v.858h5.143v1.714H9.143v-8.143h1.714z"/></svg>
              <span class="text-green-600 font-bold text-sm">Grammarly</span>
            </div>
            <div class="trust-badge flex items-center gap-3 bg-red-600/10 border border-red-600/30 rounded-2xl px-6 py-4 min-w-max">
              <span class="text-red-600 font-black text-lg" style="font-family: 'Arial Black';">Ai</span>
              <span class="text-red-600 font-bold text-sm">Adobe CC</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================================
      WHY US — 3 PILLARS
  ============================================================ -->
  <section id="kenapa-kami" class="bg-[#F8F9FA] py-20 lg:py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

      <div class="text-center mb-16 reveal">
        <div class="section-label text-navy mb-4" style="background: rgba(10,37,64,0.07); border-color: rgba(10,37,64,0.15);">
          <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          Kenapa AksesPro?
        </div>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-navy leading-tight mb-4">
          Tiga Pilar yang Membuat<br class="hidden sm:block" />
          <span class="gradient-text-cyan">Kami Berbeda</span>
        </h2>
        <p class="text-navy/55 text-lg max-w-2xl mx-auto">
          Kami bukan sekadar penjual akun. Kami adalah platform teknologi yang membangun ekosistem berlangganan yang bertanggung jawab.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-6 lg:gap-8">

        <!-- Pillar 1: Transaksi Otomatis -->
        <div class="pillar-card reveal reveal-delay-1 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative overflow-hidden">
          <!-- Accent corner -->
          <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-cyan-accent/5"></div>

          <!-- Icon -->
          <div class="w-14 h-14 rounded-2xl bg-[#0A2540] flex items-center justify-center mb-6 shadow-lg">
            <svg class="w-7 h-7 text-cyan-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>

          <!-- Number -->
          <div class="text-cyan-accent/20 font-black text-7xl absolute top-6 right-8 leading-none select-none">01</div>

          <h3 class="text-xl font-bold text-navy mb-3">Transaksi Otomatis</h3>
          <p class="text-navy/55 leading-relaxed text-sm">
            Bayar via QRIS atau e-wallet — detail login langsung terkirim ke emailmu dalam hitungan detik. <strong class="text-navy/80">Tanpa nunggu admin balas chat</strong>, 24 jam sehari, 7 hari seminggu.
          </p>

          <!-- Feature pills -->
          <div class="flex flex-wrap gap-2 mt-6">
            <span class="text-xs bg-cyan-accent/10 text-cyan-accent border border-cyan-accent/20 rounded-full px-3 py-1 font-medium">⚡ QRIS</span>
            <span class="text-xs bg-cyan-accent/10 text-cyan-accent border border-cyan-accent/20 rounded-full px-3 py-1 font-medium">⚡ E-Wallet</span>
            <span class="text-xs bg-cyan-accent/10 text-cyan-accent border border-cyan-accent/20 rounded-full px-3 py-1 font-medium">⚡ Instan</span>
          </div>
        </div>

        <!-- Pillar 2: Garansi Penuh (featured) -->
        <div class="pillar-card reveal reveal-delay-2 bg-[#0A2540] rounded-3xl p-8 relative overflow-hidden shadow-2xl" style="box-shadow: 0 20px 60px rgba(10,37,64,0.3), 0 0 40px rgba(0,229,255,0.1);">
          <!-- Glow overlay -->
          <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 70% 20%, rgba(0,229,255,0.08) 0%, transparent 60%);"></div>

          <!-- Icon -->
          <div class="w-14 h-14 rounded-2xl bg-cyan-accent/20 flex items-center justify-center mb-6 border border-cyan-accent/30">
            <svg class="w-7 h-7 text-cyan-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>

          <!-- Number -->
          <div class="text-white/5 font-black text-7xl absolute top-6 right-8 leading-none select-none">02</div>

          <!-- Label -->
          <div class="badge-popular inline-flex mb-3">● Andalan kami</div>

          <h3 class="text-xl font-bold text-white mb-3">Garansi Penuh</h3>
          <p class="text-white/60 leading-relaxed text-sm">
            Akun bermasalah di tengah masa berlangganan? <strong class="text-white/90">Kami ganti baru tanpa biaya tambahan</strong>. Bebas khawatir, tidur tenang.
          </p>

          <!-- Feature pills -->
          <div class="flex flex-wrap gap-2 mt-6">
            <span class="text-xs bg-white/10 text-white/80 border border-white/20 rounded-full px-3 py-1 font-medium">🛡 Ganti Akun</span>
            <span class="text-xs bg-white/10 text-white/80 border border-white/20 rounded-full px-3 py-1 font-medium">🛡 Tanpa Biaya</span>
            <span class="text-xs bg-white/10 text-white/80 border border-white/20 rounded-full px-3 py-1 font-medium">🛡 Full Periode</span>
          </div>
        </div>

        <!-- Pillar 3: Harga Mahasiswa -->
        <div class="pillar-card reveal reveal-delay-3 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative overflow-hidden">
          <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-[#0A2540]/5"></div>

          <!-- Icon -->
          <div class="w-14 h-14 rounded-2xl bg-[#0A2540] flex items-center justify-center mb-6 shadow-lg">
            <svg class="w-7 h-7 text-cyan-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>

          <!-- Number -->
          <div class="text-navy/5 font-black text-7xl absolute top-6 right-8 leading-none select-none">03</div>

          <h3 class="text-xl font-bold text-navy mb-3">Harga Senada Dompet</h3>
          <p class="text-navy/55 leading-relaxed text-sm">
            Tanpa biaya tersembunyi. Patungan resmi, legalitas terjaga. Hemat hingga <strong class="text-navy/80">80% dari harga resmi</strong> — dompet tetap aman, produktivitas tetap maksimal.
          </p>

          <!-- Feature pills -->
          <div class="flex flex-wrap gap-2 mt-6">
            <span class="text-xs bg-[#0A2540]/5 text-[#0A2540]/70 border border-navy/10 rounded-full px-3 py-1 font-medium">💰 Transparan</span>
            <span class="text-xs bg-[#0A2540]/5 text-[#0A2540]/70 border border-navy/10 rounded-full px-3 py-1 font-medium">💰 Legal</span>
            <span class="text-xs bg-[#0A2540]/5 text-[#0A2540]/70 border border-navy/10 rounded-full px-3 py-1 font-medium">💰 Hemat 80%</span>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================================
      PRODUCT SHOWCASE / PRICING CARDS
  ============================================================ -->
  <section id="produk" class="bg-[#0A2540] py-20 lg:py-28 relative overflow-hidden">

    <!-- Background effects -->
    <div class="blob absolute -top-32 -left-16 w-72 h-72 bg-cyan-accent opacity-10"></div>
    <div class="blob blob-2 absolute -bottom-32 -right-16 w-72 h-72 bg-blue-400 opacity-10"></div>
    <div class="grid-bg absolute inset-0 pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12">

      <div class="text-center mb-16 reveal">
        <div class="section-label mb-4">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          Katalog Produk
        </div>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
          Pilih Langganan<br class="hidden sm:block" />
          <span class="gradient-text">Premium Favoritmu</span>
        </h2>
        <p class="text-white/50 text-lg max-w-2xl mx-auto">
          Semua harga sudah termasuk layanan pelanggan penuh & garansi. Tidak ada biaya kejutan.
        </p>
      </div>

      <!-- Pricing Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
        <x-product-card 
          delay="1"
          bgClasses="bg-gradient-to-br from-navy-800 to-navy"
          bgStyle="background: linear-gradient(135deg, #0d2e59 0%, #0A2540 100%);"
          iconBg="background: linear-gradient(135deg, #7c3aed, #a855f7);"
          title="Canva Pro"
          subtitle="Design & Kreativitas"
          badgeText="PRO"
          badgeClasses="bg-purple-500/20 text-purple-400 border border-purple-500/30"
          :features="['Semua template premium (+ 610K+)', 'Background Remover & Magic Resize', 'Brand Kit & Logo personalisation', '100 GB cloud storage']"
          featureIconBg="bg-purple-500/20"
          featureIconColor="text-purple-400"
          priceOriginal="Rp 120.000"
          priceDiscounted="Rp 19.000"
          discountPercent="84%"
          discountClasses="bg-emerald-500/15 text-emerald-400 border border-emerald-500/25"
          buyUrl="https://api.whatsapp.com/send/?phone=62895396048445&text=Halo, saya mau beli Canva Pro"
          buyBtnClasses="btn-primary"
        >
          <x-slot:icon>
            <img src="{{ asset('image/canva.jpg') }}" alt="Canva Pro" class="w-full h-full object-cover rounded-2xl" />
          </x-slot:icon>
        </x-product-card>

        <x-product-card 
          delay="2"
          :isFeatured="true"
          bgClasses=""
          bgStyle="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 100%); box-shadow: 0 32px 60px rgba(0,0,0,0.5), 0 0 60px rgba(0,229,255,0.15);"
          iconBg="background: #1DB954;"
          title="Spotify Premium"
          subtitle="Musik & Podcast"
          badgeText="PREMIUM"
          badgeClasses="bg-[#1DB954]/20 text-[#1DB954] border border-[#1DB954]/40"
          :features="['80+ juta lagu tanpa iklan', 'Download & putar offline', 'Kualitas audio HD (320 kbps)', 'Podcast premium eksklusif']"
          featureIconBg="bg-[#1DB954]/20"
          featureIconColor="text-[#1DB954]"
          priceOriginal="Rp 54.990"
          priceDiscounted="Rp 10.000"
          priceDiscountedClasses="text-cyan-accent text-glow"
          discountPercent="81%"
          discountClasses="bg-cyan-accent/10 text-cyan-accent border border-cyan-accent/30 glow-cyan-sm"
          buyUrl="https://api.whatsapp.com/send/?phone=62895396048445&text=Halo, saya mau beli Spotify Premium"
          buyBtnClasses="btn-primary glow-cyan"
        >
          <x-slot:icon>
            <img src="{{ asset('image/spotify.jpg') }}" alt="Spotify Premium" class="w-full h-full object-cover rounded-2xl" />
          </x-slot:icon>
        </x-product-card>

        <x-product-card 
          delay="3"
          bgClasses="bg-gradient-to-br"
          bgStyle="background: linear-gradient(135deg, #1a0000 0%, #2d0000 50%, #1a0000 100%);"
          iconBg="background: #E50914;"
          title="Netflix Premium"
          subtitle="Streaming & Hiburan"
          badgeText="4K UHD"
          badgeClasses="bg-red-500/20 text-red-400 border border-red-500/30"
          :features="['Streaming 4K Ultra HD + HDR', 'Akses semua film & series terbaru', 'Download konten untuk offline', 'Profil pribadi (privacy terjaga)']"
          featureIconBg="bg-red-500/20"
          featureIconColor="text-red-400"
          priceOriginal="Rp 186.000"
          priceDiscounted="Rp 29.000"
          discountPercent="84%"
          discountClasses="bg-red-500/15 text-red-400 border border-red-500/25"
          buyUrl="https://api.whatsapp.com/send/?phone=62895396048445&text=Halo, saya mau beli Netflix Premium"
          buyBtnClasses="bg-red-600 hover:bg-red-500 text-white transition-all duration-300 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-0.5"
        >
          <x-slot:icon>
            <img src="{{ asset('image/netflix.jpg') }}" alt="Netflix Premium" class="w-full h-full object-cover rounded-2xl" />
          </x-slot:icon>
          <x-slot:bgGlow>
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at bottom left, rgba(220,38,38,0.1) 0%, transparent 60%);"></div>
          </x-slot:bgGlow>
        </x-product-card>
      </div>
      <!-- Bottom CTA banner -->
      <div class="reveal mt-12 text-center">
        <p class="text-white/40 text-sm mb-4">Butuh aplikasi lain? Kami punya 50+ pilihan.</p>
        <a href="https://api.whatsapp.com/send/?phone=62895396048445&text=Halo, saya mau lihat katalog lengkap AksesPro" target="_blank" rel="noopener" id="catalog-all"
          class="btn-outline px-8 py-3 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
          Lihat Katalog Lengkap
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
      </div>
    </div>
  </section>


  <!-- ============================================================
      HOW IT WORKS
  ============================================================ -->
  <section id="cara-kerja" class="bg-[#F8F9FA] py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

      <div class="text-center mb-16 reveal">
        <div class="section-label text-navy mb-4" style="background: rgba(10,37,64,0.07); border-color: rgba(10,37,64,0.15);">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Cara Kerja
        </div>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-navy leading-tight mb-4">
          Mulai dalam <span class="gradient-text-cyan">3 Langkah</span>
        </h2>
        <p class="text-navy/55 text-lg max-w-xl mx-auto">
          Prosesnya sesederhana pesan makanan online. Tidak ada formulir rumit, tidak ada verifikasi berhari-hari.
        </p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8 lg:gap-12 relative">
        <!-- Connecting line (desktop) -->
        <div class="hidden lg:block absolute top-16 left-[calc(33.3%+1rem)] right-[calc(33.3%+1rem)] h-px border-t-2 border-dashed border-navy/15"></div>

        <!-- Step 1 -->
        <div class="reveal reveal-delay-1 text-center group">
          <div class="relative inline-flex mb-6">
            <div class="w-20 h-20 rounded-full bg-[#0A2540] text-white font-bold text-2xl flex items-center justify-center shadow-xl group-hover:scale-105 transition-transform duration-300 mx-auto" style="box-shadow: 0 12px 40px rgba(10,37,64,0.3);">
              01
            </div>
            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-cyan-accent flex items-center justify-center">
              <svg class="w-3 h-3 text-navy font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
          </div>
          <h3 class="text-xl font-bold text-navy mb-3">Pilih Paket</h3>
          <p class="text-navy/55 text-sm leading-relaxed max-w-xs mx-auto">
            Cari aplikasi premium yang kamu butuhkan dari katalog kami yang terus diperbarui. Pilih durasi berlangganan sesuai kebutuhan.
          </p>
        </div>

        <!-- Step 2 -->
        <div class="reveal reveal-delay-2 text-center group">
          <div class="relative inline-flex mb-6">
            <div class="w-20 h-20 rounded-full bg-[#0A2540] text-white font-bold text-2xl flex items-center justify-center shadow-xl group-hover:scale-105 transition-transform duration-300 mx-auto" style="box-shadow: 0 12px 40px rgba(10,37,64,0.3);">
              02
            </div>
            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-cyan-accent flex items-center justify-center">
              <svg class="w-3 h-3 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
          </div>
          <h3 class="text-xl font-bold text-navy mb-3">Bayar & Konfirmasi</h3>
          <p class="text-navy/55 text-sm leading-relaxed max-w-xs mx-auto">
            Gunakan QRIS atau e-wallet (GoPay, OVO, Dana, ShopeePay). Konfirmasi otomatis dalam hitungan detik setelah pembayaran terverifikasi.
          </p>
        </div>

        <!-- Step 3 -->
        <div class="reveal reveal-delay-3 text-center group">
          <div class="relative inline-flex mb-6">
            <div class="w-20 h-20 rounded-full bg-[#0A2540] text-white font-bold text-2xl flex items-center justify-center shadow-xl group-hover:scale-105 transition-transform duration-300 mx-auto" style="box-shadow: 0 12px 40px rgba(10,37,64,0.3);">
              03
            </div>
            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-cyan-accent flex items-center justify-center">
              <svg class="w-3 h-3 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
          </div>
          <h3 class="text-xl font-bold text-navy mb-3">Enjoy The Pro!</h3>
          <p class="text-navy/55 text-sm leading-relaxed max-w-xs mx-auto">
            Cek email atau dashboard untuk detail login dan langsung nikmati semua fitur premiumnya. Welcome to the Pro club! 🎉
          </p>
        </div>
      </div>

      <!-- CTA -->
      <div class="reveal mt-16 text-center">
        <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" id="cta-how"
          class="btn-primary px-10 py-4 rounded-2xl text-base font-bold inline-flex items-center gap-3">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
          Mulai Sekarang — Gratis Konsultasi
        </a>
        <p class="text-navy/35 text-xs mt-3">Respons biasanya dalam 5 menit</p>
      </div>
    </div>
  </section>


  <!-- ============================================================
      TESTIMONIALS / MINI REVIEW STRIP
  ============================================================ -->
  <section class="bg-white py-16 lg:py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="text-center mb-10 reveal">
        <h2 class="text-2xl lg:text-3xl font-bold text-navy mb-2">Kata Mereka yang Sudah<br class="sm:hidden"/> Bergabung</h2>
        <div class="flex items-center justify-center gap-1 mt-3">
          <div class="flex text-yellow-400 text-lg">★★★★★</div>
          <span class="text-navy/50 text-sm ml-2">4.9/5 dari 500+ ulasan</span>
        </div>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Review 1 -->
        <div class="reveal reveal-delay-1 bg-[#F8F9FA] rounded-2xl p-6 border border-gray-100">
          <div class="flex items-center gap-1 text-yellow-400 text-sm mb-3">★★★★★</div>
          <p class="text-navy/70 text-sm leading-relaxed mb-4">
            "Awalnya skeptis, tapi setelah bayar QRIS, login Canva Pro langsung masuk ke email dalam 30 detik. Gila, ini yang saya cari selama ini!"
          </p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center font-bold text-purple-600 text-sm">R</div>
            <div>
              <div class="font-semibold text-navy text-sm">Rizky A.</div>
              <div class="text-navy/40 text-xs">Mahasiswa Desain, Jakarta</div>
            </div>
          </div>
        </div>

        <!-- Review 2 -->
        <div class="reveal reveal-delay-2 bg-[#0A2540] rounded-2xl p-6 relative overflow-hidden">
          <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at top right, rgba(0,229,255,0.07) 0%, transparent 60%);"></div>
          <div class="flex items-center gap-1 text-yellow-400 text-sm mb-3 relative z-10">★★★★★</div>
          <p class="text-white/65 text-sm leading-relaxed mb-4 relative z-10">
            "Udah 6 bulan langganan Spotify di sini. Pernah satu kali ada masalah akun, langsung diganti dalam 2 jam. Garansinya beneran!"
          </p>
          <div class="flex items-center gap-3 relative z-10">
            <div class="w-9 h-9 rounded-full bg-cyan-accent/20 flex items-center justify-center font-bold text-cyan-accent text-sm">S</div>
            <div>
              <div class="font-semibold text-white text-sm">Sari N.</div>
              <div class="text-white/35 text-xs">UMKM Kuliner, Bandung</div>
            </div>
          </div>
        </div>

        <!-- Review 3 -->
        <div class="reveal reveal-delay-3 bg-[#F8F9FA] rounded-2xl p-6 border border-gray-100">
          <div class="flex items-center gap-1 text-yellow-400 text-sm mb-3">★★★★★</div>
          <p class="text-navy/70 text-sm leading-relaxed mb-4">
            "Tim konten kami sekarang pakai Canva Pro + ChatGPT Plus dari AksesPro. Budget yang biasanya habis Rp 400rb/bln cukup Rp 60rb. Efisiensinya luar biasa!"
          </p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-sm">D</div>
            <div>
              <div class="font-semibold text-navy text-sm">Dimas P.</div>
              <div class="text-navy/40 text-xs">Digital Agency, Surabaya</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================================
      CONTACT / CTA FINAL SECTION
  ============================================================ -->
  <section id="kontak" class="bg-[#0A2540] py-20 lg:py-28 relative overflow-hidden">

    <!-- Background effects -->
    <div class="blob absolute top-0 left-1/4 w-96 h-96 bg-cyan-accent opacity-8"></div>
    <div class="blob blob-2 absolute bottom-0 right-1/4 w-64 h-64 bg-blue-400 opacity-10"></div>
    <div class="grid-bg absolute inset-0 pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-12 text-center">

      <div class="reveal">
        <div class="section-label mb-6 mx-auto">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
          Hubungi Kami
        </div>

        <h2 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
          Siap Upgrade ke <span class="gradient-text">Level Pro?</span>
        </h2>
        <p class="text-white/55 text-lg max-w-2xl mx-auto mb-12 leading-relaxed">
          Tim kami siap membantu memilihkan paket terbaik sesuai kebutuhanmu. Chat sekarang, respons dalam 5 menit.
        </p>

        <!-- Contact Cards -->
        <div class="grid sm:grid-cols-2 gap-4 max-w-xl mx-auto mb-12">
          <!-- WhatsApp -->
          <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" id="contact-wa"
            class="group flex items-center gap-4 bg-white/5 hover:bg-[#25D366]/10 border border-white/10 hover:border-[#25D366]/40 rounded-2xl p-5 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-[#25D366]/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </div>
            <div class="text-left">
              <div class="text-white/40 text-xs uppercase tracking-wider mb-0.5">WhatsApp</div>
              <div class="text-white font-semibold text-sm">+62 895-3960-48445</div>
            </div>
          </a>

          <!-- Instagram -->
          <a href="https://instagram.com/aksespro_id" target="_blank" rel="noopener" id="contact-ig"
            class="group flex items-center gap-4 bg-white/5 hover:bg-pink-500/10 border border-white/10 hover:border-pink-500/40 rounded-2xl p-5 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-pink-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </div>
            <div class="text-left">
              <div class="text-white/40 text-xs uppercase tracking-wider mb-0.5">Instagram</div>
              <div class="text-white font-semibold text-sm">@aksespro_id</div>
            </div>
          </a>
        </div>

        <!-- Big CTA -->
        <a href="https://api.whatsapp.com/send/?phone=62895396048445" target="_blank" rel="noopener" id="final-cta"
          class="btn-primary px-12 py-5 rounded-2xl text-lg font-bold inline-flex items-center gap-3 glow-cyan">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
          Chat Kami Sekarang
        </a>
      </div>
    </div>
  </section>

@endsection