{{-- Footer Clínica --}}
<footer class="bg-cyan-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-3 gap-8">
      <div>
        <h3 class="text-xl font-bold mb-4">{{$website->name??'Clínica'}}</h3>
        <p class="text-cyan-200 text-sm">Cuidando tu salud</p>
      </div>
      <div>
        <h4 class="font-bold mb-4">Horarios</h4>
        <ul class="space-y-2 text-sm text-cyan-200">
          <li>Lunes-Viernes: 8:00-20:00</li>
          <li>Sábados: 9:00-14:00</li>
          <li>Emergencias: 24/7</li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Contacto</h4>
        <ul class="space-y-2 text-sm text-cyan-200">
          <li>Tel: +1 234 567 89</li>
          <li>Email: info@clinica.com</li>
        </ul>
      </div>
    </div>
    <div class="pt-8 mt-8 border-t border-cyan-800 text-center text-sm text-cyan-300">
      <p>© {{date('Y')}} {{$website->name??'Clínica'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
      <p class="mt-2 text-xs text-cyan-400">
        Creado con <a href="https://eme10.com" target="_blank" class="text-cyan-200 hover:text-white transition-colors font-medium">EME10</a> | 
        <a href="https://adminnegocios.com" target="_blank" class="text-cyan-200 hover:text-white transition-colors font-medium">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
