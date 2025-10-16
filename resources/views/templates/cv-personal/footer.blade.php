{{-- Footer CV --}}
<footer class="bg-slate-800 text-white">
  <div class="container px-6 py-12 mx-auto">
    <div class="grid md:grid-cols-2 gap-8 text-center md:text-left">
      <div>
        <h3 class="text-lg font-bold mb-4" style="font-family:'Space Grotesk',sans-serif;">{{$website->name??'Profesional'}}</h3>
        <p class="text-slate-400 text-sm">Construyendo el futuro con código</p>
      </div>
      <div class="text-center md:text-right">@if($footerConfig['show_social']??true)<div class="flex items-center justify-center md:justify-end space-x-4 mb-4">@for($i=0;$i<4;$i++)<a href="#" class="w-8 h-8 flex items-center justify-center bg-slate-700 hover:bg-blue-600 rounded transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" /></svg></a>@endfor</div>@endif</div>
    </div>
    <div class="pt-6 mt-6 border-t border-slate-700 text-center text-sm text-slate-500">
      <p>© {{date('Y')}} {{$website->name??'CV'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
    </div>
  </div>
</footer>
