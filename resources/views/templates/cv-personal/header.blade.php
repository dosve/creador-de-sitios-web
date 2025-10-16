{{-- Header CV --}}
<header class="bg-white border-b {{$headerConfig['sticky']??true?'sticky top-0 z-50':''}}">
  <div class="container px-6 py-4 mx-auto">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-xl font-bold" style="font-family:'Space Grotesk',sans-serif;">{{$website->name??'Mi CV'}}</h1>
      </div>
      <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">@include('templates.partials.menu-header')</nav>
      <div class="flex items-center space-x-4">@if($headerConfig['show_download']??true)<a href="#" class="hidden md:inline-flex px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Descargar CV</a>@endif<button id="mobile-menu-btn" class="md:hidden"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg></button></div>
    </div>
    <nav id="mobile-menu" class="hidden md:hidden mt-4 pt-4 border-t">
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
