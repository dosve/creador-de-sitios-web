{{-- Bloques de Medios de WordPress --}}
{
  id: 'file',
  label: '<b>Archivo</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-file'
  },
  content: {
    type: 'file',
    tagName: 'div',
    name: 'Archivo',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      'data-gjs-type': 'file',
      'data-gjs-name': 'Archivo',
      'data-gjs-editable': 'false',
      class: 'file-download bg-white border border-gray-200 rounded-lg p-4 shadow-sm mb-8'
    },
    components: [
      {
        tagName: 'div',
        editable: false,
        droppable: false,
        attributes: {
          class: 'flex items-center space-x-4'
        },
        components: [
          {
            tagName: 'div',
            selectable: false,
            editable: false,
            removable: false,
            attributes: {
              class: 'w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center'
            },
            components: [
              {
                tagName: 'svg',
                selectable: false,
                editable: false,
                removable: false,
                attributes: {
                  class: 'w-6 h-6 text-red-600',
                  fill: 'none',
                  stroke: 'currentColor',
                  viewBox: '0 0 24 24'
                },
                components: [
                  {
                    tagName: 'path',
                    selectable: false,
                    editable: false,
                    removable: false,
                    attributes: {
                      'stroke-linecap': 'round',
                      'stroke-linejoin': 'round',
                      'stroke-width': '2',
                      d: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                    }
                  }
                ]
              }
            ]
          },
          {
            tagName: 'div',
            editable: false,  // ✅ BLOQUEADO: No edición directa
            droppable: false,
            attributes: {
              class: 'flex-1',
              'data-gjs-editable': 'false'
            },
            components: [
              {
                tagName: 'h3',
                editable: false,  // ✅ BLOQUEADO: Solo desde traits
                droppable: false,
                selectable: false,
                attributes: {
                  class: 'font-semibold text-gray-900',
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'contenteditable': 'false'
                },
                content: 'documento.pdf'
              },
              {
                tagName: 'p',
                editable: false,  // ✅ BLOQUEADO: Solo desde traits
                droppable: false,
                selectable: false,
                attributes: {
                  class: 'text-sm text-gray-600',
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'contenteditable': 'false'
                },
                content: '2.5 MB • PDF'
              }
            ]
          },
          {
            tagName: 'a',
            selectable: false,
            editable: false,
            removable: false,
            attributes: {
              class: 'bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700',
              href: '#',
              download: 'documento.pdf',
              target: '_blank'
            },
            content: 'Descargar'
          }
        ]
      }
    ]
    // Los traits están definidos en el componente file.js
  }
},
{
  id: 'background-image',
  label: '<b>Imagen de Fondo</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-background-image'
  },
  content: {
    type: 'background-image',
    tagName: 'div',
    name: 'Imagen de Fondo',
    editable: false,  // ✅ BLOQUEADO: No edición directa del contenedor
    droppable: true,  // ✅ PERMITIDO: Acepta contenido hijo
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      'data-gjs-type': 'background-image',
      'data-gjs-name': 'Imagen de Fondo',
      'data-gjs-editable': 'false',
      class: 'background-image-section relative h-96 bg-cover bg-center bg-no-repeat rounded-lg overflow-hidden mb-8',
      style: 'background-image: url(\'/images/default-image.jpg\');'
    },
    components: [
      {
        tagName: 'div',
        selectable: false,
        editable: false,
        removable: false,
        droppable: false,
        attributes: {
          class: 'absolute inset-0 bg-black bg-opacity-50',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-droppable': 'false',
          'contenteditable': 'false'
        }
      },
      {
        tagName: 'div',
        editable: false,  // ✅ BLOQUEADO: Solo desde propiedades
        droppable: true,  // ✅ PERMITIDO: Acepta contenido hijo
        selectable: false,
        removable: false,
        attributes: {
          class: 'relative z-10 flex items-center justify-center h-full text-center text-white p-8',
          'data-gjs-editable': 'false',
          'data-gjs-selectable': 'false',
          'data-gjs-draggable': 'false',
          'data-gjs-removable': 'false'
        },
        components: [
          {
            tagName: 'div',
            editable: false,  // ✅ BLOQUEADO: Solo desde propiedades
            droppable: true,  // ✅ PERMITIDO: Acepta contenido hijo
            selectable: false,
            removable: false,
            attributes: {
              'data-gjs-editable': 'false',
              'data-gjs-selectable': 'false',
              'data-gjs-draggable': 'false',
              'data-gjs-removable': 'false',
              'contenteditable': 'false'
            },
            components: [
              {
                tagName: 'h2',
                editable: true,  // ✅ PERMITIDO: Edición directa en el canvas
                droppable: false,
                selectable: true,  // ✅ PERMITIDO: Se puede seleccionar para editar
                removable: false,  // ✅ BLOQUEADO: No se puede eliminar individualmente
                attributes: {
                  class: 'text-3xl font-bold mb-4',
                  'data-gjs-editable': 'true',
                  'data-gjs-selectable': 'true',
                  'data-gjs-draggable': 'false',
                  'data-gjs-removable': 'false'
                },
                content: 'Contenido sobre Imagen'
              },
              {
                tagName: 'p',
                editable: true,  // ✅ PERMITIDO: Edición directa en el canvas
                droppable: false,
                selectable: true,  // ✅ PERMITIDO: Se puede seleccionar para editar
                removable: false,  // ✅ BLOQUEADO: No se puede eliminar individualmente
                attributes: {
                  class: 'text-lg mb-6',
                  'data-gjs-editable': 'true',
                  'data-gjs-selectable': 'true',
                  'data-gjs-draggable': 'false',
                  'data-gjs-removable': 'false'
                },
                content: 'Texto superpuesto sobre la imagen de fondo'
              },
              {
                tagName: 'button',
                editable: true,  // ✅ PERMITIDO: Edición directa en el canvas
                droppable: false,
                selectable: true,  // ✅ PERMITIDO: Se puede seleccionar para editar
                removable: false,  // ✅ BLOQUEADO: No se puede eliminar individualmente
                attributes: {
                  class: 'bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100',
                  'data-gjs-editable': 'true',
                  'data-gjs-selectable': 'true',
                  'data-gjs-draggable': 'false',
                  'data-gjs-removable': 'false'
                },
                content: 'Botón de Acción'
              }
            ]
          }
        ]
      }
    ]
    // Los traits están definidos en el componente background-image.js
  }
}
