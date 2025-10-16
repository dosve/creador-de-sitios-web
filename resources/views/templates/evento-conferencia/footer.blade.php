{{-- Footer Evento --}}
<footer class="bg-purple-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-4 gap-8">
      <div class="md:col-span-2">
        <h3 class="text-2xl font-bold mb-4">{{$website->name??'Conferencia 2025'}}</h3>
        <p class="text-purple-200 text-sm">El evento más importante del año</p>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Evento</h4>
        <ul class="space-y-2 text-sm text-purple-200">
          <li>Agenda</li>
          <li>Speakers</li>
          <li>Patrocinadores</li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Contacto</h4>
        <ul class="space-y-2 text-sm text-purple-200">
          <li>info@evento.com</li>
          <li>+1 234 567 89</li>
        </ul>
      </div>
    </div>@if($footerConfig['show_sponsors']??true)<div class="pt-12 mt-12 border-t border-purple-800">
      <h4 class="text-center font-bold mb-6">Patrocinadores</h4>
      <div class="flex flex-wrap justify-center gap-8">@for($i=0;$i<4;$i++)<div class="w-24 h-12 bg-white/10 rounded">
      </div>@endfor
    </div>
  </div>@endif<div class="pt-8 mt-8 border-t border-purple-800 text-center text-sm text-purple-300">
    <p>© {{date('Y')}} {{$website->name??'Evento'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
  </div>
  </div>
</footer>
