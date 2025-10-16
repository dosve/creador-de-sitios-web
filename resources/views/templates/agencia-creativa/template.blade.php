<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Agencia Creativa' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-heading {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1280px'
        }
      }

      ;
    }

  </style>
</head>
<body class="antialiased bg-white">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.agencia-creativa.header')

  {{-- Hero Section --}}
  <section class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 py-20 md:py-32">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h1 class="font-heading text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Creamos <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">experiencias</span> digitales increíbles
          </h1>
          <p class="text-xl text-gray-600 mb-8 leading-relaxed">
            Somos una agencia creativa especializada en transformar ideas en realidades digitales que impulsan tu negocio.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#portfolio" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-xl transform hover:scale-105 transition-all font-medium text-center">
              Ver Proyectos
            </a>
            <a href="#contacto" class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-purple-600 hover:text-purple-600 transition-colors font-medium text-center">
              Hablemos
            </a>
          </div>
        </div>
        <div class="relative">
          <div class="aspect-square bg-gradient-to-br from-purple-200 to-pink-200 rounded-3xl flex items-center justify-center">
            <svg class="w-48 h-48 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full opacity-50"></div>
          <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full opacity-30"></div>
        </div>
      </div>
    </div>
  </section>

  {{-- Services Section --}}
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Nuestros Servicios</span>
        <h2 class="font-heading text-4xl md:text-5xl font-bold mt-4 mb-6">¿Qué hacemos?</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Ofrecemos soluciones creativas integrales para hacer crecer tu marca
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        {{-- Service 1 --}}
        <div class="group p-8 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl hover:shadow-xl transition-all cursor-pointer">
          <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Diseño Web</h3>
          <p class="text-gray-600">Interfaces modernas y funcionales que convierten visitantes en clientes</p>
        </div>

        {{-- Service 2 --}}
        <div class="group p-8 bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl hover:shadow-xl transition-all cursor-pointer">
          <div class="w-16 h-16 bg-gradient-to-br from-pink-600 to-pink-700 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Desarrollo</h3>
          <p class="text-gray-600">Aplicaciones web robustas con las últimas tecnologías</p>
        </div>

        {{-- Service 3 --}}
        <div class="group p-8 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl hover:shadow-xl transition-all cursor-pointer">
          <div class="w-16 h-16 bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Branding</h3>
          <p class="text-gray-600">Identidades visuales únicas que destacan tu marca</p>
        </div>

        {{-- Service 4 --}}
        <div class="group p-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl hover:shadow-xl transition-all cursor-pointer">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl font-bold mb-3">Marketing</h3>
          <p class="text-gray-600">Estrategias digitales que generan resultados reales</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Portfolio Section --}}
  <section id="portfolio" class="py-20 bg-gray-50">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Portfolio</span>
        <h2 class="font-heading text-4xl md:text-5xl font-bold mt-4 mb-6">Proyectos Destacados</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Algunos de nuestros trabajos más recientes
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @for($i = 0; $i < 6; $i++) <div class="group relative overflow-hidden rounded-2xl cursor-pointer">
          <div class="aspect-[4/3] bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
            <div class="text-white">
              <h3 class="font-heading text-xl font-bold mb-2">Proyecto {{ $i + 1 }}</h3>
              <p class="text-sm text-gray-300">Diseño Web · Desarrollo</p>
            </div>
          </div>
      </div>
      @endfor
    </div>
    </div>
  </section>

  {{-- CTA Section --}}
  <section id="contacto" class="py-20 bg-gradient-to-br from-purple-600 to-pink-600 text-white">
    <div class="container px-6 mx-auto text-center">
      <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6">
        ¿Listo para empezar tu proyecto?
      </h2>
      <p class="text-xl mb-12 text-purple-100 max-w-2xl mx-auto">
        Hablemos sobre tu idea y hagamos algo increíble juntos
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="mailto:hola@agencia.com" class="px-8 py-4 bg-white text-purple-600 rounded-lg hover:shadow-xl transform hover:scale-105 transition-all font-medium">
          Enviar Email
        </a>
        <a href="tel:+123456789" class="px-8 py-4 bg-purple-700/50 border-2 border-white text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
          Llamar Ahora
        </a>
      </div>
    </div>
  </section>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.agencia-creativa.footer')
</body>
</html>
