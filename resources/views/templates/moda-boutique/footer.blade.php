{{-- Footer Moda Boutique --}}
<footer class="bg-black text-white">
  {{-- Newsletter --}}
  @if($footerConfig['show_newsletter'] ?? true)
  <div class="border-b border-gray-800">
    <div class="container px-6 py-16 mx-auto">
      <div class="max-w-2xl mx-auto text-center">
        <h3 class="text-3xl font-bold mb-4" style="font-family: 'Cormorant Garamond', serif;">
          Suscríbete a Nuestro Newsletter
        </h3>
        <p class="text-gray-400 mb-8">
          Recibe las últimas tendencias y ofertas exclusivas
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
          <input type="email" placeholder="Tu email" class="flex-1 px-6 py-4 bg-white text-black rounded-none focus:outline-none focus:ring-2 focus:ring-white">
          <button type="submit" class="px-8 py-4 bg-white text-black hover:bg-gray-200 transition-colors font-medium tracking-wider">
            SUSCRIBIRSE
          </button>
        </form>
      </div>
    </div>
  </div>
  @endif

  <div class="container px-6 py-16 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
      {{-- Column 1 --}}
      <div>
        <h3 class="text-lg font-bold tracking-wider mb-6">TIENDA</h3>
        <ul class="space-y-3 text-sm text-gray-400">
          @include('templates.partials.menu-footer')
        </ul>
      </div>

      {{-- Column 2 --}}
      <div>
        <h3 class="text-lg font-bold tracking-wider mb-6">AYUDA</h3>
        <ul class="space-y-3 text-sm text-gray-400">
          <li><a href="#" class="hover:text-white transition-colors">Envíos</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Devoluciones</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Tallas</a></li>
          <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
        </ul>
      </div>

      {{-- Column 3 --}}
      <div>
        <h3 class="text-lg font-bold tracking-wider mb-6">NOSOTROS</h3>
        <ul class="space-y-3 text-sm text-gray-400">
          <li><a href="#" class="hover:text-white transition-colors">Nuestra Historia</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Sostenibilidad</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Prensa</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Contacto</a></li>
        </ul>
      </div>

      {{-- Column 4: Social --}}
      <div>
        <h3 class="text-lg font-bold tracking-wider mb-6">SÍGUENOS</h3>
        @if($footerConfig['show_social'] ?? true)
        <div class="flex items-center space-x-4">
          <a href="#" class="w-10 h-10 flex items-center justify-center border border-gray-700 hover:border-white hover:bg-white hover:text-black transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </a>
          <a href="#" class="w-10 h-10 flex items-center justify-center border border-gray-700 hover:border-white hover:bg-white hover:text-black transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
          </a>
          <a href="#" class="w-10 h-10 flex items-center justify-center border border-gray-700 hover:border-white hover:bg-white hover:text-black transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
            </svg>
          </a>
        </div>
        @endif
      </div>
    </div>

    {{-- Copyright --}}
    <div class="pt-8 mt-12 text-center border-t border-gray-800">
      <p class="text-sm text-gray-500">
        © {{ date('Y') }} {{ $website->name ?? 'Boutique' }}.
        {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}
      </p>
      <p class="mt-2 text-xs text-gray-600">
        Creado con <a href="https://eme10.com" target="_blank" class="text-gray-400 hover:text-white transition-colors font-medium">EME10</a> | 
        <a href="https://adminnegocios.com" target="_blank" class="text-gray-400 hover:text-white transition-colors font-medium">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
