{{-- Footer Dosve Empresa --}}
<footer class="py-16 text-white bg-gray-900">
  <div class="container px-4 mx-auto sm:px-6 lg:px-8">
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
      {{-- Column 1: About --}}
      <div>
        <div class="flex items-center mb-6">
          @if(!empty($website->logo))
          <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="object-cover w-16 h-16 mr-3 rounded-full">
          @else
          <img src="{{ asset('images/logo.jpeg') }}" alt="{{ $website->name ?? 'DOSVE' }}" class="object-cover w-16 h-16 mr-3 rounded-full">
          @endif
          <h3 class="text-2xl font-bold font-heading">{{ $website->name ?? 'DOSVE' }}</h3>
        </div>
        <p class="mb-6 text-gray-400">
          {{ $website->description ?? 'Desarrollamos sistemas que impulsan tu negocio. Soluciones tecnológicas a la medida de tu empresa.' }}
        </p>
      </div>

      {{-- Column 2: Services --}}
      <div>
        <h4 class="mb-6 text-lg font-bold font-heading">Servicios</h4>
        <ul class="space-y-3">
          <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Desarrollo de Software</a></li>
          <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Aplicaciones Web</a></li>
          <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Sistemas Empresariales</a></li>
          <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Aplicaciones Móviles</a></li>
        </ul>
      </div>

      {{-- Column 3: Projects --}}
      <div>
        <h4 class="mb-6 text-lg font-bold font-heading">Proyectos</h4>
        <ul class="space-y-3">
          <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Segundos App</a></li>
          <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Yo Compro Acacías</a></li>
          <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Admin Negocios</a></li>
          <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">EME10</a></li>
        </ul>
      </div>

      {{-- Column 4: Contact --}}
      <div>
        <h4 class="mb-6 text-lg font-bold font-heading">Contacto</h4>
        <div class="space-y-3 text-gray-400">
          @if(isset($templateConfig) && !empty($templateConfig->settings['contact_phone'] ?? null))
          <p>{{ $templateConfig->settings['contact_phone'] }}</p>
          @else
          <p>311 323 03 41</p>
          @endif

          @if(isset($templateConfig) && !empty($templateConfig->settings['contact_email'] ?? null))
          <p><a href="mailto:{{ $templateConfig->settings['contact_email'] }}" class="transition-colors hover:text-white">{{ $templateConfig->settings['contact_email'] }}</a></p>
          @else
          <p><a href="mailto:gerencia@dosve.co" class="transition-colors hover:text-white">gerencia@dosve.co</a></p>
          @endif

          @if(isset($templateConfig) && !empty($templateConfig->settings['contact_address'] ?? null))
          <p>{{ $templateConfig->settings['contact_address'] }}</p>
          @else
          <p>Carrera 45a #16-05, Bogotá DC</p>
          @endif

          <p>www.dosve.co</p>
        </div>
      </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="pt-8 mt-12 text-center border-t border-gray-800">
      <p class="text-gray-400">
        © {{ date('Y') }} {{ $website->name ?? 'Dosve' }}. Todos los derechos reservados.
      </p>
      <p class="mt-2 text-sm text-gray-500">
        Creado con <a href="https://eme10.com" target="_blank" class="font-medium transition-colors hover:text-white" style="color: {{ $customization['colors']['primary'] ?? '#2563EB' }};">EME10</a> |
        <a href="https://adminnegocios.com" target="_blank" class="font-medium transition-colors hover:text-white" style="color: {{ $customization['colors']['primary'] ?? '#2563EB' }};">Admin Negocios</a>
      </p>
    </div>
  </div>
</footer>