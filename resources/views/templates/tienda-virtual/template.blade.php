<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $website->name ?? 'Mi Tienda Virtual' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
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
<body class="bg-gray-50">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.tienda-virtual.header')

  <section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container px-4 mx-auto text-center">
      <h2 class="mb-4 text-4xl font-bold">Bienvenido a Nuestra Tienda</h2>
      <p class="mb-8 text-xl">Descubre productos increíbles a precios increíbles</p>
      <button class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Ver Productos</button>
    </div>
  </section>

  <section class="py-16 bg-gray-50 products-list" data-products-source="api" data-dynamic-products="true">
    <div class="container px-4 mx-auto">
      <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Nuestros Productos</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="products-container">
        <!-- Los productos se cargarán dinámicamente aquí -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
          <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 1</h3>
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$99.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 1" data-price="99.99">
              Agregar al Carrito
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.tienda-virtual.footer')

  <!-- Sidebar del Carrito -->
  <div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-96">
    <div class="flex flex-col h-full">
      <div class="flex items-center justify-between p-4 border-b bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900">Carrito de Compras</h3>
        <button id="close-cart" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="flex-1 p-4 overflow-y-auto">
        <div id="cart-items" class="space-y-4">
          <div class="py-8 text-center text-gray-500">
            <p>Tu carrito está vacío</p>
          </div>
        </div>
      </div>
      <div class="p-4 border-t bg-gray-50">
        <div class="flex items-center justify-between mb-4">
          <span class="text-lg font-semibold">Total:</span>
          <span id="cart-total" class="text-xl font-bold text-green-600">$0.00</span>
        </div>
        <button id="checkout-btn" class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
          Proceder al Pago
        </button>
      </div>
    </div>
  </div>

  <div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50"></div>
  <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
  @include('templates.partials.cart-script')
  @include('templates.partials.products-script')
</body>
</html>
