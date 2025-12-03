{{-- 
  ========================================
  🛍️ WIDGETS DE TIENDA / E-COMMERCE
  ========================================
  Categoría: Tienda
  Widgets: 7 (Lista de Productos, Grid, Carrito, etc.)
--}}

{{-- Widget 1: Lista de Productos Dinámicos (Con API) --}}
{
  id: 'products-list-dynamic',
  label: '🛍️ Listado de Productos',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-products',
    title: 'Listado dinámico de productos desde tu API con estilos adaptativos'
  },
  content: `<section class="py-16 bg-gray-50 products-list" data-products-source="api" data-dynamic-products="true">
    <div class="container px-4 mx-auto">
      <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Nuestros Productos</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4" id="products-container">
        <!-- Los productos se cargarán dinámicamente aquí con estilos según tu plantilla -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
          <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 1</h3>
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa con los estilos de tu plantilla</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$99.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Ver Producto
            </button>
          </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
          <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 2</h3>
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa con los estilos de tu plantilla</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$149.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Ver Producto
            </button>
          </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
          <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 3</h3>
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa con los estilos de tu plantilla</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$199.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Ver Producto
            </button>
          </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
          <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 4</h3>
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa con los estilos de tu plantilla</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$249.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Ver Producto
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>`
},

{{-- Widget 2: Tarjeta de Producto Individual --}}
{
  id: 'product-card',
  label: '📦 Tarjeta de Producto',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-product-card',
    title: 'Tarjeta individual de producto con imagen, precio y botón'
  },
  content: `
    <div class="product-card max-w-sm mx-auto bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
      <div class="relative">
        <div class="product-image w-full h-48 bg-gray-300 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/300x200')"></div>
        <div class="absolute top-2 right-2">
          <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">-20%</span>
        </div>
        <button class="absolute top-2 left-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100">
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
        </button>
      </div>
      <div class="p-4">
        <div class="flex items-center mb-2">
          <div class="flex text-yellow-400 text-sm">★★★★★</div>
          <span class="ml-2 text-sm text-gray-600">(24)</span>
        </div>
        <h3 class="text-lg font-semibold mb-2">Nombre del Producto</h3>
        <p class="text-gray-600 text-sm mb-3">Descripción breve del producto</p>
        <div class="flex justify-between items-center">
          <div>
            <span class="text-xl font-bold text-green-600">$99.99</span>
            <span class="text-sm text-gray-500 line-through ml-2">$124.99</span>
          </div>
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
            Agregar al Carrito
          </button>
        </div>
      </div>
    </div>
  `
},

{{-- Widget 3: Grid de Productos --}}
{
  id: 'product-grid',
  label: '📊 Grid de Productos',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-product-grid',
    title: 'Grid responsive de productos destacados'
  },
  content: `
    <div class="products-grid py-8">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold">Productos Destacados</h2>
          <button class="text-blue-600 hover:text-blue-800 font-medium">Ver Todos →</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="product-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Producto 1</h3>
              <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
              <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-green-600">$29.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Agregar</button>
              </div>
            </div>
          </div>
          <div class="product-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Producto 2</h3>
              <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
              <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-green-600">$39.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Agregar</button>
              </div>
            </div>
          </div>
          <div class="product-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Producto 3</h3>
              <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
              <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-green-600">$49.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Agregar</button>
              </div>
            </div>
          </div>
          <div class="product-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Producto 4</h3>
              <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
              <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-green-600">$59.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Agregar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `
},

{{-- Widget 4: Carrito de Compras --}}
{
  id: 'shopping-cart',
  label: '🛒 Carrito de Compras',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-cart',
    title: 'Carrito de compras con resumen y checkout'
  },
  content: `
    <div class="shopping-cart bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-2xl font-bold mb-6">Carrito de Compras</h2>
      
      <div class="cart-items space-y-4">
        <div class="cart-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 class="font-semibold">Producto 1</h3>
            <p class="text-green-600 font-bold">$29.99</p>
          </div>
          <div class="flex items-center space-x-2">
            <button class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">-</button>
            <span class="w-8 text-center">1</span>
            <button class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">+</button>
          </div>
          <button class="text-red-600 hover:text-red-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </button>
        </div>
      </div>
      
      <div class="cart-summary mt-6 p-4 bg-gray-50 rounded-lg">
        <div class="flex justify-between items-center mb-2">
          <span>Subtotal:</span>
          <span class="font-bold">$109.97</span>
        </div>
        <div class="flex justify-between items-center mb-2">
          <span>Envío:</span>
          <span class="font-bold">$9.99</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between items-center text-lg font-bold">
          <span>Total:</span>
          <span class="text-green-600">$119.96</span>
        </div>
        <button class="w-full mt-4 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
          Proceder al Pago
        </button>
      </div>
    </div>
  `
},

{{-- Widget 5: Filtros de Productos --}}
{
  id: 'product-filters',
  label: '🔍 Filtros de Productos',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-filters',
    title: 'Panel de filtros por precio, categoría, marca y calificación'
  },
  content: `
    <div class="product-filters bg-white p-6 rounded-lg shadow">
      <h3 class="text-lg font-semibold mb-4">Filtrar Productos</h3>
      
      <div class="space-y-6">
        <!-- Filtro por Precio -->
        <div>
          <h4 class="font-medium mb-3">Rango de Precio</h4>
          <div class="space-y-2">
            <div class="flex items-center space-x-2">
              <input type="number" placeholder="Min" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
              <span>-</span>
              <input type="number" placeholder="Max" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
            </div>
            <input type="range" min="0" max="1000" value="500" class="w-full">
          </div>
        </div>
        
        <!-- Filtro por Categoría -->
        <div>
          <h4 class="font-medium mb-3">Categoría</h4>
          <div class="space-y-2">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span>Electrónicos</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span>Ropa</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span>Hogar</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span>Deportes</span>
            </label>
          </div>
        </div>
        
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
          Aplicar Filtros
        </button>
        <button class="w-full bg-gray-300 text-gray-700 py-2 rounded hover:bg-gray-400 transition-colors">
          Limpiar Filtros
        </button>
      </div>
    </div>
  `
},

{{-- Widget 6: Formulario de Checkout --}}
{
  id: 'checkout-form',
  label: '💳 Formulario de Checkout',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-checkout',
    title: 'Formulario completo para finalizar compra'
  },
  content: `
    <div class="checkout-form max-w-4xl mx-auto p-6">
      <h2 class="text-2xl font-bold mb-6">Finalizar Compra</h2>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Información de Envío -->
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold mb-4">Información de Envío</h3>
          <form class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
              <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </form>
        </div>
        
        <!-- Resumen del Pedido -->
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold mb-4">Resumen del Pedido</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span>Producto 1 x 2</span>
              <span>$59.98</span>
            </div>
            <div class="flex justify-between">
              <span>Producto 2 x 1</span>
              <span>$39.99</span>
            </div>
            <hr>
            <div class="flex justify-between text-lg font-bold">
              <span>Total</span>
              <span class="text-green-600">$109.96</span>
            </div>
          </div>
          
          <button class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
            Completar Compra
          </button>
        </div>
      </div>
    </div>
  `
},

{{-- Widget 7: Lista de Deseos --}}
{
  id: 'wishlist',
  label: '❤️ Lista de Deseos',
  category: 'Tienda',
  attributes: {
    class: 'gjs-block-wishlist',
    title: 'Lista de productos favoritos del usuario'
  },
  content: `
    <div class="wishlist bg-white rounded-lg shadow-lg p-6">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Mi Lista de Deseos</h2>
        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">3 productos</span>
      </div>
      
      <div class="wishlist-items space-y-4">
        <div class="wishlist-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 class="font-semibold">Producto Deseado 1</h3>
            <p class="text-green-600 font-bold">$99.99</p>
            <div class="flex text-yellow-400 text-sm mt-1">★★★★★</div>
          </div>
          <div class="flex space-x-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm">
              Agregar al Carrito
            </button>
            <button class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
      
      <div class="mt-6 pt-6 border-t border-gray-200">
        <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
          Agregar Todos al Carrito
        </button>
      </div>
    </div>
  `
}

