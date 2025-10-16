<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Tienda Minimalista' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }

      ;
    }

    .hero-gradient {
      background: linear-gradient(135deg, #f5f5f7 0%, #ffffff 100%);
    }

  </style>
</head>
<body class="antialiased bg-white text-gray-900">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.header')

  {{-- Hero Section --}}
  <section class="hero-gradient min-h-[600px] flex items-center">
    <div class="container px-6 mx-auto">
      <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-gray-900 mb-6">
          {{ $website->name ?? 'Diseño. Elegancia.' }}
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 mb-12 font-light">
          Descubre productos extraordinarios con un diseño minimalista y atención al detalle.
        </p>
        <div class="flex items-center justify-center gap-6">
          <a href="#productos" class="px-8 py-4 text-white bg-black rounded-full hover:bg-gray-800 transition-all text-lg font-medium">
            Explorar
          </a>
          <a href="#" class="px-8 py-4 text-blue-600 hover:text-blue-700 transition-colors text-lg font-medium">
            Ver más →
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Featured Product --}}
  <section class="py-24">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-16 items-center">
        <div>
          <div class="aspect-square bg-gray-100 rounded-3xl flex items-center justify-center">
            <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
        <div>
          <h2 class="text-4xl md:text-5xl font-bold mb-6">Producto Destacado</h2>
          <p class="text-xl text-gray-600 mb-8 leading-relaxed">
            Experimenta la perfección en cada detalle. Diseñado para personas que aprecian la calidad excepcional.
          </p>
          <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-lg font-medium">
            Conocer más
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Products Grid --}}
  <section id="productos" class="py-24 bg-gray-50" data-products-source="api" data-dynamic-products="true">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Nuestra Colección</h2>
        <p class="text-xl text-gray-600">Productos cuidadosamente seleccionados</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-12" id="products-container">
        {{-- Producto de ejemplo --}}
        <div class="group">
          <div class="aspect-square bg-white rounded-2xl mb-6 flex items-center justify-center overflow-hidden">
            <svg class="w-24 h-24 text-gray-200 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-2">Producto</h3>
          <p class="text-gray-500 mb-4">Descripción breve</p>
          <div class="flex items-center justify-between">
            <span class="text-2xl font-bold">$299</span>
            <button class="px-6 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors add-to-cart" data-name="Producto" data-price="299">
              Comprar
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Feature Section --}}
  <section class="py-24">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-16 text-center">
        <div>
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-gray-100">
            <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Calidad Premium</h3>
          <p class="text-gray-600">Materiales de la más alta calidad en cada producto</p>
        </div>

        <div>
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-gray-100">
            <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Envío Gratis</h3>
          <p class="text-gray-600">En todos los pedidos sin mínimo de compra</p>
        </div>

        <div>
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-gray-100">
            <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Garantía Extendida</h3>
          <p class="text-gray-600">2 años de garantía en todos nuestros productos</p>
        </div>
      </div>
    </div>
  </section>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.footer')

  {{-- Cart Sidebar --}}
  <div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 w-full max-w-md transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-2xl">
    <div class="flex flex-col h-full">
      <div class="flex items-center justify-between p-6 border-b">
        <h3 class="text-2xl font-semibold">Tu Bolsa</h3>
        <button id="close-cart" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="flex-1 p-6 overflow-y-auto">
        <div id="cart-items" class="space-y-4">
          <div class="py-12 text-center text-gray-500">
            <p>Tu bolsa está vacía</p>
          </div>
        </div>
      </div>
      <div class="p-6 border-t bg-gray-50">
        <div class="flex items-center justify-between mb-6">
          <span class="text-lg font-medium">Total</span>
          <span id="cart-total" class="text-2xl font-bold">$0.00</span>
        </div>
        <button id="checkout-btn" class="w-full py-4 text-white bg-black rounded-full hover:bg-gray-800 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
          Proceder al Pago
        </button>
      </div>
    </div>
  </div>

  <div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black/30 backdrop-blur-sm"></div>
  <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
  @include('templates.partials.cart-script')
  @include('templates.partials.products-script')
</body>
</html>
