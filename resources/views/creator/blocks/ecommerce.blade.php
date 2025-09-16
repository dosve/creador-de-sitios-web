{{-- Bloques de E-commerce --}}
{
  id: 'cart-button'
  , label: 'Botón de Carrito'
  , attributes: {
    class: 'gjs-block-cart'
  }
  , content: `<div class="cart-container">
    <!-- Botón del carrito -->
    <button id="cart-toggle" class="inline-flex items-center px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8M9 18a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"></path>
        </svg>
        <span class="text-sm font-medium">Carrito</span>
        <span id="cart-count" class="ml-2 px-2 py-1 text-xs font-bold text-blue-600 bg-white rounded-full">0</span>
    </button>

    <!-- Overlay -->
    <div id="cart-overlay" class="fixed inset-0 z-[9998] hidden bg-black bg-opacity-50"></div>

    <!-- Aside del carrito -->
    <aside id="cart-sidebar" class="fixed top-0 right-0 z-[9999] w-full max-w-md h-full transform translate-x-full transition-transform duration-300 ease-in-out bg-white shadow-xl">
        <!-- Header del carrito -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Carrito de Compras</h2>
            <button id="cart-close" class="p-2 text-gray-400 rounded-md hover:text-gray-600 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Contenido del carrito -->
        <div class="flex flex-col h-full">
            <!-- Lista de productos -->
            <div id="cart-items" class="flex-1 overflow-y-auto p-4">
                <div id="empty-cart" class="flex flex-col items-center justify-center h-full text-gray-500">
                    <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8M9 18a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"></path>
                    </svg>
                    <p class="text-lg font-medium">Tu carrito está vacío</p>
                    <p class="text-sm">Agrega algunos productos para comenzar</p>
                </div>
            </div>

            <!-- Footer del carrito -->
            <div class="border-t border-gray-200 p-4 bg-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                    <span id="cart-total" class="text-xl font-bold text-blue-600">$0.00</span>
                </div>
                <button id="checkout-btn" class="w-full py-3 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Proceder al Pago
                </button>
            </div>
        </div>
    </aside>
  </div>`
}
