{{-- Bloques de E-commerce --}}
{
  id: 'product-card',
  label: 'Tarjeta de Producto',
  category: 'E-commerce',
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
          <div class="flex text-yellow-400 text-sm">
            ★★★★★
          </div>
          <span class="ml-2 text-sm text-gray-600">(24)</span>
        </div>
        <h3 data-gjs-type="text" data-gjs-name="product-title" class="text-lg font-semibold mb-2">Nombre del Producto</h3>
        <p data-gjs-type="text" data-gjs-name="product-description" class="text-gray-600 text-sm mb-3">Descripción breve del producto</p>
        <div class="flex justify-between items-center">
          <div>
            <span data-gjs-type="text" data-gjs-name="product-price" class="text-xl font-bold text-green-600">$99.99</span>
            <span data-gjs-type="text" data-gjs-name="product-old-price" class="text-sm text-gray-500 line-through ml-2">$124.99</span>
          </div>
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
            Agregar al Carrito
          </button>
        </div>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'image-url',
      label: 'URL de Imagen',
      placeholder: 'https://ejemplo.com/producto.jpg'
    },
    {
      type: 'text',
      name: 'price',
      label: 'Precio',
      placeholder: '$99.99'
    },
    {
      type: 'text',
      name: 'old-price',
      label: 'Precio Anterior',
      placeholder: '$124.99'
    },
    {
      type: 'text',
      name: 'discount',
      label: 'Descuento (%)',
      placeholder: '20'
    },
    {
      type: 'text',
      name: 'rating',
      label: 'Calificación (1-5)',
      placeholder: '5'
    },
    {
      type: 'text',
      name: 'reviews',
      label: 'Número de Reseñas',
      placeholder: '24'
    }
  ]
},
{
  id: 'product-grid',
  label: 'Grid de Productos',
  category: 'E-commerce',
  content: `
    <div class="products-grid py-8">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 data-gjs-type="text" data-gjs-name="section-title" class="text-2xl font-bold">Productos Destacados</h2>
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
{
  id: 'shopping-cart',
  label: 'Carrito de Compras',
  category: 'E-commerce',
  content: `
    <div class="shopping-cart bg-white rounded-lg shadow-lg p-6">
      <h2 data-gjs-type="text" data-gjs-name="cart-title" class="text-2xl font-bold mb-6">Carrito de Compras</h2>
      
      <div class="cart-items space-y-4">
        <div class="cart-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 data-gjs-type="text" data-gjs-name="item-name" class="font-semibold">Producto 1</h3>
            <p data-gjs-type="text" data-gjs-name="item-price" class="text-green-600 font-bold">$29.99</p>
          </div>
          <div class="flex items-center space-x-2">
            <button class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">-</button>
            <span data-gjs-type="text" data-gjs-name="item-quantity" class="w-8 text-center">1</span>
            <button class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">+</button>
          </div>
          <button class="text-red-600 hover:text-red-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </button>
        </div>
        
        <div class="cart-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 data-gjs-type="text" data-gjs-name="item-name-2" class="font-semibold">Producto 2</h3>
            <p data-gjs-type="text" data-gjs-name="item-price-2" class="text-green-600 font-bold">$39.99</p>
          </div>
          <div class="flex items-center space-x-2">
            <button class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">-</button>
            <span data-gjs-type="text" data-gjs-name="item-quantity-2" class="w-8 text-center">2</span>
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
          <span data-gjs-type="text" data-gjs-name="subtotal" class="font-bold">$109.97</span>
        </div>
        <div class="flex justify-between items-center mb-2">
          <span>Envío:</span>
          <span data-gjs-type="text" data-gjs-name="shipping" class="font-bold">$9.99</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between items-center text-lg font-bold">
          <span>Total:</span>
          <span data-gjs-type="text" data-gjs-name="total" class="text-green-600">$119.96</span>
        </div>
        <button class="w-full mt-4 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
          Proceder al Pago
        </button>
      </div>
    </div>
  `
},
{
  id: 'checkout-form',
  label: 'Formulario de Checkout',
  category: 'E-commerce',
  content: `
    <div class="checkout-form max-w-4xl mx-auto p-6">
      <h2 data-gjs-type="text" data-gjs-name="checkout-title" class="text-2xl font-bold mb-6">Finalizar Compra</h2>
      
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
            <div class="grid grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
          </form>
        </div>
        
        <!-- Resumen del Pedido -->
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold mb-4">Resumen del Pedido</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span>Producto 1 x 2</span>
              <span data-gjs-type="text" data-gjs-name="item-total-1">$59.98</span>
            </div>
            <div class="flex justify-between">
              <span>Producto 2 x 1</span>
              <span data-gjs-type="text" data-gjs-name="item-total-2">$39.99</span>
            </div>
            <div class="flex justify-between">
              <span>Subtotal</span>
              <span data-gjs-type="text" data-gjs-name="checkout-subtotal">$99.97</span>
            </div>
            <div class="flex justify-between">
              <span>Envío</span>
              <span data-gjs-type="text" data-gjs-name="checkout-shipping">$9.99</span>
            </div>
            <hr>
            <div class="flex justify-between text-lg font-bold">
              <span>Total</span>
              <span data-gjs-type="text" data-gjs-name="checkout-total" class="text-green-600">$109.96</span>
            </div>
          </div>
          
          <div class="mt-6">
            <h4 class="font-semibold mb-3">Método de Pago</h4>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="radio" name="payment" value="credit" class="mr-2">
                <span>Tarjeta de Crédito</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="payment" value="paypal" class="mr-2">
                <span>PayPal</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="payment" value="transfer" class="mr-2">
                <span>Transferencia Bancaria</span>
              </label>
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
{
  id: 'product-filters',
  label: 'Filtros de Productos',
  category: 'E-commerce',
  content: `
    <div class="product-filters bg-white p-6 rounded-lg shadow">
      <h3 data-gjs-type="text" data-gjs-name="filters-title" class="text-lg font-semibold mb-4">Filtrar Productos</h3>
      
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
              <span data-gjs-type="text" data-gjs-name="category-1">Electrónicos</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="category-2">Ropa</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="category-3">Hogar</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="category-4">Deportes</span>
            </label>
          </div>
        </div>
        
        <!-- Filtro por Marca -->
        <div>
          <h4 class="font-medium mb-3">Marca</h4>
          <div class="space-y-2">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="brand-1">Apple</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="brand-2">Samsung</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span data-gjs-type="text" data-gjs-name="brand-3">Nike</span>
            </label>
          </div>
        </div>
        
        <!-- Filtro por Calificación -->
        <div>
          <h4 class="font-medium mb-3">Calificación</h4>
          <div class="space-y-2">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span class="flex text-yellow-400">★★★★★</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span class="flex text-yellow-400">★★★★☆</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              <span class="flex text-yellow-400">★★★☆☆</span>
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
{
  id: 'wishlist',
  label: 'Lista de Deseos',
  category: 'E-commerce',
  content: `
    <div class="wishlist bg-white rounded-lg shadow-lg p-6">
      <div class="flex items-center justify-between mb-6">
        <h2 data-gjs-type="text" data-gjs-name="wishlist-title" class="text-2xl font-bold">Mi Lista de Deseos</h2>
        <span data-gjs-type="text" data-gjs-name="wishlist-count" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">3 productos</span>
      </div>
      
      <div class="wishlist-items space-y-4">
        <div class="wishlist-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 data-gjs-type="text" data-gjs-name="wishlist-item-1" class="font-semibold">Producto Deseado 1</h3>
            <p data-gjs-type="text" data-gjs-name="wishlist-price-1" class="text-green-600 font-bold">$99.99</p>
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
        
        <div class="wishlist-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 data-gjs-type="text" data-gjs-name="wishlist-item-2" class="font-semibold">Producto Deseado 2</h3>
            <p data-gjs-type="text" data-gjs-name="wishlist-price-2" class="text-green-600 font-bold">$149.99</p>
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
        
        <div class="wishlist-item flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
          <img src="https://via.placeholder.com/80x80" alt="Producto" class="w-20 h-20 object-cover rounded">
          <div class="flex-1">
            <h3 data-gjs-type="text" data-gjs-name="wishlist-item-3" class="font-semibold">Producto Deseado 3</h3>
            <p data-gjs-type="text" data-gjs-name="wishlist-price-3" class="text-green-600 font-bold">$79.99</p>
            <div class="flex text-yellow-400 text-sm mt-1">★★★★☆</div>
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

