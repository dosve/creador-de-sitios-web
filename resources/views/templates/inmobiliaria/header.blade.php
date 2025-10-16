{{-- Header Inmobiliaria --}}
<header class="bg-white shadow {{$headerConfig['sticky']??true?'sticky top-0 z-50':''}}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-teal-700" style="font-family:'Montserrat',sans-serif;">{{$website->name??'Inmobiliaria'}}</h1>
      </div>
      <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium">@include('templates.partials.menu-header')</nav>
      <div class="flex items-center space-x-4"><a href="tel:+123456789" class="hidden md:flex items-center space-x-2 text-teal-700 hover:text-teal-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
          </svg><span class="font-semibold">+1 234 567 89</span></a><button id="mobile-menu-btn" class="lg:hidden"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
