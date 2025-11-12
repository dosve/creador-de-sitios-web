{{-- Footer Spa --}}
<footer class="bg-stone-800 text-stone-200">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-3 gap-12 mb-12">
      <div>
        <h3 class="text-xl font-light mb-6 text-amber-200" style="font-family: 'Cinzel', serif;">{{ $website->name ?? 'Spa' }}</h3>
        <p class="text-stone-400 mb-6 leading-relaxed">Un oasis de tranquilidad y relajación. Déjanos cuidar de ti.</p>
      </div>
      <div>
        <h3 class="text-lg font-light mb-6">Horarios</h3>
        <ul class="space-y-2 text-sm text-stone-400">
          <li>Lunes - Viernes: 10:00 - 20:00</li>
          <li>Sábados: 9:00 - 21:00</li>
          <li>Domingos: 10:00 - 18:00</li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-light mb-6">Contacto</h3>
        <ul class="space-y-3 text-sm text-stone-400">
          <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <span>+1 234 567 89</span>
          </li>
          <li class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span>info@spa.com</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="pt-8 border-t border-stone-700 text-center text-sm text-stone-500">
      <p>© {{ date('Y') }} {{ $website->name ?? 'Spa' }}. {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}</p>
      <p class="mt-2 text-xs text-stone-600">
        Creado con <a href="https://eme10.com" target="_blank" class="text-amber-200 hover:text-amber-100 transition-colors font-medium">EME10</a> | 
        <a href="https://adminnegocios.com" target="_blank" class="text-amber-200 hover:text-amber-100 transition-colors font-medium">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
