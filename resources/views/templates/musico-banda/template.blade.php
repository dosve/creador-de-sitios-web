<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Músico'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto Condensed', sans-serif;
      background: #0a0a0a;
      color: #f5f5f5
    }

    .font-heading {
      font-family: 'Bebas Neue', sans-serif
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
<body>@include('templates.musico-banda.header')
  <section class="relative h-screen flex items-center justify-center bg-gradient-to-br from-red-900 to-black">
    <div class="absolute inset-0 bg-[url('/pattern.png')] opacity-10"></div>
    <div class="relative text-center px-6">
      <h1 class="font-heading text-8xl md:text-9xl font-bold mb-6">{{strtoupper($website->name??'ROCK')}}</h1>
      <p class="text-2xl mb-12 text-red-200">NUEVO ÁLBUM DISPONIBLE</p><a href="#musica" class="inline-block px-12 py-4 bg-red-600 hover:bg-red-700 transition-colors font-bold text-xl">ESCUCHAR AHORA</a>
    </div>
  </section>
  <section id="musica" class="py-20 bg-gray-900">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-6xl text-center mb-12">MÚSICA</h2>
      <div class="max-w-2xl mx-auto bg-black p-8 rounded-lg">
        <div class="space-y-4">@for($i=0;$i<5;$i++)<div class="flex items-center justify-between p-4 bg-gray-900 rounded hover:bg-gray-800 transition-colors cursor-pointer">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-red-600 rounded flex items-center justify-center"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" /></svg></div>
              <div>
                <div class="font-bold">Track {{$i+1}}</div>
                <div class="text-sm text-gray-400">3:45</div>
              </div>
            </div>
        </div>@endfor
      </div>
    </div>
    </div>
  </section>
  <section id="tour" class="py-20 bg-black">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-6xl text-center mb-12">TOUR</h2>
      <div class="max-w-3xl mx-auto space-y-4">@for($i=0;$i<5;$i++)<div class="flex flex-col md:flex-row items-center justify-between p-6 bg-gray-900 rounded-lg">
          <div class="text-center md:text-left mb-4 md:mb-0">
            <div class="font-heading text-2xl">15 NOV</div>
            <div class="text-gray-400">Ciudad {{$i+1}}</div>
          </div><button class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded font-bold">COMPRAR TICKETS</button></div>@endfor
    </div>
    </div>
  </section>
  @include('templates.musico-banda.footer')
</body>
</html>
