{{-- Bloques de Navegación de Elementor --}}

{{-- NAVBAR: NO está en Elementor FREE (comentado)
{
  id: 'navbar',
  label: 'Navegación',
  category: 'Navegación', content: `<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <a href="#" class="text-xl font-bold text-gray-900">Mi Sitio Web</a>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center ml-10 space-x-4">
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:text-gray-700">Inicio</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Acerca</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Servicios</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Contacto</a>
                </div>
            </div>
            <div class="md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md bg-gray-50 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>`
},
--}}
{
  id: 'tabs',
  label: 'Pestañas',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-tabs'
  },
  content: {
    type: 'tabs',
    tagName: 'div',
    name: 'Pestañas',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'py-8 tabs-container',
      'data-gjs-type': 'tabs',
      'data-gjs-name': 'Pestañas',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente tabs.js
  }
},
{
  id: 'accordion',
  label: 'Acordeón',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-accordion'
  },
  content: {
    type: 'accordion',
    tagName: 'div',
    name: 'Acordeón',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'py-8 accordion',
      'data-gjs-type': 'accordion',
      'data-gjs-name': 'Acordeón',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente accordion.js
  }
}