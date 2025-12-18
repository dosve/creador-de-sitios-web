// Módulo de Utilidades del Editor
// Funciones de utilidad compartidas

const EditorUtils = {
  // Función para mostrar placeholder de productos en el editor
  showProductsPlaceholder: function() {
    let productsContainers = document.querySelectorAll('#products-container');
    
    if (productsContainers.length === 0) {
      productsContainers = document.querySelectorAll('.products-list .grid');
    }
    
    if (productsContainers.length === 0) {
      const allGrids = document.querySelectorAll('.grid');
      productsContainers = Array.from(allGrids).filter(grid =>
        grid.textContent.includes('Producto de Ejemplo') ||
        grid.querySelector('.bg-white.border.border-gray-200')
      );
    }
    
    if (productsContainers.length === 0) {
      return;
    }
    
    productsContainers.forEach((container) => {
      container.innerHTML = `
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
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
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
          <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
          <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">$199.99</span>
            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Ver Producto
            </button>
          </div>
        </div>
      `;
    });
  },
  
  // Función para manejar clics en sectores del StyleManager
  handleSectorClick: function(e) {
    const sectorTitle = e.target.closest('.gjs-sm-title');
    if (sectorTitle) {
      const sector = sectorTitle.closest('.gjs-sm-sector');
      if (sector) {
        if (sector.classList.contains('gjs-sm-open')) {
          sector.classList.remove('gjs-sm-open');
        } else {
          sector.classList.add('gjs-sm-open');
        }
      }
    }
  }
};
