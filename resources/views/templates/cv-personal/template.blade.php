<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'CV Personal'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif
    }

    .font-heading {
      font-family: 'Space Grotesk', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1100px'
        }
      }
    }

  </style>
</head>
<body class="bg-slate-50">@php $h=$customization['header']??[];@endphp @include('templates.cv-personal.header')
  <section class="py-20 bg-gradient-to-br from-blue-600 to-cyan-500 text-white">
    <div class="container px-6 mx-auto text-center">
      <div class="w-32 h-32 bg-white/20 rounded-full mx-auto mb-6 flex items-center justify-center"><svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg></div>
      <h1 class="font-heading text-5xl md:text-6xl font-bold mb-4">{{$website->name??'Tu Nombre'}}</h1>
      <p class="text-2xl text-blue-100 mb-8">Desarrollador Full Stack</p>
      <div class="flex flex-wrap justify-center gap-4">@for($i=0;$i<3;$i++)<span class="px-4 py-2 bg-white/20 rounded-full text-sm">Skill {{$i+1}}</span>@endfor</div>
    </div>
  </section>
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Experiencia</h2>
      <div class="max-w-3xl mx-auto space-y-8">@for($i=0;$i<3;$i++)<div class="relative pl-8 border-l-2 border-blue-600">
          <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-600 rounded-full"></div>
          <div class="mb-1 text-sm text-slate-500">2020 - 2023</div>
          <h3 class="font-heading text-xl font-bold mb-2">Puesto {{$i+1}}</h3>
          <p class="text-slate-600 mb-2">Empresa XYZ</p>
          <p class="text-slate-700">Descripción de responsabilidades y logros alcanzados.</p>
      </div>@endfor
    </div>
    </div>
  </section>
  <section class="py-20 bg-slate-50">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Habilidades</h2>
      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">@for($i=0;$i<6;$i++)<div>
          <div class="flex justify-between mb-2"><span class="font-medium">Habilidad {{$i+1}}</span><span class="text-slate-500">{{85+$i*2}}%</span></div>
          <div class="h-2 bg-slate-200 rounded-full">
            <div class="h-2 bg-blue-600 rounded-full" style="width:{{85+$i*2}}%"></div>
          </div>
      </div>@endfor
    </div>
    </div>
  </section>
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Educación</h2>
      <div class="max-w-3xl mx-auto space-y-6">@for($i=0;$i<2;$i++)<div class="p-6 bg-slate-50 rounded-lg">
          <h3 class="font-heading text-xl font-bold mb-2">Título Académico</h3>
          <p class="text-slate-600 mb-1">Universidad XYZ</p>
          <p class="text-sm text-slate-500">2015 - 2019</p>
      </div>@endfor
    </div>
    </div>
  </section>
  <section class="py-20 bg-gradient-to-br from-blue-600 to-cyan-500 text-white">
    <div class="container px-6 mx-auto text-center">
      <h2 class="font-heading text-4xl font-bold mb-6">¿Trabajamos juntos?</h2>
      <p class="text-xl text-blue-100 mb-8">Estoy disponible para nuevos proyectos</p><a href="mailto:email@ejemplo.com" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-bold">Contactar</a>
    </div>
  </section>
  @php $f=$customization['footer']??[];@endphp @include('templates.cv-personal.footer')
</body>
</html>
