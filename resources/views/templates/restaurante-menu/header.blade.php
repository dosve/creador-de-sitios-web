{{-- Header Restaurante --}}
<header class="bg-white shadow-md {{ $headerConfig['sticky'] ?? true ? 'sticky top-0 z-50' : '' }}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      {{-- Logo --}}
      <div class="flex items-center">
        @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-12">
        @else
        <h1 class="text-2xl font-bold text-amber-800" style="font-family: 'Playfair Display', serif;">
          {{ $website->name ?? 'Restaurante' }}
        </h1>
        @endif
      </div>

      {{-- Navigation --}}
      <nav class="hidden lg:flex items-center space-x-8">
        @include('templates.partials.menu-header')
      </nav>

      {{-- Actions --}}
      <div class="flex items-center space-x-4">
        {{-- Phone --}}
        @if($headerConfig['show_phone'] ?? true)
        <a href="tel:+123456789" class="hidden md:flex items-center space-x-2 text-amber-700 hover:text-amber-800 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
          </svg>
          <span class="font-medium">Llamar</span>
        </a>
        @endif

        {{-- Reservation Button --}}
        @if($headerConfig['show_reservations'] ?? true)
        <a href="#reservas" class="hidden md:inline-flex px-6 py-3 text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition-colors font-medium shadow-lg">
          Reservar Mesa
        </a>
        @endif

        {{-- Mobile menu button --}}
        <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700 hover:text-amber-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile Menu --}}
    <nav id="mobile-menu" class="hidden lg:hidden mt-4 pt-4 border-t border-gray-200">
      <div class="flex flex-col space-y-3">
        @include('templates.partials.menu-header')
        <a href="#reservas" class="px-4 py-3 text-center text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition-colors font-medium">
          Reservar Mesa
        </a>
      </div>
    </nav>
  </div>
</header>

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
