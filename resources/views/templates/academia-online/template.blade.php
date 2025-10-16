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
      max-width: {
          {
          $customization['layout']['container_width']??'1200px'
        }
      }
    }

  </style>
</head>
<body class="bg-gray-50">@php $h=$customization['header']??[];@endphp @include('templates.academia-online.header')
  <section class="bg-gradient-to-br from-violet-600 to-blue-600 text-white py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl md:text-6xl font-bold mb-6">Aprende Sin Límites</h1>
      <p class="text-xl text-violet-100 mb-8 max-w-2xl mx-auto">Miles de cursos online a tu alcance. Desarrolla nuevas habilidades hoy.</p><a href="#cursos" class="inline-block px-8 py-4 bg-white text-violet-600 rounded-lg hover:bg-violet-50 font-bold">Explorar Cursos</a>
    </div>
  </section>
  <section id="cursos" class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Cursos Populares</h2>
      <div class="grid md:grid-cols-3 gap-8">@for($i=0;$i<6;$i++)<div class="bg-gray-50 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow">
          <div class="h-40 bg-gradient-to-br from-violet-400 to-blue-400 flex items-center justify-center"><svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg></div>
          <div class="p-6">
            <h3 class="font-heading text-xl font-bold mb-2">Curso {{$i+1}}</h3>
            <p class="text-sm text-gray-600 mb-4">Descripción del curso online</p>
            <div class="flex items-center justify-between"><span class="text-2xl font-bold text-violet-600">${{49+$i*10}}</span><button class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 text-sm">Inscribirse</button></div>
          </div>
      </div>@endfor
    </div>
    </div>
  </section>
  @php $f=$customization['footer']??[];@endphp @include('templates.academia-online.footer')
</body>
</html>
