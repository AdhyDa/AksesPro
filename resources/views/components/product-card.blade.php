@props([
    'delay' => '1',
    'bgStyle' => 'background: linear-gradient(135deg, #0d2e59 0%, #0A2540 100%);',
    'bgClasses' => 'bg-gradient-to-br from-navy-800 to-navy',
    'isFeatured' => false,
    'iconBg' => '',
    'title' => '',
    'subtitle' => '',
    'badgeText' => '',
    'badgeClasses' => '',
    'features' => [],
    'featureIconBg' => '',
    'featureIconColor' => '',
    'priceOriginal' => '',
    'priceDiscounted' => '',
    'priceDiscountedClasses' => 'text-white',
    'discountPercent' => '',
    'discountClasses' => '',
    'buyUrl' => '',
    'buyBtnClasses' => 'btn-primary'
])

<div class="pricing-card {{ $isFeatured ? 'featured' : '' }} reveal reveal-delay-{{ $delay }} {{ $bgClasses }} rounded-3xl p-8 border border-white/10 relative overflow-hidden" 
     style="{{ $bgStyle }}">

  @if($isFeatured)
    <!-- Bg glow -->
    <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at top right, rgba(0, 229, 255, 0.12) 0%, transparent 60%);"></div>
    <!-- Popular badge -->
    <div class="absolute -top-0.5 left-1/2 -translate-x-1/2">
      <div class="badge-popular flex items-center gap-1.5 shadow-lg">
        ⭐ Paling Populer
      </div>
    </div>
  @else
    {{ $bgGlow ?? '' }}
  @endif

  <!-- App header -->
  <div class="flex items-center justify-between mb-8 {{ $isFeatured ? 'mt-4' : '' }}">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg" style="{{ $iconBg }}">
        {{ $icon }}
      </div>
      <div>
        <h3 class="font-bold text-white text-lg">{{ $title }}</h3>
        <p class="text-white/40 text-xs">{{ $subtitle }}</p>
      </div>
    </div>
    <div class="text-[10px] {{ $badgeClasses }} rounded-full px-2.5 py-1 font-semibold">{{ $badgeText }}</div>
  </div>

  <!-- Features -->
  <ul class="space-y-3 mb-8">
    @foreach($features as $feature)
    <li class="flex items-center gap-3 text-sm text-white/70">
      <div class="w-5 h-5 rounded-full {{ $featureIconBg }} flex items-center justify-center flex-shrink-0">
        <svg class="w-3 h-3 {{ $featureIconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      {{ $feature }}
    </li>
    @endforeach
  </ul>

  <!-- Pricing -->
  <div class="border-t border-white/10 pt-6">
    <div class="flex items-end justify-between mb-4">
      <div>
        <div class="text-white/30 text-xs line-through mb-1">{{ $priceOriginal }} (resmi)</div>
        <div class="font-bold text-3xl {{ $priceDiscountedClasses }}">
          {{ $priceDiscounted }}<span class="text-white/40 text-sm font-normal">/bulan</span>
        </div>
      </div>
      <div class="text-xs {{ $discountClasses }} rounded-xl px-3 py-2 font-semibold text-center">
        Hemat<br/>{{ $discountPercent }}
      </div>
    </div>
    <a href="{{ $buyUrl }}" target="_blank" rel="noopener" class="w-full {{ $buyBtnClasses }} py-3.5 rounded-xl text-sm font-bold text-center block transition-all duration-300">
      Beli Sekarang →
    </a>
  </div>
</div>
