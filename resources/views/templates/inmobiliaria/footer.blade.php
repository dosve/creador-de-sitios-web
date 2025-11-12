{{-- Footer Inmobiliaria --}}
<footer class="bg-teal-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-4 gap-8">
      <div class="md:col-span-2">
        <h3 class="text-xl font-bold mb-4">{{$website->name??'Inmobiliaria'}}</h3>
        <p class="text-teal-200 text-sm mb-4">Encuentra tu hogar ideal</p>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Propiedades</h4>
        <ul class="space-y-2 text-sm text-teal-200">
          <li>En Venta</li>
          <li>En Alquiler</li>
          <li>Destacadas</li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-sm">Contacto</h4>
        <ul class="space-y-2 text-sm text-teal-200">
          <li>Tel: +1 234 567 89</li>
          <li>info@inmobiliaria.com</li>
        </ul>
      </div>
    </div>
    <div class="pt-8 mt-8 border-t border-teal-800 text-center text-sm text-teal-300">
      <p>© {{date('Y')}} {{$website->name??'Inmobiliaria'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
      <p class="mt-2 text-xs text-teal-400">
        Creado con <a href="https://eme10.com" target="_blank" class="text-teal-200 hover:text-white transition-colors font-medium">EME10</a> | 
        <a href="https://adminnegocios.com" target="_blank" class="text-teal-200 hover:text-white transition-colors font-medium">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
