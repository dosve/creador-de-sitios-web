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
  label: '<b>Código HTML</b>',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-html'
  },
  content: {
    type: 'html-code',
    tagName: 'div',
    name: 'Código HTML',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      class: 'custom-html-block p-4 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg',
      'data-gjs-type': 'html-code',
      'data-gjs-name': 'Código HTML',
      'data-gjs-editable': 'false'
    },
    components: [
      {
        tagName: 'div',
        selectable: false,
        editable: false,
        removable: false,
        droppable: false,
        attributes: {
          class: 'flex items-center justify-center text-gray-500',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-droppable': 'false',
          'data-gjs-removable': 'false',
          'contenteditable': 'false'
        },
        components: [
          {
            tagName: 'svg',
            selectable: false,
            editable: false,
            removable: false,
            droppable: false,
            attributes: {
              class: 'w-8 h-8 mr-2',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
              'data-gjs-editable': 'false',
              'data-gjs-selectable': 'false',
              'data-gjs-draggable': 'false',
              'data-gjs-droppable': 'false',
              'data-gjs-removable': 'false',
              'contenteditable': 'false'
            },
            components: [
              {
                tagName: 'path',
                selectable: false,
                editable: false,
                removable: false,
                droppable: false,
                attributes: {
                  'stroke-linecap': 'round',
                  'stroke-linejoin': 'round',
                  'stroke-width': '2',
                  d: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'data-gjs-draggable': 'false',
                  'data-gjs-droppable': 'false',
                  'data-gjs-removable': 'false',
                  'contenteditable': 'false'
                }
              }
            ]
          },
          {
            tagName: 'span',
            selectable: false,
            editable: false,
            removable: false,
            droppable: false,
            attributes: {
              class: 'text-sm font-medium',
              'data-gjs-editable': 'false',
              'data-gjs-selectable': 'false',
              'data-gjs-draggable': 'false',
              'data-gjs-droppable': 'false',
              'data-gjs-removable': 'false',
              'contenteditable': 'false'
            },
            content: 'Bloque de Código HTML/CSS/JavaScript'
          }
        ]
      },
      {
        tagName: 'p',
        selectable: false,
        editable: false,
        removable: false,
        droppable: false,
        attributes: {
          class: 'mt-2 text-xs text-center text-gray-400',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-droppable': 'false',
          'data-gjs-removable': 'false',
          'contenteditable': 'false'
        },
        content: 'Haz clic para editar el código personalizado'
      }
    ]
    // Los traits están definidos en el componente html-code.js
  }
},
{
  id: 'alert',
  label: '<b>Alerta</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-alert'
  },
  content: {
    type: 'alert',
    tagName: 'div',
    name: 'Alerta',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'alert-container',
      'data-gjs-type': 'alert',
      'data-gjs-name': 'Alerta',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente alert.js
  }
},
{
  id: 'toggle',
  label: 'Toggle',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-toggle'
  },
  content: {
    type: 'toggle',
    tagName: 'div',
    name: 'Toggle',
    draggable: true,
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    hoverable: true,
    highlightable: true,
    badgable: true,
    layerable: true,
    attributes: {
      class: 'toggle-container',
      'data-gjs-type': 'toggle',
      'data-gjs-name': 'Toggle',
      'data-gjs-editable': 'false',
      'data-gjs-selectable': 'true',
      'data-gjs-removable': 'true',
      'data-gjs-badgable': 'true',
      'data-gjs-highlightable': 'true',
      'data-gjs-hoverable': 'true'
    }
    // ✅ Estructura HTML creada en onRender() del componente
    // NO usar components aquí para evitar que GrapesJS cree componentes internos
  }
},
{
  id: 'star-rating',
  label: '<b>Calificación con Estrellas</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-rating'
  },
  content: {
    type: 'star-rating',
    tagName: 'div',
    name: 'Calificación con Estrellas',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'star-rating-container',
      'data-gjs-type': 'star-rating',
      'data-gjs-name': 'Calificación con Estrellas',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente star-rating.js
  }
},
{
  id: 'blockquote',
  label: '<b>Cita / Quote</b>',
  category: 'Básicos',
  attributes: {
    class: 'gjs-block-quote'
  },
  content: {
    type: 'quote',
    tagName: 'blockquote',
    name: 'Cita',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'quote-container',
      'data-gjs-type': 'quote',
      'data-gjs-name': 'Cita',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente quote.js
  }
}

