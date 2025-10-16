<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Spa & Bienestar' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif
    }

    .font-heading {
      font-family: 'Cinzel', serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }
    }

  </style>
</head>
<body class="bg-stone-50">
  @php $headerConfig = $customization['header'] ?? []; @endphp
  @include('templates.spa-bienestar.header')
  <section class="relative h-screen flex items-center justify-center bg-gradient-to-br from-amber-100 to-stone-100">
    <div class="text-center px-6 z-10">
      <h1 class="font-heading text-6xl md:text-8xl font-light mb-6 text-amber-900">Relájate</h1>
      <p class="text-xl md:text-2xl text-stone-600 mb-12 max-w-2xl mx-auto">Descubre un oasis de tranquilidad y bienestar</p>
      <a href="#reservas" class="inline-block px-12 py-4 bg-amber-700 text-white rounded-full hover:bg-amber-800 transition-colors">Reservar Cita</a>
    </div>
  </section>
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-4xl md:text-5xl font-light mb-4 text-amber-900">Nuestros Tratamientos</h2>
        <p class="text-xl text-stone-600">Cuidado personalizado para tu bienestar</p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center p-8 bg-stone-50 rounded-2xl hover:shadow-lg transition-shadow">
          <div class="w-16 h-16 bg-amber-200 rounded-full mx-auto mb-6 flex items-center justify-center">
            <svg class="w-8 h-8 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-3">Masajes</h3>
          <p class="text-stone-600">Técnicas de relajación profunda</p>
        </div>
        <div class="text-center p-8 bg-stone-50 rounded-2xl hover:shadow-lg transition-shadow">
          <div class="w-16 h-16 bg-green-200 rounded-full mx-auto mb-6 flex items-center justify-center">
            <svg class="w-8 h-8 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-3">Faciales</h3>
          <p class="text-stone-600">Tratamientos para tu piel</p>
        </div>
        <div class="text-center p-8 bg-stone-50 rounded-2xl hover:shadow-lg transition-shadow">
          <div class="w-16 h-16 bg-blue-200 rounded-full mx-auto mb-6 flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-3">Aromaterapia</h3>
          <p class="text-stone-600">Esencias naturales</p>
        </div>
      </div>
    </div>
  </section>
  <section id="reservas" class="py-20 bg-gradient-to-br from-amber-50 to-stone-50">
    <div class="container px-6 mx-auto max-w-2xl">
      <div class="text-center mb-12">
        <h2 class="font-heading text-4xl font-light mb-4 text-amber-900">Reserva tu Cita</h2>
      </div>
      <form class="bg-white p-8 rounded-2xl shadow-lg">
        <div class="grid md:grid-cols-2 gap-6">
          <input type="text" placeholder="Nombre" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
          <input type="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
          <input type="tel" placeholder="Teléfono" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
          <input type="date" class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
          <select class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
            <option>Masaje Relajante</option>
            <option>Facial</option>
            <option>Aromaterapia</option>
          </select>
          <select class="w-full px-4 py-3 rounded-lg border border-stone-200 focus:border-amber-500 outline-none">
            <option>10:00</option>
            <option>14:00</option>
            <option>18:00</option>
          </select>
        </div>
        <button type="submit" class="w-full mt-6 px-8 py-4 bg-amber-700 text-white rounded-full hover:bg-amber-800 transition-colors font-light">Confirmar Reserva</button>
      </form>
    </div>
  </section>
  @php $footerConfig = $customization['footer'] ?? []; @endphp
  @include('templates.spa-bienestar.footer')
</body>
</html>
