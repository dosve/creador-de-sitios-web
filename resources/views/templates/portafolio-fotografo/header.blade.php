{{-- Header Fotógrafo --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm">
  <div class="container px-6 py-6 mx-auto">
    <div class="flex items-center justify-between">
      <div>@if(!empty($website->logo))<img src="{{asset('storage/'.$website->logo)}}" alt="{{$website->name}}" class="h-8">@else<h1 class="text-2xl font-light tracking-wider" style="font-family:'Oswald',sans-serif;">{{strtoupper($website->name??'PHOTO')}}</h1>@endif</div>
      <nav class="hidden md:flex items-center space-x-8 text-sm tracking-wide">@include('templates.partials.menu-header')</nav><button id="mobile-menu-btn" class="md:hidden"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg></button>
    </div>
    <nav id="mobile-menu" class="hidden md:hidden mt-4 pt-4 border-t">
      <div class="flex flex-col space-y-3">@include('templates.partials.menu-header')</div>
    </nav>
  </div>
</header>
<div class="h-20"></div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const b = document.getElementById('mobile-menu-btn')
      , m = document.getElementById('mobile-menu');
    if (b && m) b.addEventListener('click', () => m.classList.toggle('hidden'));
  });

</script>
