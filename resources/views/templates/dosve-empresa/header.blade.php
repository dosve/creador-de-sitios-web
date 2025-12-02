{{-- Header Dosve Empresa --}}
<header class="sticky top-0 z-50 bg-white shadow-sm">
  <div class="container px-4 mx-auto sm:px-6 lg:px-8">
    <div class="flex items-center justify-between py-4">
      {{-- Logo --}}
      <div class="flex items-center">
        <img src="https://creadorweb.eme10.com/storage/logos/logo.jpeg
" alt="{{ $website->name }}" class="object-cover w-16 h-16 rounded-full">
      </div>

      {{-- Navigation --}}
      <nav class="items-center hidden space-x-8 md:flex">
        @include('templates.partials.menu-header')
      </nav>

      {{-- CTA Button --}}
      <div class="hidden md:block">
        <a href="https://wa.me/573245229046" target="_blank" class="px-6 py-2 font-medium text-white transition-colors rounded-lg hover:opacity-90" style="background-color: {{ $customization['colors']['primary'] ?? '#2563EB' }};">
          Contáctanos
        </a>
      </div>

      {{-- Mobile menu button --}}
      <button id="mobile-menu-btn" class="p-2 text-gray-700 md:hidden hover:text-blue-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    {{-- Mobile Menu --}}
    <nav id="mobile-menu" class="hidden pt-4 mt-4 border-t border-gray-100 md:hidden">
      <div class="flex flex-col space-y-3">
        @include('templates.partials.menu-header')
        <a href="https://wa.me/573245229046" target="_blank" class="px-4 py-3 font-medium text-center text-white rounded-lg" style="background-color: {{ $customization['colors']['primary'] ?? '#2563EB' }};">
          Contáctanos
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