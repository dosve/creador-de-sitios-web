{{-- Footer Academia --}}
<footer class="bg-violet-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-4 gap-8">
      <div class="md:col-span-2">
        <h3 class="text-xl font-bold mb-4" style="font-family:'Raleway',sans-serif;">{{$website->name??'Academia'}}</h3>
        <p class="text-violet-200 text-sm">Aprende sin límites</p>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Cursos</h4>
        <ul class="space-y-2 text-sm text-violet-200">
          <li>Desarrollo Web</li>
          <li>Diseño</li>
          <li>Marketing</li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Soporte</h4>
        <ul class="space-y-2 text-sm text-violet-200">
          <li>Ayuda</li>
          <li>FAQ</li>
          <li>Contacto</li>
        </ul>
      </div>
    </div>
    <div class="pt-8 mt-8 border-t border-violet-800 text-center text-sm text-violet-300">
      <p>© {{date('Y')}} {{$website->name??'Academia'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
    </div>
  </div>
</footer>
