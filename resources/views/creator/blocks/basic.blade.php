{{-- Bloques Básicos --}}
{
  id: 'section'
  , label: '<b>Sección</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-section'
  }
  , content: {
    type: 'section',
    tagName: 'section',
    name: 'Sección',
    attributes: { 
      class: 'section-container py-12 px-4',
      'data-section-layout': '1-column',
      'data-gjs-name': 'Sección'
    },
    components: [
      {
        type: 'container',
        tagName: 'div',
        name: 'Contenedor',
        attributes: { 
          class: 'container mx-auto',
          'data-gjs-name': 'Contenedor'
        },
        components: [
          {
            type: 'section-inner',
            tagName: 'div',
            name: 'Grid de Columnas',
            attributes: { 
              class: 'section-inner grid grid-cols-1 gap-6',
              'data-gjs-name': 'Grid de Columnas'
            },
            components: [
              {
                type: 'column',
                tagName: 'div',
                name: 'Columna 1',
                attributes: { 
                  class: 'column min-h-[100px] rounded-lg p-4',
                  'data-gjs-droppable': 'true',
                  'data-gjs-draggable': 'false',
                  'data-gjs-name': 'Columna 1'
                },
                droppable: true,
                components: [
                  {
                    type: 'text',
                    tagName: 'div',
                    name: 'Placeholder',
                    content: '↓ Arrastra elementos aquí ↓',
                    attributes: { 
                      class: 'text-gray-400 text-sm pointer-events-none',
                      'data-gjs-type': 'text',
                      'data-gjs-editable': 'false',
                      'data-gjs-name': 'Placeholder'
                    }
                  }
                ]
              }
            ]
          }
        ]
      }
    ],
    traits: [
      {
        type: 'select',
        name: 'section-layout',
        label: 'Diseño de Columnas',
        changeProp: 1,
        options: [
          { value: '1-column', name: '1 Columna (100%)' },
          { value: '2-columns', name: '2 Columnas (50% / 50%)' },
          { value: '2-columns-left', name: '2 Columnas (33% / 67%)' },
          { value: '2-columns-right', name: '2 Columnas (67% / 33%)' },
          { value: '3-columns', name: '3 Columnas (33% / 33% / 33%)' },
          { value: '4-columns', name: '4 Columnas (25% cada una)' },
          { value: '3-columns-center', name: '3 Columnas (25% / 50% / 25%)' }
        ]
      },
      {
        type: 'select',
        name: 'content-width',
        label: 'Ancho del Contenido',
        options: [
          { value: 'container', name: 'Completo con Márgenes' },
          { value: 'w-full', name: 'Ancho Completo (100%)' },
          { value: 'max-w-screen-xl', name: 'Extra Ancho (1280px)' },
          { value: 'max-w-screen-lg', name: 'Ancho (1024px)' },
          { value: 'max-w-screen-md', name: 'Mediano (768px)' },
          { value: 'max-w-screen-sm', name: 'Pequeño (640px)' }
        ]
      },
      {
        type: 'select',
        name: 'column-gap',
        label: 'Espacio entre Columnas',
        options: [
          { value: 'gap-0', name: 'Sin Espacio' },
          { value: 'gap-2', name: 'Pequeño (8px)' },
          { value: 'gap-4', name: 'Normal (16px)' },
          { value: 'gap-6', name: 'Mediano (24px)' },
          { value: 'gap-8', name: 'Grande (32px)' },
          { value: 'gap-12', name: 'Extra Grande (48px)' }
        ]
      },
      {
        type: 'select',
        name: 'vertical-align',
        label: 'Alineación Vertical',
        options: [
          { value: 'items-start', name: 'Superior' },
          { value: 'items-center', name: 'Centro' },
          { value: 'items-end', name: 'Inferior' },
          { value: 'items-stretch', name: 'Estirar' }
        ]
      },
      {
        type: 'select',
        name: 'horizontal-align',
        label: 'Alineación Horizontal',
        options: [
          { value: 'justify-start', name: 'Izquierda' },
          { value: 'justify-center', name: 'Centro' },
          { value: 'justify-end', name: 'Derecha' },
          { value: 'justify-between', name: 'Espacio Entre' },
          { value: 'justify-around', name: 'Espacio Alrededor' }
        ]
      },
      {
        type: 'select',
        name: 'section-height',
        label: 'Altura de la Sección',
        options: [
          { value: 'min-h-0', name: 'Automática' },
          { value: 'min-h-screen', name: 'Altura Completa de Pantalla' },
          { value: 'min-h-[400px]', name: 'Mediana (400px)' },
          { value: 'min-h-[600px]', name: 'Grande (600px)' },
          { value: 'min-h-[800px]', name: 'Extra Grande (800px)' }
        ]
      },
      {
        type: 'select',
        name: 'padding-vertical',
        label: 'Espaciado Vertical',
        options: [
          { value: 'py-0', name: 'Sin Espaciado' },
          { value: 'py-4', name: 'Pequeño' },
          { value: 'py-8', name: 'Normal' },
          { value: 'py-12', name: 'Mediano' },
          { value: 'py-16', name: 'Grande' },
          { value: 'py-24', name: 'Extra Grande' }
        ]
      },
      {
        type: 'select',
        name: 'padding-horizontal',
        label: 'Espaciado Horizontal',
        options: [
          { value: 'px-0', name: 'Sin Espaciado' },
          { value: 'px-4', name: 'Pequeño' },
          { value: 'px-6', name: 'Normal' },
          { value: 'px-8', name: 'Mediano' },
          { value: 'px-12', name: 'Grande' }
        ]
      },
      {
        type: 'checkbox',
        name: 'reverse-columns',
        label: 'Invertir Orden en Móvil'
      },
      {
        type: 'checkbox',
        name: 'stack-on-mobile',
        label: 'Apilar en Móvil',
        value: true
      }
    ]
  }
},
{
  id: 'simple-container'
  , label: '<b>Contenedor</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-container'
  }
  , content: {
    type: 'container',
    tagName: 'div',
    name: 'Contenedor',
    attributes: { 
      class: 'container-simple p-6 rounded-lg min-h-[200px]',
      'data-gjs-name': 'Contenedor',
      'data-gjs-droppable': 'true'
    },
    droppable: true,
    components: [
      {
        type: 'section-inner',
        tagName: 'div',
        name: 'Grid de Columnas',
        attributes: { 
          class: 'section-inner grid grid-cols-1 gap-6',
          'data-gjs-name': 'Grid de Columnas'
        },
        components: [
          {
            type: 'column',
            tagName: 'div',
            name: 'Columna 1',
            attributes: { 
              class: 'column min-h-[100px] border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center',
              'data-gjs-droppable': 'true',
              'data-gjs-draggable': 'false',
              'data-gjs-name': 'Columna 1'
            },
            droppable: true,
            components: [
              {
                type: 'text',
                tagName: 'div',
                name: 'Placeholder',
                content: '↓ Arrastra elementos aquí ↓',
                attributes: { 
                  class: 'text-gray-400 text-sm pointer-events-none',
                  'data-gjs-type': 'text',
                  'data-gjs-editable': 'false',
                  'data-gjs-name': 'Placeholder'
                }
              }
            ]
          }
        ]
      }
    ],
    traits: [
      {
        type: 'select',
        name: 'container-layout',
        label: 'Diseño de Columnas',
        changeProp: 1,
        options: [
          { value: '1-column', name: '1 Columna (100%)' },
          { value: '2-columns', name: '2 Columnas (50% / 50%)' },
          { value: '2-columns-left', name: '2 Columnas (33% / 67%)' },
          { value: '2-columns-right', name: '2 Columnas (67% / 33%)' },
          { value: '3-columns', name: '3 Columnas (33% / 33% / 33%)' },
          { value: '4-columns', name: '4 Columnas (25% cada una)' },
          { value: '3-columns-center', name: '3 Columnas (25% / 50% / 25%)' }
        ]
      },
      {
        type: 'select',
        name: 'container-width',
        label: 'Ancho del Contenedor',
        changeProp: 1,
        options: [
          { value: 'w-full', name: 'Ancho Completo (100%)' },
          { value: 'container', name: 'Contenedor Responsive' },
          { value: 'max-w-7xl', name: 'Muy Ancho (1280px)' },
          { value: 'max-w-6xl', name: 'Ancho (1152px)' },
          { value: 'max-w-4xl', name: 'Mediano (896px)' },
          { value: 'max-w-2xl', name: 'Pequeño (672px)' }
        ]
      },
      {
        type: 'select',
        name: 'column-gap',
        label: 'Espacio entre Columnas',
        changeProp: 1,
        options: [
          { value: 'gap-0', name: 'Sin Espacio' },
          { value: 'gap-2', name: 'Pequeño' },
          { value: 'gap-4', name: 'Normal' },
          { value: 'gap-6', name: 'Mediano' },
          { value: 'gap-8', name: 'Grande' },
          { value: 'gap-12', name: 'Extra Grande' }
        ]
      },
      {
        type: 'select',
        name: 'vertical-align',
        label: 'Alineación Vertical',
        changeProp: 1,
        options: [
          { value: 'items-start', name: 'Arriba' },
          { value: 'items-center', name: 'Centro' },
          { value: 'items-end', name: 'Abajo' },
          { value: 'items-stretch', name: 'Estirar' }
        ]
      },
      {
        type: 'select',
        name: 'horizontal-align',
        label: 'Alineación Horizontal',
        changeProp: 1,
        options: [
          { value: 'justify-start', name: 'Izquierda' },
          { value: 'justify-center', name: 'Centro' },
          { value: 'justify-end', name: 'Derecha' },
          { value: 'justify-between', name: 'Espacio Entre' },
          { value: 'justify-around', name: 'Espacio Alrededor' }
        ]
      },
      {
        type: 'select',
        name: 'padding',
        label: 'Espaciado Interno',
        changeProp: 1,
        options: [
          { value: 'p-0', name: 'Sin Espaciado' },
          { value: 'p-2', name: 'Muy Pequeño' },
          { value: 'p-4', name: 'Pequeño' },
          { value: 'p-6', name: 'Normal' },
          { value: 'p-8', name: 'Grande' },
          { value: 'p-12', name: 'Extra Grande' }
        ]
      },
      {
        type: 'select',
        name: 'margin',
        label: 'Margen',
        changeProp: 1,
        options: [
          { value: 'mx-auto', name: 'Centrado Horizontal' },
          { value: 'm-0', name: 'Sin Margen' },
          { value: 'm-4', name: 'Pequeño' },
          { value: 'm-8', name: 'Mediano' },
          { value: 'm-12', name: 'Grande' }
        ]
      }
    ]
  }
},
{
  id: 'text'
  , label: 'Texto'
  , category: 'Básicos'
  , content: {
    type: 'text',
    name: 'Texto',
    content: 'Haz clic para editar este texto',
    attributes: { 
      class: 'p-4',
      'data-gjs-name': 'Texto'
    },
    editable: true,
    traits: [
      {
        type: 'textarea',
        name: 'text',
        label: 'Contenido de Texto',
        changeProp: 1,
      }
    ]
  }
},
{
  id: 'heading'
  , label: 'Título'
  , category: 'Básicos'
  , content: {
    type: 'heading',
    name: 'Título',
    tagName: 'h2',
    content: 'Título Principal',
    attributes: { 
      class: 'text-2xl font-bold text-gray-900',
      'data-gjs-name': 'Título'
    },
    traits: [
      {
        type: 'text',
        name: 'text',
        label: 'Texto del Título',
        changeProp: 1,
      },
      {
        type: 'select',
        name: 'tagName',
        label: 'Etiqueta HTML',
        changeProp: 1,
        options: [
          { value: 'h1', name: 'H1 (Más grande)' },
          { value: 'h2', name: 'H2' },
          { value: 'h3', name: 'H3' },
          { value: 'h4', name: 'H4' },
          { value: 'h5', name: 'H5' },
          { value: 'h6', name: 'H6 (Más pequeño)' }
        ]
      }
    ]
  }
},
{
  id: 'paragraph'
  , label: 'Párrafo'
  , category: 'Básicos'
  , content: {
    type: 'paragraph',
    name: 'Párrafo',
    tagName: 'p',
    content: 'Este es un párrafo de ejemplo. Puedes editarlo haciendo clic en él.',
    attributes: { 
      class: 'leading-relaxed text-gray-700',
      'data-gjs-name': 'Párrafo'
    },
    editable: true,
    traits: [
      {
        type: 'textarea',
        name: 'text',
        label: 'Texto del Párrafo',
        changeProp: 1,
      }
    ]
  }
},
{
  id: 'image'
  , label: 'Imagen'
  , category: 'Básicos'
  , select: true
  , content: {
    type: 'image',
    name: 'Imagen',
    attributes: { 
      src: 'https://via.placeholder.com/800x400/3B82F6/FFFFFF?text=Tu+Imagen+Aquí',
      alt: 'Descripción de la imagen',
      'data-gjs-name': 'Imagen'
    },
    traits: [
      {
        type: 'text',
        name: 'src',
        label: 'URL de la Imagen',
        placeholder: 'https://ejemplo.com/imagen.jpg',
        changeProp: 1
      },
      {
        type: 'text',
        name: 'alt',
        label: 'Texto Alternativo',
        placeholder: 'Descripción de la imagen'
      },
      {
        type: 'select',
        name: 'image-size',
        label: 'Tamaño',
        options: [
          { value: 'thumbnail', name: 'Miniatura (150px)' },
          { value: 'medium', name: 'Mediano (300px)' },
          { value: 'large', name: 'Grande (768px)' },
          { value: 'full', name: 'Tamaño Completo' }
        ]
      },
      {
        type: 'select',
        name: 'image-align',
        label: 'Alineación',
        options: [
          { value: 'left', name: 'Izquierda' },
          { value: 'center', name: 'Centro' },
          { value: 'right', name: 'Derecha' }
        ]
      },
      {
        type: 'text',
        name: 'title',
        label: 'Título (Tooltip)',
        placeholder: 'Aparece al pasar el cursor'
      },
      {
        type: 'checkbox',
        name: 'lightbox',
        label: 'Abrir en Lightbox'
      }
    ]
  }
  , activate: true
},
{
  id: 'button'
  , label: 'Botón'
  , category: 'Básicos'
  , content: {
    type: 'button',
    tagName: 'a',
    name: 'Botón',
    content: 'Haz clic aquí',
    attributes: { 
      href: '#',
      target: '_self',
      class: 'inline-block px-6 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700',
      'data-gjs-name': 'Botón'
    },
    traits: [
      {
        type: 'text',
        name: 'text',
        label: 'Texto del Botón',
        changeProp: 1,
      },
      {
        type: 'text',
        name: 'href',
        label: 'Enlace URL',
        placeholder: 'https://ejemplo.com'
      },
      {
        type: 'select',
        name: 'target',
        label: 'Abrir Enlace',
        options: [
          { value: '_self', name: 'Misma Ventana' },
          { value: '_blank', name: 'Nueva Ventana/Pestaña' }
        ]
      },
      {
        type: 'select',
        name: 'button-type',
        label: 'Tipo de Botón',
        options: [
          { value: 'primary', name: 'Principal (Azul)' },
          { value: 'secondary', name: 'Secundario (Gris)' },
          { value: 'success', name: 'Éxito (Verde)' },
          { value: 'danger', name: 'Peligro (Rojo)' },
          { value: 'warning', name: 'Advertencia (Amarillo)' }
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
        name: 'full-width',
        label: 'Ancho Completo'
      }
    ]
  }
},
{
  id: 'link'
  , label: 'Enlace'
  , category: 'Básicos'
  , content: {
    type: 'link',
    name: 'Enlace',
    content: 'Enlace de ejemplo',
    attributes: { 
      href: '#',
      class: 'text-blue-600 underline hover:text-blue-800',
      'data-gjs-name': 'Enlace'
    },
    traits: [
      {
        type: 'text',
        name: 'href',
        label: 'URL del Enlace',
        placeholder: 'https://ejemplo.com',
        changeProp: 1
      },
      {
        type: 'select',
        name: 'target',
        label: 'Destino',
        options: [
          { value: '', name: 'Misma Ventana' },
          { value: '_blank', name: 'Nueva Ventana' },
          { value: '_parent', name: 'Marco Padre' },
          { value: '_top', name: 'Ventana Superior' }
        ]
      },
      {
        type: 'select',
        name: 'rel',
        label: 'Relación',
        options: [
          { value: '', name: 'Ninguna' },
          { value: 'nofollow', name: 'No Seguir (nofollow)' },
          { value: 'noopener', name: 'No Abridor (noopener)' },
          { value: 'noreferrer', name: 'No Referencia (noreferrer)' },
          { value: 'nofollow noopener', name: 'No Seguir + No Abridor' }
        ]
      },
      {
        type: 'text',
        name: 'title',
        label: 'Título (Tooltip)',
        placeholder: 'Aparece al pasar el cursor'
      },
      {
        type: 'select',
        name: 'link-style',
        label: 'Estilo del Enlace',
        options: [
          { value: 'underline', name: 'Subrayado' },
          { value: 'no-underline', name: 'Sin Subrayado' },
          { value: 'button', name: 'Estilo Botón' }
        ]
      }
    ]
  }
},
{
  id: 'divider'
  , label: 'Divisor'
  , category: 'Básicos'
  , content: {
    type: 'divider',
    name: 'Divisor',
    tagName: 'hr',
    attributes: { 
      class: 'my-8 border-gray-300',
      'data-gjs-name': 'Divisor'
    },
    traits: [
      {
        type: 'select',
        name: 'divider-style',
        label: 'Estilo',
        options: [
          { value: 'solid', name: 'Sólido' },
          { value: 'dashed', name: 'Punteado' },
          { value: 'dotted', name: 'Puntos' },
          { value: 'double', name: 'Doble' }
        ]
      },
      {
        type: 'select',
        name: 'divider-weight',
        label: 'Grosor',
        options: [
          { value: 'border-1', name: 'Fino (1px)' },
          { value: 'border-2', name: 'Normal (2px)' },
          { value: 'border-4', name: 'Grueso (4px)' },
          { value: 'border-8', name: 'Muy Grueso (8px)' }
        ]
      },
      {
        type: 'select',
        name: 'divider-width',
        label: 'Ancho',
        options: [
          { value: 'w-full', name: 'Completo (100%)' },
          { value: 'w-3/4', name: '75%' },
          { value: 'w-1/2', name: '50%' },
          { value: 'w-1/4', name: '25%' }
        ]
      },
      {
        type: 'select',
        name: 'divider-align',
        label: 'Alineación',
        options: [
          { value: 'mx-0', name: 'Izquierda' },
          { value: 'mx-auto', name: 'Centro' },
          { value: 'ml-auto mr-0', name: 'Derecha' }
        ]
      },
      {
        type: 'select',
        name: 'divider-spacing',
        label: 'Espaciado Vertical',
        options: [
          { value: 'my-2', name: 'Pequeño' },
          { value: 'my-4', name: 'Normal' },
          { value: 'my-8', name: 'Grande' },
          { value: 'my-16', name: 'Muy Grande' }
        ]
      }
    ]
  }
}
