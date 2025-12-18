{{-- Bloques de Diseño de WordPress --}}
{
  id: 'separator',
  label: '<b>Separador</b>',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-separator'
  },
  content: {
    type: 'separator',
    tagName: 'div',
    name: 'Separador',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      class: 'separator-container my-8',
      'data-gjs-type': 'separator',
      'data-gjs-name': 'Separador',
      'data-gjs-editable': 'false'
    },
    components: [
      {
        tagName: 'hr',
        selectable: false,
        editable: false,
        removable: false,
        droppable: false,
        attributes: {
          class: 'border-t-2 border-gray-300 w-full mx-auto',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-droppable': 'false',
          'data-gjs-removable': 'false'
        }
      }
    ]
    // Los traits están definidos en el componente separator.js
  }
},
{
  id: 'spacer',
  label: 'Espaciador',
  category: 'Diseño',
  attributes: {
    class: 'gjs-block-spacer'
  },
  content: {
    type: 'spacer',
    tagName: 'div',
    name: 'Espaciador',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'spacer-container',
      'data-gjs-type': 'spacer',
      'data-gjs-name': 'Espaciador',
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
          class: 'spacer-element h-16 bg-gray-100 border-2 border-dashed border-gray-300 rounded flex items-center justify-center',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-droppable': 'false',
          'data-gjs-removable': 'false',
          'contenteditable': 'false'
        },
        components: [
          {
            tagName: 'span',
            selectable: false,
            editable: false,
            removable: false,
            droppable: false,
            attributes: {
              class: 'text-gray-500 text-sm',
              'data-gjs-editable': 'false',
              'data-gjs-selectable': 'false',
              'data-gjs-draggable': 'false',
              'data-gjs-droppable': 'false',
              'data-gjs-removable': 'false',
              'contenteditable': 'false'
            },
            content: 'Espaciador'
          }
        ]
      }
    ]
    // Los traits están definidos en el componente spacer.js
  }
}
