<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Gimnasio' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif
    }

    .font-heading {
      font-family: 'Bebas Neue', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1280px'
        }
      }
    }

  </style>
</head>
<body class="bg-gray-900 text-white">@php $h=$customization['header']??[];@endphp @include('templates.gimnasio-fitness.header')
  <section class="relative h-screen flex items-center bg-gradient-to-br from-red-900 to-gray-900">
    <div class="container px-6 mx-auto">
      <h1 class="font-heading text-7xl md:text-9xl font-bold mb-6">TRANSFORMA<br>TU CUERPO</h1>
      <p class="text-2xl mb-8 text-red-200">Alcanza tus metas con nosotros</p><a href="#planes" class="inline-block px-12 py-4 bg-red-600 hover:bg-red-700 transition-colors font-bold text-xl">PRUEBA GRATIS</a>
    </div>
  </section>
  <section class="py-20 bg-gray-800">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-6xl mb-4">CLASES</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-8">@for($i=0;$i<3;$i++)<div class="bg-gray-900 p-8 hover:bg-red-900 transition-colors cursor-pointer">
          <h3 class="font-heading text-3xl mb-3">CLASE {{$i+1}}</h3>
          <p class="text-gray-400">Entrenamiento intensivo</p>
      </div>@endfor
    </div>
    </div>
  </section>
  <section id="planes" class="py-20 bg-gradient-to-br from-gray-900 to-black">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-6xl mb-4">PLANES</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-8">@for($i=0;$i<3;$i++)<div class="bg-gray-800 p-8 rounded-lg border-2 border-gray-700 hover:border-red-600 transition-colors">
          <h3 class="font-heading text-4xl mb-4">PLAN {{$i+1}}</h3>
          <div class="text-5xl font-bold mb-6">${{($i+1)*30}}<span class="text-lg">/mes</span></div>
          <ul class="space-y-3 mb-8 text-gray-400">@for($j=0;$j<3;$j++)<li>✓ Beneficio {{$j+1}}</li>@endfor</ul><button class="w-full py-4 bg-red-600 hover:bg-red-700 transition-colors font-bold">COMPRAR</button></div>@endfor
    </div>
    </div>
  </section>
  @php $f=$customization['footer']??[];@endphp @include('templates.gimnasio-fitness.footer')
</body>
</html>
