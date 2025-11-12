{{-- Footer Agencia Creativa --}}
<footer class="bg-gray-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
      {{-- Column 1: About --}}
      <div class="md:col-span-2">
        <h3 class="text-2xl font-bold mb-6 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent" style="font-family: 'Poppins', sans-serif;">
          {{ $website->name ?? 'Agencia Creativa' }}
        </h3>
        <p class="text-gray-400 mb-6 leading-relaxed max-w-md">
          Transformamos ideas en experiencias digitales extraordinarias.
          Somos tu partner creativo para hacer realidad tus proyectos.
        </p>
        @if($footerConfig['show_social'] ?? true)
        <div class="flex items-center space-x-4">
          @if(!empty($templateConfig->settings['social_media']['facebook']))
          <a href="{{ $templateConfig->settings['social_media']['facebook'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-600 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </a>
          @endif
          
          @if(!empty($templateConfig->settings['social_media']['instagram']))
          <a href="{{ $templateConfig->settings['social_media']['instagram'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-600 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
          </a>
          @endif
          
          @if(!empty($templateConfig->settings['social_media']['twitter']))
          <a href="{{ $templateConfig->settings['social_media']['twitter'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-600 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
          </a>
          @endif
          
          @if(!empty($templateConfig->settings['social_media']['linkedin']))
          <a href="{{ $templateConfig->settings['social_media']['linkedin'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-600 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
            </svg>
          </a>
          @endif
        </div>
        @endif
      </div>

      {{-- Column 2: Links --}}
      <div>
        <h3 class="text-lg font-bold mb-6">Servicios</h3>
        <ul class="space-y-3 text-sm text-gray-400">
          <li><a href="#" class="hover:text-white transition-colors">Diseño Web</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Desarrollo</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Branding</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Marketing Digital</a></li>
        </ul>
      </div>

      {{-- Column 3: Contact --}}
      <div>
        <h3 class="text-lg font-bold mb-6">Contacto</h3>
        <ul class="space-y-3 text-sm text-gray-400">
          @if(!empty($templateConfig->settings['contact_email']))
          <li class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <a href="mailto:{{ $templateConfig->settings['contact_email'] }}" class="hover:text-white transition-colors">{{ $templateConfig->settings['contact_email'] }}</a>
          </li>
          @else
          <li class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <a href="mailto:hola@agencia.com" class="hover:text-white transition-colors">hola@agencia.com</a>
          </li>
          @endif
          
          @if(!empty($templateConfig->settings['contact_phone']))
          <li class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <a href="tel:{{ str_replace(' ', '', $templateConfig->settings['contact_phone']) }}" class="hover:text-white transition-colors">{{ $templateConfig->settings['contact_phone'] }}</a>
          </li>
          @else
          <li class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <a href="tel:+123456789" class="hover:text-white transition-colors">+1 234 567 89</a>
          </li>
          @endif
        </ul>
      </div>
    </div>

    {{-- Copyright --}}
    <div class="pt-8 border-t border-gray-800 text-center">
      <p class="text-sm text-gray-500">
        © {{ date('Y') }} {{ $website->name ?? 'Agencia' }}.
        {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}
      </p>
      <p class="mt-3 text-xs text-gray-600">
        Creado con <a href="https://eme10.com" target="_blank" class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent hover:from-purple-300 hover:to-pink-300 transition-all font-semibold">EME10</a> | 
        Gestión con <a href="https://adminnegocios.com" target="_blank" class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent hover:from-purple-300 hover:to-pink-300 transition-all font-semibold">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>
