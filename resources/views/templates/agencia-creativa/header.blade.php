{{-- Header Agencia Creativa --}}
<header class="agencia-header {{ $headerConfig['sticky'] ?? true ? 'sticky top-0 z-50' : '' }}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      {{-- Logo --}}
      <div class="flex items-center">
        @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10">
        @else
        <h1 class="agencia-logo text-2xl font-bold">
          {{ $website->name ?? 'Agencia' }}
        </h1>
        @endif
      </div>

      {{-- Navigation --}}
      <nav class="hidden lg:flex items-center space-x-8">
        @include('templates.agencia-creativa.menu-header')
      </nav>

      {{-- CTA Button --}}
      <div class="flex items-center space-x-4">
        @if($headerConfig['show_cta'] ?? true)
        <a href="#contacto" class="agencia-btn-primary hidden md:inline-flex">
          Hablemos
        </a>
        @endif

        {{-- Mobile menu button --}}
        <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700 hover:text-purple-600 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile Menu --}}
    <nav id="mobile-menu" class="hidden lg:hidden mt-4 pt-4 border-t border-gray-100">
      <div class="flex flex-col space-y-3">
        @include('templates.agencia-creativa.menu-header')
        <a href="#contacto" class="agencia-btn-primary px-4 py-3 text-center">
          Hablemos
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
