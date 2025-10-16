<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Boutique' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      letter-spacing: 0.02em;
    }

    .font-display {
      font-family: 'Cormorant Garamond', serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1400px'
        }
      }

      ;
    }

  </style>
</head>
<body class="antialiased bg-white text-gray-900">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.moda-boutique.header')

  {{-- Hero Full Screen --}}
  <section class="relative h-screen flex items-center justify-center bg-gray-100">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
    <div class="relative z-10 text-center px-6">
      <h1 class="font-display text-6xl md:text-8xl font-light mb-6 tracking-wide">
        Nueva Colección
      </h1>
      <p class="text-xl md:text-2xl mb-12 text-gray-700 tracking-wide">
        OTOÑO / INVIERNO 2025
      </p>
      <a href="#coleccion" class="inline-block px-12 py-4 bg-black text-white hover:bg-gray-800 transition-colors tracking-widest text-sm">
        DESCUBRIR
      </a>
    </div>
    {{-- Placeholder para imagen --}}
    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
      <svg class="w-40 h-40 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
    </div>
  </section>

  {{-- Featured Categories --}}
  <section class="py-24">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 gap-6">
        {{-- Women --}}
        <div class="group relative aspect-[3/4] overflow-hidden cursor-pointer">
          <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
            <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all duration-500"></div>
          <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
            <h3 class="font-display text-5xl font-light mb-4">Mujer</h3>
            <span class="tracking-widest text-sm border-b border-white/50 pb-1 group-hover:border-white transition-colors">EXPLORAR</span>
          </div>
        </div>

        {{-- Men --}}
        <div class="group relative aspect-[3/4] overflow-hidden cursor-pointer">
          <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
            <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all duration-500"></div>
          <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
            <h3 class="font-display text-5xl font-light mb-4">Hombre</h3>
            <span class="tracking-widest text-sm border-b border-white/50 pb-1 group-hover:border-white transition-colors">EXPLORAR</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Lookbook Section --}}
  <section id="coleccion" class="py-24 bg-gray-50">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-display text-5xl md:text-6xl font-light mb-4">Lookbook</h2>
        <p class="text-gray-600 tracking-wide">COLECCIÓN OTOÑO/INVIERNO</p>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 aspect-[16/10] bg-gray-100 flex items-center justify-center">
          <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <div class="aspect-[4/5] bg-gray-100 flex items-center justify-center">
          <svg class="w-24 h-24 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <div class="aspect-[4/5] bg-gray-100 flex items-center justify-center">
          <svg class="w-24 h-24 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <div class="md:col-span-2 aspect-[16/10] bg-gray-100 flex items-center justify-center">
          <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
      </div>
    </div>
  </section>

  {{-- Products Grid --}}
  <section class="py-24" data-products-source="api" data-dynamic-products="true">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-display text-5xl md:text-6xl font-light mb-4">Nuestra Selección</h2>
        <p class="text-gray-600 tracking-wide">PIEZAS ESENCIALES</p>
      </div>

      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8" id="products-container">
        {{-- Product ejemplo --}}
        <div class="group">
          <div class="aspect-[3/4] bg-gray-100 mb-6 overflow-hidden">
            <div class="w-full h-full flex items-center justify-center">
              <svg class="w-20 h-20 text-gray-200 group-hover:scale-110 transition-transform duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-sm tracking-wider mb-2">PRENDA ELEGANTE</h3>
            <p class="text-xs text-gray-500 mb-3">Descripción breve</p>
            <p class="text-lg font-light mb-4">$250</p>
            <button class="w-full py-3 border border-black hover:bg-black hover:text-white transition-all tracking-widest text-xs add-to-cart" data-name="Prenda Elegante" data-price="250">
              AGREGAR
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Quote Section --}}
  <section class="py-32 bg-gray-50">
    <div class="container px-6 mx-auto max-w-3xl text-center">
      <p class="font-display text-3xl md:text-4xl font-light mb-8 leading-relaxed">
        "La moda es la armadura para sobrevivir la realidad cotidiana."
      </p>
      <p class="text-sm tracking-widest text-gray-500">— BILL CUNNINGHAM</p>
    </div>
  </section>

  {{-- Instagram Feed --}}
  <section class="py-24">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-display text-5xl md:text-6xl font-light mb-4">@{{ strtolower($website->name ?? 'boutique') }}</h2>
        <p class="text-gray-600 tracking-wide">SÍGUENOS EN INSTAGRAM</p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @for($i = 0; $i < 8; $i++) <div class="aspect-square bg-gray-100 hover:opacity-75 transition-opacity cursor-pointer flex items-center justify-center">
          <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
      </div>
      @endfor
    </div>
    </div>
  </section>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.moda-boutique.footer')

  {{-- Cart Sidebar --}}
  <div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 w-full max-w-md transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-2xl">
    <div class="flex flex-col h-full">
      <div class="flex items-center justify-between p-6 border-b">
        <h3 class="text-xl font-light tracking-widest">TU BOLSA</h3>
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
      <div class="p-6 border-t">
        <div class="flex items-center justify-between mb-6">
          <span class="text-sm tracking-wider">TOTAL</span>
          <span id="cart-total" class="text-2xl font-light">$0.00</span>
        </div>
        <button id="checkout-btn" class="w-full py-4 bg-black text-white hover:bg-gray-800 transition-colors tracking-widest text-sm disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
          FINALIZAR COMPRA
        </button>
      </div>
    </div>
  </div>

  <div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black/30"></div>
  <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
  @include('templates.partials.cart-script')
  @include('templates.partials.products-script')
</body>
</html>
