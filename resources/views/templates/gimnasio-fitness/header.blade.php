{{-- Header Gimnasio --}}
<header class="bg-gray-900 text-white {{ $headerConfig['sticky'] ?? true ? 'sticky top-0 z-50' : '' }}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      <div>
        @if(!empty($website->logo))<img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10">
        @else<h1 class="text-3xl font-bold" style="font-family:'Bebas Neue',sans-serif;">{{ strtoupper($website->name ?? 'GYM') }}</h1>@endif
      </div>
      <nav class="hidden lg:flex items-center space-x-8 font-medium">@include('templates.partials.menu-header')</nav>
      <div class="flex items-center space-x-4">
        @if($headerConfig['show_join'] ?? true)<a href="#planes" class="hidden md:inline-flex px-6 py-3 bg-red-600 hover:bg-red-700 transition-colors font-bold">ÚNETE AHORA</a>@endif
        <button id="mobile-menu-btn" class="lg:hidden p-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg></button>
      </div>
    </div>
    <nav id="mobile-menu" class="hidden lg:hidden mt-4 pt-4 border-t border-gray-800">
      <div class="flex flex-col space-y-3">@include('templates.partials.menu-header')<a href="#planes" class="px-4 py-3 text-center bg-red-600 font-bold">ÚNETE AHORA</a></div>
    </nav>
  </div>
</header>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const b = document.getElementById('mobile-menu-btn')
      , m = document.getElementById('mobile-menu');
    if (b && m) b.addEventListener('click', () => m.classList.toggle('hidden'));
  });

</script>
