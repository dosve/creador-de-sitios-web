{{-- Bloques de Utilidades y Básicos Adicionales --}}
{
  id: 'spacer',
  label: 'Espaciador',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-spacer'
  },
  content: `
    <div class="spacer" style="height: 50px; width: 100%; display: block;"></div>
  `,
  traits: [
    {
      type: 'select',
      name: 'spacer-height',
      label: 'Altura',
      options: [
        { value: '20px', name: '20px - Muy Pequeño' },
        { value: '30px', name: '30px - Pequeño' },
        { value: '50px', name: '50px - Mediano' },
        { value: '80px', name: '80px - Grande' },
        { value: '100px', name: '100px - Muy Grande' },
        { value: '150px', name: '150px - Extra Grande' }
      ]
    }
  ]
},
{
  id: 'html-code',
  label: 'Código HTML',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-html'
  },
  content: `
    <div class="custom-html-block p-4 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg">
      <div class="flex items-center justify-center text-gray-500">
        <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
        <span class="text-sm font-medium">Bloque de Código HTML/CSS/JavaScript</span>
      </div>
      <p class="mt-2 text-xs text-center text-gray-400">Haz clic para editar el código personalizado</p>
    </div>
  `,
  traits: [
    {
      type: 'textarea',
      name: 'html-content',
      label: 'Código HTML',
      placeholder: '<div>Tu código HTML aquí</div>'
    },
    {
      type: 'textarea',
      name: 'css-content',
      label: 'CSS (opcional)',
      placeholder: '.tu-clase { color: red; }'
    },
    {
      type: 'textarea',
      name: 'js-content',
      label: 'JavaScript (opcional)',
      placeholder: 'console.log("Hola");'
    }
  ]
},
{
  id: 'alert',
  label: 'Alerta',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-alert'
  },
  content: `
    <div class="alert bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg" role="alert">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 data-gjs-type="text" data-gjs-name="alert-title" class="text-sm font-medium text-blue-800">Título de la Alerta</h3>
          <p data-gjs-type="text" data-gjs-name="alert-message" class="mt-1 text-sm text-blue-700">Este es un mensaje informativo. Puedes cambiar el estilo y el contenido.</p>
        </div>
        <button class="flex-shrink-0 ml-3" onclick="this.closest('.alert').remove()">
          <svg class="w-5 h-5 text-blue-500 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'alert-type',
      label: 'Tipo de Alerta',
      options: [
        { value: 'info', name: 'Información (Azul)' },
        { value: 'success', name: 'Éxito (Verde)' },
        { value: 'warning', name: 'Advertencia (Amarillo)' },
        { value: 'error', name: 'Error (Rojo)' }
      ]
    },
    {
      type: 'checkbox',
      name: 'dismissible',
      label: 'Cerrable',
      value: true
    }
  ]
},
{
  id: 'alert-success',
  label: 'Alerta de Éxito',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-alert'
  },
  content: `
    <div class="alert bg-green-50 border-l-4 border-green-500 p-4 rounded-lg" role="alert">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 data-gjs-type="text" data-gjs-name="alert-title" class="text-sm font-medium text-green-800">¡Operación Exitosa!</h3>
          <p data-gjs-type="text" data-gjs-name="alert-message" class="mt-1 text-sm text-green-700">Tu acción se completó correctamente.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: 'alert-warning',
  label: 'Alerta de Advertencia',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-alert'
  },
  content: `
    <div class="alert bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg" role="alert">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 data-gjs-type="text" data-gjs-name="alert-title" class="text-sm font-medium text-yellow-800">Advertencia</h3>
          <p data-gjs-type="text" data-gjs-name="alert-message" class="mt-1 text-sm text-yellow-700">Por favor, ten en cuenta esta información importante.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: 'alert-error',
  label: 'Alerta de Error',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-alert'
  },
  content: `
    <div class="alert bg-red-50 border-l-4 border-red-500 p-4 rounded-lg" role="alert">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 data-gjs-type="text" data-gjs-name="alert-title" class="text-sm font-medium text-red-800">Error</h3>
          <p data-gjs-type="text" data-gjs-name="alert-message" class="mt-1 text-sm text-red-700">Hubo un problema al procesar tu solicitud.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: 'toggle',
  label: 'Toggle',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-toggle'
  },
  content: `
    <div class="toggle-container">
      <button class="toggle-button w-full flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180');">
        <span data-gjs-type="text" data-gjs-name="toggle-title" class="font-medium text-gray-900">Haz clic para expandir</span>
        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <div class="toggle-content hidden p-4 bg-gray-50 border border-t-0 border-gray-200 rounded-b-lg">
        <p data-gjs-type="text" data-gjs-name="toggle-content" class="text-gray-700">Este es el contenido que se muestra cuando se expande el toggle. Puedes agregar cualquier contenido aquí.</p>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'checkbox',
      name: 'initially-open',
      label: 'Abierto Inicialmente',
      value: false
    }
  ]
},
{
  id: 'star-rating',
  label: 'Calificación con Estrellas',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-rating'
  },
  content: `
    <div class="star-rating flex items-center p-4">
      <div class="flex text-yellow-400 text-2xl mr-2">
        <span>★</span>
        <span>★</span>
        <span>★</span>
        <span>★</span>
        <span>★</span>
      </div>
      <span data-gjs-type="text" data-gjs-name="rating-text" class="text-sm text-gray-600">(5.0 de 5)</span>
    </div>
  `,
  traits: [
    {
      type: 'select',
      name: 'rating',
      label: 'Calificación',
      options: [
        { value: '5', name: '5 Estrellas' },
        { value: '4.5', name: '4.5 Estrellas' },
        { value: '4', name: '4 Estrellas' },
        { value: '3.5', name: '3.5 Estrellas' },
        { value: '3', name: '3 Estrellas' },
        { value: '2.5', name: '2.5 Estrellas' },
        { value: '2', name: '2 Estrellas' },
        { value: '1.5', name: '1.5 Estrellas' },
        { value: '1', name: '1 Estrella' }
      ]
    },
    {
      type: 'select',
      name: 'rating-size',
      label: 'Tamaño',
      options: [
        { value: 'small', name: 'Pequeño' },
        { value: 'medium', name: 'Mediano' },
        { value: 'large', name: 'Grande' }
      ]
    },
    {
      type: 'color',
      name: 'star-color',
      label: 'Color de Estrellas',
      placeholder: '#fbbf24'
    }
  ]
},
{
  id: 'blockquote',
  label: 'Cita / Quote',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-quote'
  },
  content: `
    <blockquote class="border-l-4 border-blue-500 pl-4 py-2 my-4 italic">
      <p data-gjs-type="text" data-gjs-name="quote-text" class="text-lg text-gray-700">"Esta es una cita inspiradora o importante que quieres destacar en tu contenido."</p>
      <footer data-gjs-type="text" data-gjs-name="quote-author" class="mt-2 text-sm text-gray-600">— Autor de la Cita</footer>
    </blockquote>
  `,
  traits: [
    {
      type: 'select',
      name: 'quote-style',
      label: 'Estilo',
      options: [
        { value: 'simple', name: 'Simple' },
        { value: 'bordered', name: 'Con Borde' },
        { value: 'boxed', name: 'Caja' }
      ]
    },
    {
      type: 'color',
      name: 'accent-color',
      label: 'Color de Acento',
      placeholder: '#3b82f6'
    }
  ]
}

