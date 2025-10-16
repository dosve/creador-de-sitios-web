{{-- Header Evento --}}
<header class="bg-white shadow {{$headerConfig['sticky']??true?'sticky top-0 z-50':''}}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-purple-700" style="font-family:'Montserrat',sans-serif;">{{$website->name??'Evento 2025'}}</h1>
      </div>
      <nav class="hidden lg:flex items-center space-x-6 text-sm font-semibold">@include('templates.partials.menu-header')</nav>
      <div class="flex items-center space-x-4">@if($headerConfig['show_register']??true)<a href="#registro" class="hidden md:inline-flex px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg font-bold">Registrarse</a>@endif<button id="mobile-menu-btn" class="lg:hidden"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg></button></div>
    </div>
    <nav id="mobile-menu" class="hidden lg:hidden mt-4 pt-4 border-t">
      <div class="flex flex-col space-y-3">@include('templates.partials.menu-header')</div>
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
