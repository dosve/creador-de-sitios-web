{{-- Bloques de Productos --}}
{
  id: 'products-list'
  , label: 'Lista de Productos'
  , attributes: {
    class: 'gjs-block-products'
  }
  , content: `<section class="py-16 bg-gray-50 products-list" data-products-source="api" data-dynamic-products="true">
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
                                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 1, name: 'Producto de Ejemplo 1', price: 99.99, image: 'https://via.placeholder.com/60x60'})">
                                            Agregar al Carrito
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
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$149.99</span>
                                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 2, name: 'Producto de Ejemplo 2', price: 149.99, image: 'https://via.placeholder.com/60x60'})">
                                            Agregar al Carrito
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
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$199.99</span>
                                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 3, name: 'Producto de Ejemplo 3', price: 199.99, image: 'https://via.placeholder.com/60x60'})">
                                            Agregar al Carrito
                                        </button>
          </div>
        </div>
      </div>
      <div class="mt-12 text-center">
        <a href="{{ route('creator.store.products', $website) }}" class="inline-flex items-center px-8 py-3 text-base font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Ver más productos
          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </a>
      </div>
    </div>
  </section>`
}
