<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Academia Online'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Nunito', sans-serif
    }

    .font-heading {
      font-family: 'Raleway', sans-serif
    }

    .container {
      max-width: {{$customization['layout']['container_width']??'1200px'}};
    }

  </style>
</head>
<body class="bg-gray-50">@php $h=$customization['header']??[];@endphp @include('templates.academia-online.header')
  <section class="py-20 text-white bg-gradient-to-br from-violet-600 to-blue-600">
    <div class="container px-6 mx-auto text-center">
      <h1 class="mb-6 text-5xl font-bold font-heading md:text-6xl">Aprende Sin Límites</h1>
      <p class="max-w-2xl mx-auto mb-8 text-xl text-violet-100">Miles de cursos online a tu alcance. Desarrolla nuevas habilidades hoy.</p>
      <div class="flex flex-col justify-center gap-4 sm:flex-row">
        <a href="#cursos" class="inline-block px-8 py-4 font-bold bg-white rounded-lg text-violet-600 hover:bg-violet-50">Explorar Cursos</a>
         <a href="{{ route('creator.templates.blog', 'academia-online') }}" class="inline-block px-8 py-4 font-bold text-white transition-colors bg-transparent border-2 border-white rounded-lg hover:bg-white hover:text-violet-600">Ver Blog</a>
         <a href="{{ route('creator.templates.contacto', 'academia-online') }}" class="inline-block px-8 py-4 font-bold text-white rounded-lg bg-violet-500 hover:bg-violet-400">Contacto</a>
      </div>
    </div>
  </section>
  <section id="cursos" class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="mb-12 text-4xl font-bold text-center font-heading">Cursos Populares</h2>
      <div class="grid gap-8 md:grid-cols-3">@for($i=0;$i<6;$i++)<div class="overflow-hidden transition-shadow rounded-lg shadow bg-gray-50 hover:shadow-lg">
          <div class="flex items-center justify-center h-40 bg-gradient-to-br from-violet-400 to-blue-400"><svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg></div>
          <div class="p-6">
            <h3 class="mb-2 text-xl font-bold font-heading">Curso {{$i+1}}</h3>
            <p class="mb-4 text-sm text-gray-600">Descripción del curso online</p>
            <div class="flex items-center justify-between"><span class="text-2xl font-bold text-violet-600">${{49+$i*10}}</span><button class="px-4 py-2 text-sm text-white rounded-lg bg-violet-600 hover:bg-violet-700">Inscribirse</button></div>
          </div>
      </div>@endfor
    </div>
    </div>
  </section>
  
  <!-- Sección de Navegación a Páginas -->
  <section class="py-20 bg-gray-50">
    <div class="container px-6 mx-auto">
      <h2 class="mb-12 text-4xl font-bold text-center font-heading">Explora Nuestro Contenido</h2>
      <div class="grid gap-8 md:grid-cols-3">
        <!-- Blog -->
        <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow-md hover:shadow-lg">
          <div class="flex items-center justify-center h-48 bg-gradient-to-br from-green-500 to-teal-600">
            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
          </div>
          <div class="p-6">
            <h3 class="mb-2 text-xl font-bold font-heading">Blog</h3>
            <p class="mb-4 text-gray-600">Artículos, consejos y recursos para tu aprendizaje</p>
             <a href="{{ route('template.blog', 'academia-online') }}" class="inline-block px-6 py-2 font-medium text-white rounded-lg bg-violet-600 hover:bg-violet-700">Leer Blog</a>
          </div>
        </div>
        
        <!-- Contacto -->
        <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow-md hover:shadow-lg">
          <div class="flex items-center justify-center h-48 bg-gradient-to-br from-blue-500 to-purple-600">
            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="p-6">
            <h3 class="mb-2 text-xl font-bold font-heading">Contacto</h3>
            <p class="mb-4 text-gray-600">¿Tienes preguntas? Estamos aquí para ayudarte</p>
             <a href="{{ route('template.contact', 'academia-online') }}" class="inline-block px-6 py-2 font-medium text-white rounded-lg bg-violet-600 hover:bg-violet-700">Contactar</a>
          </div>
        </div>
        
        <!-- Cursos -->
        <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow-md hover:shadow-lg">
          <div class="flex items-center justify-center h-48 bg-gradient-to-br from-orange-500 to-red-600">
            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          <div class="p-6">
            <h3 class="mb-2 text-xl font-bold font-heading">Cursos</h3>
            <p class="mb-4 text-gray-600">Explora nuestro catálogo completo de cursos</p>
            <a href="#cursos" class="inline-block px-6 py-2 font-medium text-white rounded-lg bg-violet-600 hover:bg-violet-700">Ver Cursos</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  @php $f=$customization['footer']??[];@endphp @include('templates.academia-online.footer')
</body>
</html>
