{{-- Footer Músico --}}
<footer class="bg-black text-white border-t border-gray-800">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-3 gap-8 text-center">
      <div>
        <h3 class="text-2xl font-bold mb-4" style="font-family:'Bebas Neue',sans-serif;">{{strtoupper($website->name??'BANDA')}}</h3>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">SIGUE LA MÚSICA</h4>
        <div class="flex justify-center space-x-4">@for($i=0;$i<4;$i++)<a href="#" class="w-10 h-10 bg-gray-900 hover:bg-red-600 flex items-center justify-center rounded transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" /></svg></a>@endfor</div>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Escucha en todas las plataformas</p>
      </div>
    </div>
    <div class="pt-8 mt-8 border-t border-gray-900 text-center text-sm text-gray-500">
      <p>© {{date('Y')}} {{$website->name??'Banda'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
    </div>
  </div>
</footer>
