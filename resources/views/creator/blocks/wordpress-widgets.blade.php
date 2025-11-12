{{-- Bloques de WordPress Adicionales --}}
{
  id: 'shortcode',
  label: 'Shortcode',
  category: 'WordPress',
  attributes: {
    class: 'gjs-block-shortcode'
  },
  content: `
    <div class="shortcode-block p-4 bg-gray-50 border-2 border-dashed border-blue-300 rounded-lg">
      <div class="flex items-center justify-center mb-3">
        <svg class="w-8 h-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm font-semibold text-gray-700">Bloque de Shortcode</span>
      </div>
      <div class="shortcode-content text-center">
        <code class="text-xs text-gray-600 bg-gray-100 px-3 py-1 rounded">[shortcode_ejemplo parametro="valor"]</code>
      </div>
      <p class="mt-2 text-xs text-center text-gray-500">Escribe tu shortcode en la configuración</p>
    </div>
  `,
  traits: [
    {
      type: 'textarea',
      name: 'shortcode',
      label: 'Shortcode',
      placeholder: '[tu_shortcode]',
      changeProp: 1
    },
    {
      type: 'text',
      name: 'shortcode-description',
      label: 'Descripción (opcional)',
      placeholder: 'Descripción del shortcode'
    }
  ]
},
{
  id: 'read-more',
  label: 'Leer Más',
  category: 'WordPress',
  attributes: {
    class: 'gjs-block-read-more'
  },
  content: `
    <div class="read-more-wrapper inline-block">
      <a href="#" class="read-more-button inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
        <span data-gjs-type="text" data-gjs-name="read-more-text">Leer más</span>
        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'href',
      label: 'URL del Post',
      placeholder: '/blog/post-completo'
    },
    {
      type: 'select',
      name: 'button-style',
      label: 'Estilo del Botón',
      options: [
        { value: 'solid', name: 'Sólido' },
        { value: 'outline', name: 'Outline' },
        { value: 'text', name: 'Solo Texto' }
      ]
    },
    {
      type: 'select',
      name: 'button-size',
      label: 'Tamaño',
      options: [
        { value: 'small', name: 'Pequeño' },
        { value: 'medium', name: 'Mediano' },
        { value: 'large', name: 'Grande' }
      ]
    },
    {
      type: 'checkbox',
      name: 'show-icon',
      label: 'Mostrar Icono',
      value: true
    },
    {
      type: 'checkbox',
      name: 'open-new-tab',
      label: 'Abrir en Nueva Pestaña',
      value: false
    }
  ]
},
{
  id: 'menu-anchor',
  label: 'Ancla de Menú',
  category: 'WordPress',
  attributes: {
    class: 'gjs-block-menu-anchor'
  },
  content: `
    <div id="menu-anchor" class="menu-anchor" data-anchor-id="seccion-1">
      <div class="anchor-indicator p-2 bg-yellow-50 border border-yellow-300 rounded text-center">
        <svg class="w-5 h-5 inline-block text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
        </svg>
        <span class="text-xs text-yellow-700 ml-1">Ancla: seccion-1</span>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'id',
      label: 'ID del Ancla',
      placeholder: 'mi-seccion',
      changeProp: 1
    },
    {
      type: 'text',
      name: 'anchor-name',
      label: 'Nombre del Ancla',
      placeholder: 'Mi Sección'
    },
    {
      type: 'checkbox',
      name: 'show-indicator',
      label: 'Mostrar Indicador en Editor',
      value: true
    }
  ]
}
