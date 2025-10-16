<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Clínica Médica'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif
    }

    .font-heading {
      font-family: 'Nunito', sans-serif
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
<body class="bg-cyan-50">@include('templates.medico-clinica.header')
  <section class="bg-gradient-to-br from-cyan-700 to-blue-800 text-white py-20">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h1 class="font-heading text-5xl font-bold mb-6">Tu Salud es Nuestra Prioridad</h1>
          <p class="text-xl text-cyan-100 mb-8">Atención médica profesional con tecnología de punta</p><a href="#citas" class="inline-block px-8 py-4 bg-white text-cyan-700 rounded-lg hover:bg-cyan-50 font-bold">Agendar Cita</a>
        </div>
        <div class="bg-cyan-600/30 rounded-2xl p-8 backdrop-blur-sm">
          <h3 class="font-heading text-2xl font-bold mb-6">Horarios de Atención</h3>
          <ul class="space-y-3 text-cyan-100">
            <li>🕐 Lunes - Viernes: 8:00 - 20:00</li>
            <li>🕐 Sábados: 9:00 - 14:00</li>
            <li>🚨 Emergencias: 24/7</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Especialidades</h2>
      <div class="grid md:grid-cols-4 gap-6">@for($i=0;$i<8;$i++)<div class="p-6 bg-cyan-50 rounded-lg text-center hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-cyan-600 text-white rounded-full mx-auto mb-4 flex items-center justify-center"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg></div>
          <h3 class="font-bold text-sm">Especialidad {{$i+1}}</h3>
      </div>@endfor
    </div>
    </div>
  </section>
  <section id="citas" class="py-20 bg-cyan-50">
    <div class="container px-6 mx-auto max-w-2xl">
      <h2 class="font-heading text-4xl font-bold mb-8 text-center">Agendar Cita</h2>
      <form class="bg-white p-8 rounded-lg shadow-sm">
        <div class="grid md:grid-cols-2 gap-6"><input type="text" placeholder="Nombre" class="w-full px-4 py-3 border rounded-lg"><input type="email" placeholder="Email" class="w-full px-4 py-3 border rounded-lg"><input type="tel" placeholder="Teléfono" class="w-full px-4 py-3 border rounded-lg"><input type="date" class="w-full px-4 py-3 border rounded-lg"><select class="w-full px-4 py-3 border rounded-lg">
            <option>Especialidad</option>
          </select><select class="w-full px-4 py-3 border rounded-lg">
            <option>Hora preferida</option>
          </select></div><button type="submit" class="w-full mt-6 px-8 py-4 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 font-bold">Confirmar Cita</button>
      </form>
    </div>
  </section>
  @include('templates.medico-clinica.footer')
</body>
</html>
