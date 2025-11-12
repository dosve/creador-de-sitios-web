{{-- Bloques de Formularios de Búsqueda --}}
{
  id: 'search-form',
  label: 'Formulario de Búsqueda',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-search-form'
  },
  content: `
    <div class="search-form-container">
      <form class="search-form relative" method="GET" action="/search">
        <div class="search-input-wrapper flex items-center bg-white border border-gray-300 rounded-lg overflow-hidden hover:border-blue-500 transition-colors">
          <div class="pl-4 text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <input 
            type="search" 
            name="q" 
            placeholder="Buscar..." 
            class="flex-1 px-4 py-3 focus:outline-none"
            autocomplete="off"
          >
          <button 
            type="submit"
            class="px-6 py-3 bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors"
          >
            Buscar
          </button>
        </div>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Búsqueda',
      placeholder: '/search',
      value: '/search'
    },
    {
      type: 'text',
      name: 'placeholder',
      label: 'Texto Placeholder',
      placeholder: 'Buscar...'
    },
    {
      type: 'select',
      name: 'search-style',
      label: 'Estilo de Búsqueda',
      options: [
        { value: 'default', name: 'Por Defecto' },
        { value: 'minimal', name: 'Minimalista' },
        { value: 'fullscreen', name: 'Pantalla Completa' }
      ]
    },
    {
      type: 'checkbox',
      name: 'show-button',
      label: 'Mostrar Botón',
      value: true
    },
    {
      type: 'checkbox',
      name: 'autocomplete',
      label: 'Activar Autocompletado',
      value: false
    }
  ]
},
{
  id: 'search-form-minimal',
  label: 'Búsqueda Minimalista',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-search-minimal'
  },
  content: `
    <div class="search-form-minimal">
      <form class="search-form-inline relative inline-block" method="GET" action="/search">
        <div class="relative">
          <input 
            type="search" 
            name="q" 
            placeholder="Buscar..." 
            class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
          <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
        </div>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Búsqueda',
      placeholder: '/search',
      value: '/search'
    },
    {
      type: 'text',
      name: 'placeholder',
      label: 'Texto Placeholder',
      placeholder: 'Buscar...'
    }
  ]
},
{
  id: 'search-form-fullscreen',
  label: 'Búsqueda Pantalla Completa',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-search-fullscreen'
  },
  content: `
    <div class="search-trigger">
      <button 
        class="search-open-button inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors"
        onclick="document.getElementById('search-fullscreen-modal').classList.remove('hidden')"
      >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <span>Buscar</span>
      </button>
    </div>
    
    <div 
      id="search-fullscreen-modal" 
      class="hidden fixed inset-0 z-50 bg-white"
      style="display: none;"
    >
      <div class="flex flex-col items-center justify-center min-h-screen p-8">
        <button 
          class="absolute top-8 right-8 text-gray-400 hover:text-gray-600"
          onclick="this.closest('#search-fullscreen-modal').classList.add('hidden')"
        >
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
        
        <div class="w-full max-w-3xl">
          <h2 class="text-4xl font-bold text-center mb-8 text-gray-900">¿Qué estás buscando?</h2>
          
          <form class="search-form" method="GET" action="/search">
            <div class="relative">
              <input 
                type="search" 
                name="q" 
                placeholder="Escribe tu búsqueda..." 
                class="w-full px-6 py-4 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                autofocus
              >
              <button 
                type="submit"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
              >
                Buscar
              </button>
            </div>
          </form>
          
          <div class="mt-8">
            <p class="text-sm text-gray-500 text-center">Presiona Esc para cerrar</p>
          </div>
        </div>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Búsqueda',
      placeholder: '/search',
      value: '/search'
    },
    {
      type: 'text',
      name: 'button-text',
      label: 'Texto del Botón',
      placeholder: 'Buscar'
    }
  ]
},
{
  id: 'search-with-filters',
  label: 'Búsqueda con Filtros',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-search-filters'
  },
  content: `
    <div class="search-with-filters-container bg-white p-6 rounded-lg shadow-md">
      <form class="search-form space-y-4" method="GET" action="/search">
        <!-- Search Input -->
        <div class="search-input-wrapper">
          <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
          <div class="relative">
            <input 
              type="search" 
              name="q" 
              placeholder="¿Qué estás buscando?" 
              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
        </div>
        
        <!-- Filters -->
        <div class="filters-grid grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="">Todas</option>
              <option value="blog">Blog</option>
              <option value="productos">Productos</option>
              <option value="paginas">Páginas</option>
            </select>
          </div>
          
          <!-- Date Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
            <select name="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="">Cualquier fecha</option>
              <option value="today">Hoy</option>
              <option value="week">Esta semana</option>
              <option value="month">Este mes</option>
              <option value="year">Este año</option>
            </select>
          </div>
          
          <!-- Order Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
            <select name="order" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="relevance">Relevancia</option>
              <option value="date">Fecha</option>
              <option value="title">Título</option>
            </select>
          </div>
        </div>
        
        <!-- Search Button -->
        <button 
          type="submit"
          class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
        >
          Buscar
        </button>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Búsqueda',
      placeholder: '/search',
      value: '/search'
    },
    {
      type: 'checkbox',
      name: 'show-category-filter',
      label: 'Mostrar Filtro de Categoría',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-date-filter',
      label: 'Mostrar Filtro de Fecha',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-order-filter',
      label: 'Mostrar Filtro de Orden',
      value: true
    }
  ]
}

