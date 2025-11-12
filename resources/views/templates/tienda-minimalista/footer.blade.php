{{-- Footer Minimalista --}}
<footer class="mt-24 border-t border-gray-200 bg-gray-50">
  <div class="container px-6 py-16 mx-auto">
    {{-- Logo del sitio --}}
    <div class="mb-12">
      @if(!empty($website->logo))
        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-8">
      @else
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $website->name ?? 'Store' }}</h2>
      @endif
    </div>
    
    <div class="grid grid-cols-1 gap-12 md:grid-cols-4">
      {{-- Column 1 --}}
      <div>
        <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-900">Tienda</h3>
        <ul class="space-y-3 text-sm text-gray-600">
          @include('templates.partials.menu-footer')
        </ul>
      </div>

      {{-- Column 2 --}}
      <div>
        <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-900">Servicios</h3>
        <ul class="space-y-3 text-sm text-gray-600">
          <li><a href="#" class="hover:text-black transition-colors">Envíos</a></li>
          <li><a href="#" class="hover:text-black transition-colors">Devoluciones</a></li>
          <li><a href="#" class="hover:text-black transition-colors">Garantía</a></li>
        </ul>
      </div>

      {{-- Column 3 --}}
      <div>
        <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-900">Ayuda</h3>
        <ul class="space-y-3 text-sm text-gray-600">
          <li><a href="#" class="hover:text-black transition-colors">Contacto</a></li>
          <li><a href="#" class="hover:text-black transition-colors">FAQ</a></li>
          <li><a href="#" class="hover:text-black transition-colors">Soporte</a></li>
        </ul>
      </div>

      {{-- Column 4 --}}
      <div>
        <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-900">Legal</h3>
        <ul class="space-y-3 text-sm text-gray-600">
          <li><a href="#" class="hover:text-black transition-colors">Privacidad</a></li>
          <li><a href="#" class="hover:text-black transition-colors">Términos</a></li>
          <li><a href="#" class="hover:text-black transition-colors">Cookies</a></li>
        </ul>
      </div>
    </div>

    {{-- Copyright --}}
    <div class="pt-8 mt-12 text-center border-t border-gray-200">
      <p class="text-sm text-gray-500">
        © {{ date('Y') }} {{ $website->name ?? 'Tienda' }}.
        {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}
      </p>
      <p class="mt-2 text-xs text-gray-400">
        Creado con <a href="https://eme10.com" target="_blank" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">EME10</a> | 
        <a href="https://adminnegocios.com" target="_blank" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
