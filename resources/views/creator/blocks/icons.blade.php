{{-- Bloques de Iconos --}}
{
  id: 'icon',
  label: 'Icono',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon'
  },
  content: `
    <div class="icon-container text-center p-4">
      <div class="icon-wrapper inline-flex items-center justify-center">
        <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'icon-type',
      label: 'Tipo de Icono',
      options: [
        { value: 'lightning', name: 'Rayo' },
        { value: 'star', name: 'Estrella' },
        { value: 'heart', name: 'Corazón' },
        { value: 'check', name: 'Check' },
        { value: 'user', name: 'Usuario' },
        { value: 'mail', name: 'Email' },
        { value: 'phone', name: 'Teléfono' },
        { value: 'home', name: 'Casa' },
        { value: 'settings', name: 'Configuración' },
        { value: 'search', name: 'Búsqueda' }
      ]
    },
    {
      type: 'select',
      name: 'icon-size',
      label: 'Tamaño',
      options: [
        { value: 'small', name: 'Pequeño' },
        { value: 'medium', name: 'Mediano' },
        { value: 'large', name: 'Grande' },
        { value: 'xlarge', name: 'Extra Grande' }
      ]
    },
    {
      type: 'color',
      name: 'icon-color',
      label: 'Color del Icono',
      placeholder: '#2563eb'
    },
    {
      type: 'text',
      name: 'icon-link',
      label: 'Enlace (opcional)',
      placeholder: 'https://ejemplo.com'
    }
  ]
},
{
  id: 'icon-box',
  label: 'Caja de Icono',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon-box'
  },
  content: `
    <div class="icon-box text-center p-6 bg-white rounded-lg hover:shadow-lg transition-shadow">
      <div class="icon-wrapper inline-flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
      <h3 data-gjs-type="text" data-gjs-name="icon-box-title" class="text-xl font-semibold text-gray-900 mb-2">Título del Feature</h3>
      <p data-gjs-type="text" data-gjs-name="icon-box-description" class="text-gray-600">Descripción del feature o servicio que ofreces. Explica los beneficios de forma clara.</p>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'icon-type',
      label: 'Tipo de Icono',
      options: [
        { value: 'lightning', name: 'Rayo' },
        { value: 'star', name: 'Estrella' },
        { value: 'heart', name: 'Corazón' },
        { value: 'check', name: 'Check' },
        { value: 'shield', name: 'Escudo' },
        { value: 'clock', name: 'Reloj' },
        { value: 'chart', name: 'Gráfico' },
        { value: 'users', name: 'Usuarios' },
        { value: 'globe', name: 'Globo' },
        { value: 'rocket', name: 'Cohete' }
      ]
    },
    {
      type: 'select',
      name: 'icon-position',
      label: 'Posición del Icono',
      options: [
        { value: 'top', name: 'Arriba' },
        { value: 'left', name: 'Izquierda' },
        { value: 'right', name: 'Derecha' }
      ]
    },
    {
      type: 'color',
      name: 'icon-color',
      label: 'Color del Icono',
      placeholder: '#2563eb'
    },
    {
      type: 'color',
      name: 'icon-bg-color',
      label: 'Color de Fondo',
      placeholder: '#dbeafe'
    },
    {
      type: 'text',
      name: 'box-link',
      label: 'Enlace (opcional)',
      placeholder: 'https://ejemplo.com'
    }
  ]
},
{
  id: 'icon-box-horizontal',
  label: 'Caja de Icono Horizontal',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon-box'
  },
  content: `
    <div class="icon-box-horizontal flex items-start p-6 bg-white rounded-lg hover:shadow-lg transition-shadow">
      <div class="icon-wrapper flex-shrink-0 flex items-center justify-center w-12 h-12 mr-4 bg-green-100 rounded-full">
        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="flex-1">
        <h3 data-gjs-type="text" data-gjs-name="icon-box-title" class="text-lg font-semibold text-gray-900 mb-2">Título del Feature</h3>
        <p data-gjs-type="text" data-gjs-name="icon-box-description" class="text-gray-600">Descripción del feature o servicio. Layout horizontal perfecto para listas de beneficios.</p>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'icon-type',
      label: 'Tipo de Icono',
      options: [
        { value: 'check', name: 'Check' },
        { value: 'star', name: 'Estrella' },
        { value: 'heart', name: 'Corazón' },
        { value: 'lightning', name: 'Rayo' },
        { value: 'shield', name: 'Escudo' }
      ]
    },
    {
      type: 'color',
      name: 'icon-color',
      label: 'Color del Icono',
      placeholder: '#059669'
    },
    {
      type: 'color',
      name: 'icon-bg-color',
      label: 'Color de Fondo',
      placeholder: '#d1fae5'
    }
  ]
},
{
  id: 'icon-list',
  label: 'Lista con Iconos',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-icon-list'
  },
  content: `
    <div class="icon-list space-y-3 p-6">
      <div class="icon-list-item flex items-center">
        <div class="flex-shrink-0 w-6 h-6 mr-3 text-green-500">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <span data-gjs-type="text" data-gjs-name="list-item-1" class="text-gray-700">Primera característica o beneficio</span>
      </div>
      <div class="icon-list-item flex items-center">
        <div class="flex-shrink-0 w-6 h-6 mr-3 text-green-500">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <span data-gjs-type="text" data-gjs-name="list-item-2" class="text-gray-700">Segunda característica o beneficio</span>
      </div>
      <div class="icon-list-item flex items-center">
        <div class="flex-shrink-0 w-6 h-6 mr-3 text-green-500">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <span data-gjs-type="text" data-gjs-name="list-item-3" class="text-gray-700">Tercera característica o beneficio</span>
      </div>
      <div class="icon-list-item flex items-center">
        <div class="flex-shrink-0 w-6 h-6 mr-3 text-green-500">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <span data-gjs-type="text" data-gjs-name="list-item-4" class="text-gray-700">Cuarta característica o beneficio</span>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'icon-type',
      label: 'Tipo de Icono',
      options: [
        { value: 'check', name: 'Check' },
        { value: 'star', name: 'Estrella' },
        { value: 'arrow', name: 'Flecha' },
        { value: 'dot', name: 'Punto' }
      ]
    },
    {
      type: 'color',
      name: 'icon-color',
      label: 'Color de Iconos',
      placeholder: '#10b981'
    },
    {
      type: 'select',
      name: 'spacing',
      label: 'Espaciado',
      options: [
        { value: 'compact', name: 'Compacto' },
        { value: 'normal', name: 'Normal' },
        { value: 'relaxed', name: 'Relajado' }
      ]
    }
  ]
}

