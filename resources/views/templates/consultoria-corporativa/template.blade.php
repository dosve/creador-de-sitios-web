<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Consultoría Corporativa' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }

    .font-heading {
      font-family: 'Merriweather', serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }

      ;
    }

  </style>
</head>
<body class="bg-slate-50">
  @php $headerConfig = $customization['header'] ?? []; @endphp
  @include('templates.consultoria-corporativa.header')

  {{-- Hero --}}
  <section class="bg-gradient-to-br from-blue-900 to-slate-800 text-white py-20 md:py-32">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h1 class="font-heading text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Soluciones Estratégicas para tu Empresa
          </h1>
          <p class="text-xl text-blue-100 mb-8 leading-relaxed">
            Más de 20 años ayudando a empresas a alcanzar sus objetivos con estrategias probadas y resultados medibles.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#contacto" class="px-8 py-4 bg-white text-blue-900 rounded-md hover:bg-blue-50 transition-colors font-semibold text-center">
              Solicitar Consulta
            </a>
            <a href="#servicios" class="px-8 py-4 border-2 border-white text-white rounded-md hover:bg-white hover:text-blue-900 transition-colors font-semibold text-center">
              Nuestros Servicios
            </a>
          </div>
        </div>
        <div class="bg-blue-800/30 backdrop-blur-sm rounded-2xl p-8 border border-blue-700/50">
          <div class="grid grid-cols-2 gap-6 text-center">
            <div>
              <div class="text-4xl font-bold mb-2">20+</div>
              <div class="text-blue-200 text-sm">Años Experiencia</div>
            </div>
            <div>
              <div class="text-4xl font-bold mb-2">500+</div>
              <div class="text-blue-200 text-sm">Clientes</div>
            </div>
            <div>
              <div class="text-4xl font-bold mb-2">95%</div>
              <div class="text-blue-200 text-sm">Satisfacción</div>
            </div>
            <div>
              <div class="text-4xl font-bold mb-2">50+</div>
              <div class="text-blue-200 text-sm">Especialistas</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Services --}}
  <section id="servicios" class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-4xl md:text-5xl font-bold mb-4">Nuestros Servicios</h2>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
          Ofrecemos soluciones integrales adaptadas a las necesidades de tu organización
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-8 bg-slate-50 rounded-lg border border-slate-200 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-blue-900 text-white rounded-lg flex items-center justify-center mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Estrategia Empresarial</h3>
          <p class="text-slate-600">Desarrollamos planes estratégicos alineados con tu visión y objetivos corporativos.</p>
        </div>
        <div class="p-8 bg-slate-50 rounded-lg border border-slate-200 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-blue-900 text-white rounded-lg flex items-center justify-center mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Gestión de Cambio</h3>
          <p class="text-slate-600">Acompañamos procesos de transformación organizacional con metodologías probadas.</p>
        </div>
        <div class="p-8 bg-slate-50 rounded-lg border border-slate-200 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-blue-900 text-white rounded-lg flex items-center justify-center mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Auditoría y Cumplimiento</h3>
          <p class="text-slate-600">Evaluamos procesos y aseguramos el cumplimiento normativo de tu organización.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Testimonials --}}
  <section class="py-20 bg-slate-50">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-4xl md:text-5xl font-bold mb-4">Lo Que Dicen Nuestros Clientes</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        @for($i = 0; $i < 3; $i++) <div class="bg-white p-8 rounded-lg shadow-sm border border-slate-200">
          <div class="flex mb-4">
            @for($j = 0; $j < 5; $j++) <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              @endfor
          </div>
          <p class="text-slate-600 mb-6 italic">"Excelente servicio profesional. Los resultados superaron nuestras expectativas."</p>
          <div class="flex items-center">
            <div class="w-12 h-12 bg-slate-200 rounded-full mr-4"></div>
            <div>
              <div class="font-semibold">Cliente {{ $i + 1 }}</div>
              <div class="text-sm text-slate-500">CEO, Empresa</div>
            </div>
          </div>
      </div>
      @endfor
    </div>
    </div>
  </section>

  {{-- CTA --}}
  <section id="contacto" class="py-20 bg-blue-900 text-white">
    <div class="container px-6 mx-auto text-center">
      <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6">¿Listo para Transformar tu Empresa?</h2>
      <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
        Agenda una consulta gratuita y descubre cómo podemos ayudarte
      </p>
      <a href="mailto:info@consultoria.com" class="inline-flex px-8 py-4 bg-white text-blue-900 rounded-md hover:bg-blue-50 transition-colors font-semibold">
        Contactar Ahora
      </a>
    </div>
  </section>

  @php $footerConfig = $customization['footer'] ?? []; @endphp
  @include('templates.consultoria-corporativa.footer')
</body>
</html>
