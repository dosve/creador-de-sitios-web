<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Conferencia 2025'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Ubuntu', sans-serif
    }

    .font-heading {
      font-family: 'Montserrat', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1300px'
        }
      }
    }

  </style>
</head>
<body class="bg-purple-50">@include('templates.evento-conferencia.header')
  <section class="relative bg-gradient-to-br from-purple-600 via-pink-600 to-purple-700 text-white py-20 md:py-32">
    <div class="container px-6 mx-auto text-center">
      <div class="inline-block px-6 py-2 bg-white/20 rounded-full mb-6 font-bold">15-17 MARZO 2025</div>
      <h1 class="font-heading text-6xl md:text-8xl font-bold mb-6">{{$website->name??'TECH SUMMIT 2025'}}</h1>
      <p class="text-2xl md:text-3xl mb-12 text-purple-100">El evento más grande de tecnología</p>
      <div class="grid grid-cols-4 gap-4 max-w-2xl mx-auto mb-12">@for($i=0;$i<4;$i++)<div class="bg-white/20 backdrop-blur-sm rounded-lg p-6">
          <div class="text-4xl font-bold mb-2">{{$i*10}}</div>
          <div class="text-sm text-purple-200">{{['Días','Horas','Minutos','Segundos'][$i]}}</div>
      </div>@endfor
    </div><a href="#registro" class="inline-block px-12 py-4 bg-white text-purple-600 rounded-lg hover:bg-purple-50 font-bold text-xl shadow-xl">Registrarse Ahora</a></div>
  </section>
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-5xl font-bold mb-12 text-center">Speakers</h2>
      <div class="grid md:grid-cols-4 gap-8">@for($i=0;$i<8;$i++)<div class="text-center">
          <div class="aspect-square bg-purple-200 rounded-full mb-4 flex items-center justify-center"><svg class="w-20 h-20 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg></div>
          <h3 class="font-heading font-bold mb-1">Speaker {{$i+1}}</h3>
          <p class="text-sm text-gray-600">Experto en Tech</p>
      </div>@endfor
    </div>
    </div>
  </section>
  <section id="registro" class="py-20 bg-gradient-to-br from-purple-600 to-pink-600 text-white">
    <div class="container px-6 mx-auto max-w-2xl">
      <h2 class="font-heading text-5xl font-bold mb-8 text-center">Registro</h2>
      <form class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl">
        <div class="grid md:grid-cols-2 gap-6"><input type="text" placeholder="Nombre" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60"><input type="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60"><input type="text" placeholder="Empresa" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60"><select class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white">
            <option>Tipo de Ticket</option>
          </select></div><button type="submit" class="w-full mt-6 px-8 py-4 bg-white text-purple-600 rounded-lg hover:bg-purple-50 font-bold text-lg">Confirmar Registro</button>
      </form>
    </div>
  </section>
  @include('templates.evento-conferencia.footer')
</body>
</html>
