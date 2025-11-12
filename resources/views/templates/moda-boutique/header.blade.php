{{-- Header Moda Boutique --}}
<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-sm border-b border-gray-100">
  <div class="container px-6 mx-auto">
    <div class="flex items-center justify-between h-20">
      {{-- Left Menu --}}
      <nav class="hidden lg:flex items-center space-x-8">
        @include('templates.partials.menu-header')
      </nav>

      {{-- Logo Center --}}
      <div class="absolute left-1/2 transform -translate-x-1/2">
        @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-8">
        @else
        <h1 class="text-2xl font-bold tracking-widest" style="font-family: 'Cormorant Garamond', serif;">
          {{ strtoupper($website->name ?? 'BOUTIQUE') }}
        </h1>
        @endif
      </div>

      {{-- Right Actions --}}
      <div class="flex items-center space-x-6">
        {{-- Search --}}
        @if($headerConfig['show_search'] ?? true)
        <button class="text-gray-700 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>
        @endif

        {{-- User Menu --}}
        <div class="relative" id="user-menu-container">
          {{-- Guest Menu --}}
          <div id="guest-menu" class="hidden">
            <button id="login-button" class="text-gray-700 hover:text-black transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </button>
          </div>
          
          {{-- Authenticated User Menu --}}
          <div id="user-menu" class="hidden">
            <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-black transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span id="user-name" class="hidden md:inline text-sm font-medium"></span>
            </button>
            
            {{-- Dropdown --}}
            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1">
              <a href="/{{ $website->slug ?? '' }}/my-orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                Mis Órdenes
              </a>
              <button id="logout-button" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                Cerrar Sesión
              </button>
            </div>
          </div>
        </div>

        {{-- Cart --}}
        @if($headerConfig['show_cart'] ?? true)
        <button id="cart-button" class="relative text-gray-700 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <span id="cart-counter" class="absolute -top-2 -right-2 flex items-center justify-center w-4 h-4 text-xs text-white bg-black rounded-full">0</span>
        </button>
        @endif

        {{-- Mobile menu --}}
        <button id="mobile-menu-btn" class="lg:hidden text-gray-700 hover:text-black transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile Menu --}}
    <nav id="mobile-menu" class="hidden lg:hidden py-6 border-t border-gray-100">
      <div class="flex flex-col space-y-4 text-center">
        @include('templates.partials.menu-header')
      </div>
    </nav>
  </div>
</header>

{{-- Spacer --}}
<div class="h-20"></div>

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
