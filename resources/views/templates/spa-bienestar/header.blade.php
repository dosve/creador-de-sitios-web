{{-- Header Spa & Bienestar --}}
<header class="bg-white/95 backdrop-blur-sm shadow-sm {{ $headerConfig['sticky'] ?? true ? 'sticky top-0 z-50' : '' }}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-12">
        @else
        <h1 class="text-2xl font-light text-amber-900" style="font-family: 'Cinzel', serif;">
          {{ $website->name ?? 'Spa' }}
        </h1>
        @endif
      </div>
      <nav class="hidden lg:flex items-center space-x-8 text-sm">
        @include('templates.partials.menu-header')
      </nav>
      <div class="flex items-center space-x-4">
        @if($headerConfig['show_booking'] ?? true)
        <a href="#reservas" class="hidden md:inline-flex px-6 py-3 bg-amber-700 text-white rounded-full hover:bg-amber-800 transition-colors font-light">
          Reservar
        </a>
        @endif
        <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <nav id="mobile-menu" class="hidden lg:hidden mt-4 pt-4 border-t">
      <div class="flex flex-col space-y-3">
        @include('templates.partials.menu-header')
        <a href="#reservas" class="px-4 py-3 text-center bg-amber-700 text-white rounded-full">Reservar</a>
      </div>
    </nav>
  </div>
</header>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) btn.addEventListener('click', () => menu.classList.toggle('hidden'));
  });

</script>
