{{-- Header Minimalista - Estilo Apple --}}
<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/80 backdrop-blur-xl border-b border-gray-200/50">
  <div class="container px-6 mx-auto">
    <div class="flex items-center justify-between h-16">
      {{-- Logo --}}
      <div class="flex items-center">
        @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-8">
        @else
        <h1 class="text-xl font-semibold tracking-tight text-gray-900">{{ $website->name ?? 'Store' }}</h1>
        @endif
      </div>

      {{-- Navigation --}}
      <nav class="hidden md:flex items-center space-x-8">
        @include('templates.partials.menu-header')
      </nav>

      {{-- Actions --}}
      <div class="flex items-center space-x-6">
        {{-- Search --}}
        @if($headerConfig['show_search'] ?? true)
        <button class="text-gray-700 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>
        @endif

        {{-- User Menu (Componente descentralizado) --}}
        <x-auth.user-menu-button :website="$website" buttonClass="text-gray-700 hover:text-black transition-colors" />

        {{-- Cart --}}
        @if($headerConfig['show_cart'] ?? true)
        <button id="cart-button" class="relative text-gray-700 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <span id="cart-counter" class="absolute -top-2 -right-2 flex items-center justify-center w-5 h-5 text-xs text-white bg-black rounded-full">0</span>
        </button>
        @endif

        {{-- Mobile menu --}}
        <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-black transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile Menu --}}
    <nav id="mobile-menu" class="hidden md:hidden py-6 border-t border-gray-200/50">
      <div class="flex flex-col space-y-4">
        @include('templates.partials.menu-header')
      </div>
    </nav>
  </div>
</header>

{{-- Spacer for fixed header --}}
<div class="h-16"></div>

{{-- Mobile Menu Script --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
      });
    }
  });

</script>
