{{-- Footer Minimalista --}}
<footer class="mt-24 border-t border-gray-200 bg-gray-50">
  <div class="container px-6 py-16 mx-auto">
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
    </div>
  </div>
</footer>
