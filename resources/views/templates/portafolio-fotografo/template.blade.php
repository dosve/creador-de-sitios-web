<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Fotógrafo'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;600&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif
    }

    .font-heading {
      font-family: 'Oswald', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1600px'
        }
      }
    }

  </style>
</head>
<body class="bg-white">@php $h=$customization['header']??[];@endphp @include('templates.portafolio-fotografo.header')
  <section class="h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center px-6">
      <h1 class="font-heading text-6xl md:text-8xl font-light mb-6 tracking-wider">{{strtoupper($website->name??'FOTOGRAFÍA')}}</h1>
      <p class="text-xl text-gray-600 mb-8">Capturando historias visuales</p><a href="#galeria" class="inline-block px-8 py-3 border-2 border-black hover:bg-black hover:text-white transition-all">VER PORTFOLIO</a>
    </div>
  </section>
  <section id="galeria" class="py-20">
    <div class="container px-6 mx-auto">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">@for($i=0;$i<12;$i++)<div class="aspect-square bg-gray-200 hover:opacity-75 transition-opacity cursor-pointer flex items-center justify-center"><svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg></div>@endfor
    </div>
    </div>
  </section>
  <section class="py-20 bg-gray-50">
    <div class="container px-6 mx-auto max-w-4xl text-center">
      <h2 class="font-heading text-4xl md:text-5xl font-light mb-8 tracking-wider">SOBRE MÍ</h2>
      <p class="text-lg text-gray-600 leading-relaxed mb-8">Fotógrafo profesional especializado en capturar momentos únicos y crear historias visuales impactantes. Mi pasión es transformar instantes en recuerdos eternos.</p><a href="#contacto" class="inline-block px-8 py-3 bg-black text-white hover:bg-gray-800 transition-colors">CONTACTO</a>
    </div>
  </section>
  @php $f=$customization['footer']??[];@endphp @include('templates.portafolio-fotografo.footer')
</body>
</html>
