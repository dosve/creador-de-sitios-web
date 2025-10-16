{{-- Footer Consultoría Corporativa --}}
<footer class="bg-slate-900 text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
      {{-- Column 1: About --}}
      <div class="md:col-span-2">
        <h3 class="text-xl font-bold mb-6" style="font-family: 'Merriweather', serif;">
          {{ $website->name ?? 'Consultoría Corporativa' }}
        </h3>
        <p class="text-slate-400 mb-6 leading-relaxed">
          Expertos en soluciones empresariales con más de 20 años de experiencia.
          Ayudamos a empresas a alcanzar sus objetivos estratégicos.
        </p>
        @if($footerConfig['show_certifications'] ?? true)
        <div class="flex items-center space-x-4">
          <div class="px-4 py-2 bg-slate-800 rounded text-xs font-medium border border-slate-700">
            ISO 9001
          </div>
          <div class="px-4 py-2 bg-slate-800 rounded text-xs font-medium border border-slate-700">
            CERTIFICADO
          </div>
        </div>
        @endif
      </div>

      {{-- Column 2: Services --}}
      <div>
        <h3 class="text-lg font-bold mb-6">Servicios</h3>
        <ul class="space-y-3 text-sm text-slate-400">
          <li><a href="#" class="hover:text-white transition-colors">Consultoría Estratégica</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Gestión de Proyectos</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Transformación Digital</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Auditoría</a></li>
        </ul>
      </div>

      {{-- Column 3: Contact --}}
      <div>
        <h3 class="text-lg font-bold mb-6">Contacto</h3>
        <ul class="space-y-4 text-sm text-slate-400">
          <li class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>Calle Corporativa 123<br>Ciudad, País</span>
          </li>
          <li class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <a href="mailto:info@consultoria.com" class="hover:text-white transition-colors">info@consultoria.com</a>
          </li>
          <li class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <a href="tel:+123456789" class="hover:text-white transition-colors">+1 (234) 567-8900</a>
          </li>
        </ul>
      </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="pt-8 border-t border-slate-800">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <p class="text-sm text-slate-500">
          © {{ date('Y') }} {{ $website->name ?? 'Consultoría' }}.
          {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}
        </p>

        @if($footerConfig['show_social'] ?? true)
        <div class="flex items-center space-x-4">
          <a href="#" class="text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
            </svg>
          </a>
          <a href="#" class="text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</footer>
