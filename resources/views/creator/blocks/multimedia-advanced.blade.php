{{-- Bloques Multimedia Avanzados --}}
{
  id: 'audio',
  label: '<b>Reproductor de Audio</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-audio'
  },
  content: {
    type: 'audio',
    tagName: 'div',
    name: 'Reproductor de Audio',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      'data-gjs-type': 'audio',
      'data-gjs-name': 'Reproductor de Audio',
      'data-gjs-editable': 'false',
      class: 'audio-player bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto mb-8'
    },
    components: [
      {
        tagName: 'div',
        editable: false,
        droppable: false,
        attributes: {
          class: 'flex items-center mb-4'
        },
        components: [
          {
            tagName: 'div',
            selectable: false,
            editable: false,
            removable: false,
            attributes: {
              class: 'w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-4'
            },
            components: [
              {
                tagName: 'svg',
                selectable: false,
                editable: false,
                removable: false,
                attributes: {
                  class: 'w-8 h-8 text-white',
                  fill: 'currentColor',
                  viewBox: '0 0 20 20'
                },
                components: [
                  {
                    tagName: 'path',
                    selectable: false,
                    editable: false,
                    removable: false,
                    attributes: {
                      d: 'M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z'
                    }
                  }
                ]
              }
            ]
          },
          {
            tagName: 'div',
            editable: false,
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
                content: 'Título del Audio'
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
                content: 'Artista o Descripción'
              }
            ]
          }
        ]
      },
      {
        tagName: 'audio',
        selectable: false,
        editable: false,
        removable: false,
        attributes: {
          controls: 'true',
          class: 'w-full'
        },
        components: [
          {
            tagName: 'source',
            selectable: false,
            editable: false,
            removable: false,
            attributes: {
              src: '',
              type: 'audio/mpeg'
            }
          }
        ]
      }
    ]
    // Los traits están definidos en el componente audio.js
  }
},
{
  id: 'carousel',
  label: '<b>Carrusel</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-carousel'
  },
  content: {
    type: 'carousel',
    tagName: 'div',
    name: 'Carrusel',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos directamente
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      'data-gjs-type': 'carousel',
      'data-gjs-name': 'Carrusel',
      'data-gjs-editable': 'false',
      class: 'carousel-container relative bg-gray-100 rounded-lg overflow-hidden mb-8'
    },
    components: [
      {
        tagName: 'div',
        editable: false,
        droppable: false,
        attributes: {
          class: 'carousel-wrapper'
        },
        components: [
          {
            tagName: 'div',
            editable: false,
            droppable: false,
            attributes: {
              class: 'carousel-slide'
            },
            components: [
              {
                tagName: 'img',
                selectable: false,
                editable: false,
                removable: false,
                attributes: {
                  src: '/images/default-image.jpg',
                  alt: 'Slide 1',
                  class: 'w-full h-96 object-cover'
                }
              }
            ]
          },
          {
            tagName: 'div',
            editable: false,
            droppable: false,
            attributes: {
              class: 'carousel-slide hidden'
            },
            components: [
              {
                tagName: 'img',
                selectable: false,
                editable: false,
                removable: false,
                attributes: {
                  src: '/images/default-image.jpg',
                  alt: 'Slide 2',
                  class: 'w-full h-96 object-cover'
                }
              }
            ]
          },
          {
            tagName: 'div',
            editable: false,
            droppable: false,
            attributes: {
              class: 'carousel-slide hidden'
            },
            components: [
              {
                tagName: 'img',
                selectable: false,
                editable: false,
                removable: false,
                attributes: {
                  src: '/images/default-image.jpg',
                  alt: 'Slide 3',
                  class: 'w-full h-96 object-cover'
                }
              }
            ]
          }
        ]
      }
    ]
    // Los traits están definidos en el componente carousel.js
  }
},
{
  id: 'counter-animated',
  label: '<b>Contador Animado</b>',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-counter'
  },
  content: {
    type: 'counter-animated',
    tagName: 'div',
    name: 'Contador Animado',
    editable: false,
    droppable: false,
    removable: true,
    selectable: true,
    attributes: {
      class: 'counter-container',
      'data-gjs-type': 'counter-animated',
      'data-gjs-name': 'Contador Animado',
      'data-gjs-editable': 'false'
    }
    // Los traits están definidos en el componente counter-animated.js
  }
},
{
  id: 'image-box-advanced',
  label: '<b>Caja de Imagen Avanzada</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-image-box'
  },
  content: {
    type: 'image-box-advanced',
    tagName: 'div',
    name: 'Caja de Imagen Avanzada',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      'data-gjs-type': 'image-box-advanced',
      'data-gjs-name': 'Caja de Imagen Avanzada',
      'data-gjs-editable': 'false',
      class: 'image-box group relative overflow-hidden rounded-lg shadow-lg cursor-pointer mb-8'
    },
    components: [
      {
        tagName: 'img',
        selectable: false,
        editable: false,
        removable: false,
        attributes: {
          src: '/images/default-image.jpg',
          alt: 'Imagen',
          class: 'w-full h-auto max-h-96 object-cover transform group-hover:scale-110 transition-transform duration-300'
        }
      },
      {
        tagName: 'div',
        selectable: false,
        editable: false,
        removable: false,
        attributes: {
          class: 'absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300'
        },
        components: [
          {
            tagName: 'div',
            editable: false,  // ✅ BLOQUEADO: No edición directa
            droppable: false,
            attributes: {
              class: 'absolute bottom-0 left-0 right-0 p-6 text-white',
              'data-gjs-editable': 'false'
            },
            components: [
              {
                tagName: 'h3',
                editable: false,  // ✅ BLOQUEADO: Solo desde traits
                droppable: false,
                selectable: false,
                attributes: {
                  class: 'text-xl font-bold mb-2',
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'contenteditable': 'false'
                },
                content: 'Título de la Imagen'
              },
              {
                tagName: 'p',
                editable: false,  // ✅ BLOQUEADO: Solo desde traits
                droppable: false,
                selectable: false,
                attributes: {
                  class: 'text-sm',
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'contenteditable': 'false'
                },
                content: 'Descripción que aparece al hacer hover sobre la imagen.'
              }
            ]
          }
        ]
      }
    ]
    // Los traits están definidos en el componente image-box-advanced.js
  }
}

