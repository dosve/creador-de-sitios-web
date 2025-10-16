{{-- Footer Fotógrafo --}}
<footer class="bg-gray-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-3 gap-12 text-center mb-12">
      <div>
        <h3 class="text-xl font-light mb-4" style="font-family:'Oswald',sans-serif;">{{strtoupper($website->name??'PHOTO')}}</h3>
        <p class="text-gray-400 text-sm">Capturando momentos únicos</p>
      </div>
      <div>
        <h3 class="text-sm font-light mb-4 tracking-wider">CONTACTO</h3>
        <p class="text-gray-400 text-sm">info@foto.com<br>+1 234 567 89</p>
      </div>
      <div>@if($footerConfig['show_social']??true)<div class="flex items-center justify-center space-x-4">@for($i=0;$i<3;$i++)<a href="#" class="w-8 h-8 flex items-center justify-center border border-gray-700 hover:border-white transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12z" /></svg></a>@endfor</div>@endif</div>
    </div>
    <div class="pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
      <p>© {{date('Y')}} {{$website->name??'Fotógrafo'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
    </div>
  </div>
</footer>
