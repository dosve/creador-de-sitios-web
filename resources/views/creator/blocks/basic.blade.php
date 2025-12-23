{{-- Bloques Básicos --}}
{
  id: 'simple-container'
  , label: '<b>Contenedor</b>'
  , category: 'Diseño'
  , attributes: {
    class: 'gjs-block-container'
  }
  , content: {
    type: 'container',
    tagName: 'div',
    name: 'Contenedor',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: true,  // ✅ PERMITIDO: Acepta elementos directamente
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true,   // ✅ PERMITIDO: Se puede seleccionar
    attributes: { 
      class: 'container-flex flex flex-col md:flex-row gap-4 p-6 min-h-[200px] rounded-lg',
      'data-gjs-name': 'Contenedor',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    },
    components: [
      {
        type: 'text',
        tagName: 'div',
        name: 'Placeholder',
        content: '↓ Arrastra elementos aquí ↓',
        attributes: { 
          class: 'text-gray-400 text-sm pointer-events-none text-center w-full',
          'data-gjs-type': 'text',
          'data-gjs-editable': 'false',
          'data-gjs-name': 'Placeholder'
        }
      }
    ]
    // Los traits se definen en el componente registrado (container.js)
    // Esto asegura que todas las propiedades estén disponibles al agregar el contenedor
  }
},
{
  id: 'text'
  , label: '<b>Texto</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-text'
  }
  , content: {
    type: 'text',
    tagName: 'div',
    name: 'Texto',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    content: 'Haz clic para editar este texto',
    attributes: { 
      class: 'text-component p-4 text-gray-700',
      'data-gjs-name': 'Texto',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    },
    traits: [
      {
        type: 'text',
        name: 'text-content',
        label: 'Contenido de Texto',
        changeProp: 1,
        placeholder: 'Ingresa el texto aquí'
      },
      {
        type: 'select',
        name: 'text-size',
        label: 'Tamaño del Texto',
        changeProp: 1,
        options: [
          { value: 'text-xs', name: 'Extra Pequeño (12px)' },
          { value: 'text-sm', name: 'Pequeño (14px)' },
          { value: 'text-base', name: 'Normal (16px)' },
          { value: 'text-lg', name: 'Grande (18px)' },
          { value: 'text-xl', name: 'Extra Grande (20px)' },
          { value: 'text-2xl', name: '2XL (24px)' },
          { value: 'text-3xl', name: '3XL (30px)' }
        ]
      },
      {
        type: 'select',
        name: 'text-color',
        label: 'Color del Texto',
        changeProp: 1,
        options: [
          { value: 'text-gray-700', name: 'Gris Oscuro' },
          { value: 'text-gray-900', name: 'Negro' },
          { value: 'text-blue-600', name: 'Azul' },
          { value: 'text-green-600', name: 'Verde' },
          { value: 'text-red-600', name: 'Rojo' },
          { value: 'text-purple-600', name: 'Morado' },
          { value: 'text-white', name: 'Blanco' }
        ]
      },
      {
        type: 'select',
        name: 'text-align',
        label: 'Alineación',
        changeProp: 1,
        options: [
          { value: 'text-left', name: 'Izquierda' },
          { value: 'text-center', name: 'Centro' },
          { value: 'text-right', name: 'Derecha' },
          { value: 'text-justify', name: 'Justificado' }
        ]
      },
      {
        type: 'select',
        name: 'text-weight',
        label: 'Grosor de Fuente',
        changeProp: 1,
        options: [
          { value: 'font-normal', name: 'Normal' },
          { value: 'font-medium', name: 'Medio' },
          { value: 'font-semibold', name: 'Semi Negrita' },
          { value: 'font-bold', name: 'Negrita' }
        ]
      },
      {
        type: 'select',
        name: 'text-padding',
        label: 'Espaciado Interno',
        changeProp: 1,
        options: [
          { value: 'p-0', name: 'Sin Espaciado' },
          { value: 'p-2', name: 'Pequeño (8px)' },
          { value: 'p-4', name: 'Normal (16px)' },
          { value: 'p-6', name: 'Grande (24px)' },
          { value: 'p-8', name: 'Extra Grande (32px)' }
        ]
      }
    ]
  }
},
{
  id: 'heading'
  , label: '<b>Título</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-heading'
  }
  , content: {
    type: 'heading',
    tagName: 'h2',
    name: 'Título',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    content: 'Título Principal',
    attributes: { 
      class: 'heading-component text-2xl font-bold text-gray-900 mb-4',
      'data-gjs-name': 'Título',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    },
    traits: [
      {
        type: 'text',
        name: 'heading-text',
        label: 'Texto del Título',
        changeProp: 1,
        placeholder: 'Ingresa el título aquí'
      },
      {
        type: 'select',
        name: 'heading-tag',
        label: 'Nivel de Título',
        changeProp: 1,
        options: [
          { value: 'h1', name: 'H1 (Más grande)' },
          { value: 'h2', name: 'H2' },
          { value: 'h3', name: 'H3' },
          { value: 'h4', name: 'H4' },
          { value: 'h5', name: 'H5' },
          { value: 'h6', name: 'H6 (Más pequeño)' }
        ]
      },
      {
        type: 'select',
        name: 'heading-size',
        label: 'Tamaño del Título',
        changeProp: 1,
        options: [
          { value: 'text-xl', name: 'XL (20px)' },
          { value: 'text-2xl', name: '2XL (24px)' },
          { value: 'text-3xl', name: '3XL (30px)' },
          { value: 'text-4xl', name: '4XL (36px)' },
          { value: 'text-5xl', name: '5XL (48px)' },
          { value: 'text-6xl', name: '6XL (60px)' }
        ]
      },
      {
        type: 'select',
        name: 'heading-color',
        label: 'Color del Título',
        changeProp: 1,
        options: [
          { value: 'text-gray-900', name: 'Negro' },
          { value: 'text-gray-700', name: 'Gris Oscuro' },
          { value: 'text-blue-600', name: 'Azul' },
          { value: 'text-green-600', name: 'Verde' },
          { value: 'text-red-600', name: 'Rojo' },
          { value: 'text-purple-600', name: 'Morado' },
          { value: 'text-white', name: 'Blanco' }
        ]
      },
      {
        type: 'select',
        name: 'heading-align',
        label: 'Alineación',
        changeProp: 1,
        options: [
          { value: 'text-left', name: 'Izquierda' },
          { value: 'text-center', name: 'Centro' },
          { value: 'text-right', name: 'Derecha' }
        ]
      },
      {
        type: 'select',
        name: 'heading-weight',
        label: 'Grosor de Fuente',
        changeProp: 1,
        options: [
          { value: 'font-normal', name: 'Normal' },
          { value: 'font-medium', name: 'Medio' },
          { value: 'font-semibold', name: 'Semi Negrita' },
          { value: 'font-bold', name: 'Negrita' },
          { value: 'font-extrabold', name: 'Extra Negrita' }
        ]
      },
      {
        type: 'select',
        name: 'heading-margin',
        label: 'Espaciado Inferior',
        changeProp: 1,
        options: [
          { value: 'mb-0', name: 'Sin Espaciado' },
          { value: 'mb-2', name: 'Pequeño (8px)' },
          { value: 'mb-4', name: 'Normal (16px)' },
          { value: 'mb-6', name: 'Grande (24px)' },
          { value: 'mb-8', name: 'Extra Grande (32px)' }
        ]
      }
    ]
  }
},
{
  id: 'paragraph'
  , label: '<b>Párrafo</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-paragraph'
  }
  , content: {
    type: 'paragraph',
    tagName: 'p',
    name: 'Párrafo',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    content: 'Este es un párrafo de ejemplo. Puedes editarlo desde el panel de propiedades.',
    attributes: { 
      class: 'paragraph-component leading-relaxed text-gray-700 mb-4',
      'data-gjs-name': 'Párrafo',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    },
    traits: [
      {
        type: 'text',
        name: 'paragraph-text',
        label: 'Texto del Párrafo',
        changeProp: 1,
        placeholder: 'Ingresa el texto del párrafo aquí'
      },
      {
        type: 'select',
        name: 'paragraph-size',
        label: 'Tamaño del Texto',
        changeProp: 1,
        options: [
          { value: 'text-sm', name: 'Pequeño (14px)' },
          { value: 'text-base', name: 'Normal (16px)' },
          { value: 'text-lg', name: 'Grande (18px)' },
          { value: 'text-xl', name: 'Extra Grande (20px)' }
        ]
      },
      {
        type: 'select',
        name: 'paragraph-color',
        label: 'Color del Texto',
        changeProp: 1,
        options: [
          { value: 'text-gray-700', name: 'Gris Oscuro' },
          { value: 'text-gray-600', name: 'Gris Medio' },
          { value: 'text-gray-900', name: 'Negro' },
          { value: 'text-blue-600', name: 'Azul' },
          { value: 'text-green-600', name: 'Verde' }
        ]
      },
      {
        type: 'select',
        name: 'paragraph-align',
        label: 'Alineación',
        changeProp: 1,
        options: [
          { value: 'text-left', name: 'Izquierda' },
          { value: 'text-center', name: 'Centro' },
          { value: 'text-right', name: 'Derecha' },
          { value: 'text-justify', name: 'Justificado' }
        ]
      },
      {
        type: 'select',
        name: 'paragraph-line-height',
        label: 'Altura de Línea',
        changeProp: 1,
        options: [
          { value: 'leading-tight', name: 'Ajustada' },
          { value: 'leading-normal', name: 'Normal' },
          { value: 'leading-relaxed', name: 'Relajada' },
          { value: 'leading-loose', name: 'Suelta' }
        ]
      },
      {
        type: 'select',
        name: 'paragraph-margin',
        label: 'Espaciado Inferior',
        changeProp: 1,
        options: [
          { value: 'mb-0', name: 'Sin Espaciado' },
          { value: 'mb-2', name: 'Pequeño (8px)' },
          { value: 'mb-4', name: 'Normal (16px)' },
          { value: 'mb-6', name: 'Grande (24px)' }
        ]
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
    tagName: 'img',
    name: 'Imagen',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: { 
      src: '/images/default-image.jpg',
      alt: 'Descripción de la imagen',
      class: 'image-component max-w-full h-auto rounded-lg',
      'data-gjs-name': 'Imagen',
      'data-gjs-editable': 'false'
    }
    // Los traits se definen en el componente registrado (image.js)
    // Esto asegura que el botón "Seleccionar desde Galería" siempre esté presente
  }
  , activate: true
},
{
  id: 'button'
  , label: '<b>Botón</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-button'
  }
  , content: {
    type: 'button',
    tagName: 'a',
    name: 'Botón',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    content: 'Haz clic aquí',
    attributes: { 
      href: '#',
      target: '_self',
      class: 'button-component inline-block px-6 py-2 text-white text-center transition-colors bg-blue-600 rounded-md hover:bg-blue-700 font-medium',
      'data-gjs-name': 'Botón',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    },
    traits: [
      {
        type: 'text',
        name: 'button-text',
        label: 'Texto del Botón',
        changeProp: 1,
        placeholder: 'Ingresa el texto del botón'
      },
      {
        type: 'text',
        name: 'button-href',
        label: 'Enlace URL',
        changeProp: 1,
        placeholder: 'https://ejemplo.com'
      },
      {
        type: 'select',
        name: 'button-target',
        label: 'Abrir Enlace',
        changeProp: 1,
        options: [
          { value: '_self', name: 'Misma Ventana' },
          { value: '_blank', name: 'Nueva Ventana/Pestaña' }
        ]
      },
      {
        type: 'select',
        name: 'button-style',
        label: 'Estilo del Botón',
        changeProp: 1,
        options: [
          { value: 'bg-blue-600 hover:bg-blue-700', name: 'Principal (Azul)' },
          { value: 'bg-gray-600 hover:bg-gray-700', name: 'Secundario (Gris)' },
          { value: 'bg-green-600 hover:bg-green-700', name: 'Éxito (Verde)' },
          { value: 'bg-red-600 hover:bg-red-700', name: 'Peligro (Rojo)' },
          { value: 'bg-yellow-600 hover:bg-yellow-700', name: 'Advertencia (Amarillo)' },
          { value: 'bg-purple-600 hover:bg-purple-700', name: 'Morado' },
          { value: 'bg-pink-600 hover:bg-pink-700', name: 'Rosa' }
        ]
      },
      {
        type: 'select',
        name: 'button-size',
        label: 'Tamaño del Botón',
        changeProp: 1,
        options: [
          { value: 'px-4 py-2 text-sm', name: 'Pequeño' },
          { value: 'px-6 py-2 text-base', name: 'Mediano' },
          { value: 'px-8 py-3 text-lg', name: 'Grande' },
          { value: 'px-10 py-4 text-xl', name: 'Extra Grande' }
        ]
      },
      {
        type: 'select',
        name: 'button-width',
        label: 'Ancho del Botón',
        changeProp: 1,
        options: [
          { value: '', name: 'Automático (Según contenido)' },
          { value: 'w-auto', name: 'Automático' },
          { value: 'w-24', name: 'Muy Pequeño (96px)' },
          { value: 'w-32', name: 'Pequeño (128px)' },
          { value: 'w-40', name: 'Mediano (160px)' },
          { value: 'w-48', name: 'Grande (192px)' },
          { value: 'w-64', name: 'Extra Grande (256px)' },
          { value: 'w-full', name: 'Ancho Completo (100%)' },
          { value: 'w-1/2', name: 'Mitad (50%)' },
          { value: 'w-1/3', name: 'Un Tercio (33%)' },
          { value: 'w-2/3', name: 'Dos Tercios (67%)' },
          { value: 'w-3/4', name: 'Tres Cuartos (75%)' }
        ]
      },
      {
        type: 'select',
        name: 'button-align',
        label: 'Alineación',
        changeProp: 1,
        options: [
          { value: '', name: 'Por Defecto' },
          { value: 'block mx-auto', name: 'Centrado' },
          { value: 'block ml-auto', name: 'Derecha' },
          { value: 'block mr-auto', name: 'Izquierda' }
        ]
      },
      {
        type: 'select',
        name: 'button-radius',
        label: 'Bordes Redondeados',
        changeProp: 1,
        options: [
          { value: 'rounded-none', name: 'Sin Redondeo' },
          { value: 'rounded', name: 'Pequeño' },
          { value: 'rounded-md', name: 'Mediano' },
          { value: 'rounded-lg', name: 'Grande' },
          { value: 'rounded-full', name: 'Completo (Píldora)' }
        ]
      }
    ]
  }
},
{
  id: 'link'
  , label: '<b>Enlace</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-link'
  }
  , content: {
    type: 'link',
    tagName: 'a',
    name: 'Enlace',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    content: 'Enlace de ejemplo',
    attributes: { 
      href: '#',
      class: 'link-component text-blue-600 underline hover:text-blue-800',
      'data-gjs-name': 'Enlace',
      'data-gjs-editable': 'false'  // ✅ Protección adicional
    }
    // Los traits están definidos en el componente link.js
  }
},
{
  id: 'unordered-list'
  , label: '<b>Lista No Ordenada</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-list'
  }
  , content: {
    type: 'unordered-list',
    tagName: 'ul',
    name: 'Lista No Ordenada',
    editable: false,
    droppable: true,
    removable: true,
    selectable: true,
    attributes: { 
      class: 'list-component list-disc list-inside space-y-2 mb-4',
      'data-gjs-name': 'Lista No Ordenada',
      'data-gjs-editable': 'false'
    },
    components: [
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Elemento de lista 1',
        editable: true,
        attributes: { class: 'list-item' }
      },
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Elemento de lista 2',
        editable: true,
        attributes: { class: 'list-item' }
      },
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Elemento de lista 3',
        editable: true,
        attributes: { class: 'list-item' }
      }
    ],
    traits: [
      {
        type: 'select',
        name: 'list-style',
        label: 'Estilo de Viñeta',
        changeProp: 1,
        options: [
          { value: 'list-disc', name: 'Círculo (Disc)' },
          { value: 'list-circle', name: 'Círculo Vacío (Circle)' },
          { value: 'list-square', name: 'Cuadrado (Square)' },
          { value: 'list-none', name: 'Sin Viñeta' }
        ]
      },
      {
        type: 'select',
        name: 'list-position',
        label: 'Posición de Viñeta',
        changeProp: 1,
        options: [
          { value: 'list-inside', name: 'Dentro' },
          { value: 'list-outside', name: 'Fuera' }
        ]
      },
      {
        type: 'select',
        name: 'list-spacing',
        label: 'Espaciado entre Elementos',
        changeProp: 1,
        options: [
          { value: 'space-y-1', name: 'Muy Pequeño (4px)' },
          { value: 'space-y-2', name: 'Pequeño (8px)' },
          { value: 'space-y-3', name: 'Mediano (12px)' },
          { value: 'space-y-4', name: 'Grande (16px)' },
          { value: 'space-y-6', name: 'Extra Grande (24px)' }
        ]
      },
      {
        type: 'select',
        name: 'list-margin',
        label: 'Espaciado Inferior',
        changeProp: 1,
        options: [
          { value: 'mb-0', name: 'Sin Espaciado' },
          { value: 'mb-2', name: 'Pequeño (8px)' },
          { value: 'mb-4', name: 'Normal (16px)' },
          { value: 'mb-6', name: 'Grande (24px)' },
          { value: 'mb-8', name: 'Extra Grande (32px)' }
        ]
      }
    ]
  }
},
{
  id: 'ordered-list'
  , label: '<b>Lista Ordenada</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-list'
  }
  , content: {
    type: 'ordered-list',
    tagName: 'ol',
    name: 'Lista Ordenada',
    editable: false,
    droppable: true,
    removable: true,
    selectable: true,
    attributes: { 
      class: 'list-component list-decimal list-inside space-y-2 mb-4',
      'data-gjs-name': 'Lista Ordenada',
      'data-gjs-editable': 'false'
    },
    components: [
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Primer elemento',
        editable: true,
        attributes: { class: 'list-item' }
      },
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Segundo elemento',
        editable: true,
        attributes: { class: 'list-item' }
      },
      {
        type: 'list-item',
        tagName: 'li',
        content: 'Tercer elemento',
        editable: true,
        attributes: { class: 'list-item' }
      }
    ],
    traits: [
      {
        type: 'select',
        name: 'list-type',
        label: 'Tipo de Numeración',
        changeProp: 1,
        options: [
          { value: 'list-decimal', name: 'Números (1, 2, 3...)' },
          { value: 'list-decimal-leading-zero', name: 'Números con Cero (01, 02, 03...)' },
          { value: 'list-lower-roman', name: 'Romanos Minúsculas (i, ii, iii...)' },
          { value: 'list-upper-roman', name: 'Romanos Mayúsculas (I, II, III...)' },
          { value: 'list-lower-alpha', name: 'Letras Minúsculas (a, b, c...)' },
          { value: 'list-upper-alpha', name: 'Letras Mayúsculas (A, B, C...)' },
          { value: 'list-none', name: 'Sin Numeración' }
        ]
      },
      {
        type: 'select',
        name: 'list-position',
        label: 'Posición de Numeración',
        changeProp: 1,
        options: [
          { value: 'list-inside', name: 'Dentro' },
          { value: 'list-outside', name: 'Fuera' }
        ]
      },
      {
        type: 'select',
        name: 'list-spacing',
        label: 'Espaciado entre Elementos',
        changeProp: 1,
        options: [
          { value: 'space-y-1', name: 'Muy Pequeño (4px)' },
          { value: 'space-y-2', name: 'Pequeño (8px)' },
          { value: 'space-y-3', name: 'Mediano (12px)' },
          { value: 'space-y-4', name: 'Grande (16px)' },
          { value: 'space-y-6', name: 'Extra Grande (24px)' }
        ]
      },
      {
        type: 'select',
        name: 'list-margin',
        label: 'Espaciado Inferior',
        changeProp: 1,
        options: [
          { value: 'mb-0', name: 'Sin Espaciado' },
          { value: 'mb-2', name: 'Pequeño (8px)' },
          { value: 'mb-4', name: 'Normal (16px)' },
          { value: 'mb-6', name: 'Grande (24px)' },
          { value: 'mb-8', name: 'Extra Grande (32px)' }
        ]
      }
    ]
  }
},
