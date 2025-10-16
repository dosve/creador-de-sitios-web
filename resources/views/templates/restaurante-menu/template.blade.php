<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Restaurante' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-display {
      font-family: 'Playfair Display', serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }

      ;
    }

  </style>
</head>
<body class="bg-amber-50">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.restaurante-menu.header')

  {{-- Hero Section --}}
  <section class="relative bg-gradient-to-br from-amber-900 to-amber-950 text-white">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative container px-6 py-32 md:py-48 mx-auto text-center">
      <h1 class="font-display text-5xl md:text-7xl font-bold mb-6">
        Experiencia Gastronómica Única
      </h1>
      <p class="text-xl md:text-2xl mb-12 text-amber-100 max-w-2xl mx-auto">
        Sabores auténticos que deleitan el paladar. Bienvenido a tu nuevo restaurante favorito.
      </p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="#menu" class="px-8 py-4 bg-amber-600 hover:bg-amber-700 rounded-lg font-semibold text-lg shadow-lg transition-colors w-full sm:w-auto text-center">
          Ver Menú
        </a>
        <a href="#reservas" class="px-8 py-4 bg-white text-amber-900 hover:bg-amber-50 rounded-lg font-semibold text-lg shadow-lg transition-colors w-full sm:w-auto text-center">
          Reservar Mesa
        </a>
      </div>
    </div>
  </section>

  {{-- About Section --}}
  <section class="py-20 bg-white">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="font-display text-4xl md:text-5xl font-bold text-amber-900 mb-6">
            Nuestra Historia
          </h2>
          <p class="text-lg text-gray-700 mb-6 leading-relaxed">
            Con más de 20 años de tradición, hemos perfeccionado el arte de la cocina auténtica.
            Cada plato es preparado con ingredientes frescos y locales, siguiendo recetas tradicionales
            transmitidas de generación en generación.
          </p>
          <p class="text-lg text-gray-700 leading-relaxed">
            Nuestro compromiso es ofrecerte una experiencia culinaria inolvidable en un ambiente
            cálido y acogedor, donde cada visita se convierte en un momento especial.
          </p>
        </div>
        <div class="aspect-square bg-amber-100 rounded-2xl flex items-center justify-center">
          <svg class="w-32 h-32 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
      </div>
    </div>
  </section>

  {{-- Menu Section --}}
  <section id="menu" class="py-20 bg-amber-50" data-products-source="api" data-dynamic-products="true">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-display text-4xl md:text-5xl font-bold text-amber-900 mb-4">Nuestro Menú</h2>
        <p class="text-xl text-gray-700">Deliciosos platos preparados con amor</p>
      </div>

      {{-- Menu Categories --}}
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <button class="px-6 py-3 bg-amber-600 text-white rounded-full font-medium hover:bg-amber-700 transition-colors">
          Todo
        </button>
        <button class="px-6 py-3 bg-white text-amber-900 rounded-full font-medium hover:bg-amber-100 transition-colors">
          Entradas
        </button>
        <button class="px-6 py-3 bg-white text-amber-900 rounded-full font-medium hover:bg-amber-100 transition-colors">
          Platos Principales
        </button>
        <button class="px-6 py-3 bg-white text-amber-900 rounded-full font-medium hover:bg-amber-100 transition-colors">
          Postres
        </button>
        <button class="px-6 py-3 bg-white text-amber-900 rounded-full font-medium hover:bg-amber-100 transition-colors">
          Bebidas
        </button>
      </div>

      {{-- Menu Items Grid --}}
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="products-container">
        {{-- Plato de ejemplo --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
          <div class="aspect-[4/3] bg-amber-100 flex items-center justify-center">
            <svg class="w-20 h-20 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="p-6">
            <h3 class="font-display text-2xl font-bold text-amber-900 mb-2">Plato Especial</h3>
            <p class="text-gray-600 mb-4">Descripción deliciosa del plato con ingredientes frescos</p>
            <div class="flex items-center justify-between">
              <span class="text-2xl font-bold text-amber-700">$15.99</span>
              <button class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors add-to-cart" data-name="Plato Especial" data-price="15.99">
                Ordenar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Reservations Section --}}
  <section id="reservas" class="py-20 bg-white">
    <div class="container px-6 mx-auto max-w-4xl">
      <div class="text-center mb-12">
        <h2 class="font-display text-4xl md:text-5xl font-bold text-amber-900 mb-4">Reserva tu Mesa</h2>
        <p class="text-xl text-gray-700">Asegura tu lugar en nuestro restaurante</p>
      </div>

      <div class="bg-amber-50 rounded-2xl p-8 md:p-12">
        <form class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
            <input type="text" class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors" placeholder="Tu nombre">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors" placeholder="tu@email.com">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
            <input type="tel" class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors" placeholder="+1 234 567 89">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
            <input type="date" class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Hora</label>
            <select class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors">
              <option>12:00</option>
              <option>13:00</option>
              <option>14:00</option>
              <option>19:00</option>
              <option>20:00</option>
              <option>21:00</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Personas</label>
            <select class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors">
              <option>1 persona</option>
              <option>2 personas</option>
              <option>3 personas</option>
              <option>4 personas</option>
              <option>5+ personas</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios (opcional)</label>
            <textarea rows="3" class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-colors" placeholder="Alguna petición especial..."></textarea>
          </div>
          <div class="md:col-span-2">
            <button type="submit" class="w-full px-8 py-4 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-semibold text-lg shadow-lg">
              Confirmar Reserva
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  {{-- Testimonials --}}
  <section class="py-20 bg-amber-900 text-white">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-12">
        <h2 class="font-display text-4xl md:text-5xl font-bold mb-4">Lo Que Dicen Nuestros Clientes</h2>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-amber-800/50 rounded-2xl p-8">
          <div class="flex mb-4">
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
          </div>
          <p class="text-amber-100 mb-4 italic">"La comida es excepcional y el servicio impecable. Sin duda el mejor restaurante de la ciudad."</p>
          <p class="font-semibold">María González</p>
        </div>

        <div class="bg-amber-800/50 rounded-2xl p-8">
          <div class="flex mb-4">
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
          </div>
          <p class="text-amber-100 mb-4 italic">"Ambiente acogedor y platos deliciosos. Volveremos una y otra vez."</p>
          <p class="font-semibold">Carlos Rodríguez</p>
        </div>

        <div class="bg-amber-800/50 rounded-2xl p-8">
          <div class="flex mb-4">
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
          </div>
          <p class="text-amber-100 mb-4 italic">"Una experiencia gastronómica inolvidable. Los sabores son auténticos y únicos."</p>
          <p class="font-semibold">Ana Martínez</p>
        </div>
      </div>
    </div>
  </section>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.restaurante-menu.footer')

  <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
  @include('templates.partials.cart-script')
  @include('templates.partials.products-script')
</body>
</html>
