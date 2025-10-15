{{-- Bloques Básicos --}}
{
  id: 'section'
  , label: '<b>Sección</b>'
  , category: 'Básicos'
  , attributes: {
    class: 'gjs-block-section'
  }
  , content: `<section class="p-8 bg-gray-100">
    <h1 class="text-3xl font-bold text-center">Título de la Sección</h1>
    <p class="mt-4 text-center text-gray-600">Contenido de la sección...</p>
  </section>`
},
{
  id: 'text'
  , label: 'Texto'
  , category: 'Básicos'
  , content: '<div data-gjs-type="text" class="p-4">Haz clic para editar este texto</div>'
},
{
  id: 'heading'
  , label: 'Título'
  , category: 'Básicos'
  , content: '<h2 class="text-2xl font-bold text-gray-900">Título Principal</h2>'
},
{
  id: 'paragraph'
  , label: 'Párrafo'
  , category: 'Básicos'
  , content: '<p class="leading-relaxed text-gray-700">Este es un párrafo de ejemplo. Puedes editarlo haciendo clic en él.</p>'
},
{
  id: 'image'
  , label: 'Imagen'
  , category: 'Básicos'
  , select: true
  , content: {
    type: 'image'
  }
  , activate: true
},
{
  id: 'button'
  , label: 'Botón'
  , category: 'Básicos'
  , content: '<button class="px-6 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">Botón</button>'
},
{
  id: 'link'
  , label: 'Enlace'
  , category: 'Básicos'
  , content: '<a href="#" class="text-blue-600 underline hover:text-blue-800">Enlace de ejemplo</a>'
},
{
  id: 'divider'
  , label: 'Divisor'
  , category: 'Básicos'
  , content: '<hr class="my-8 border-gray-300">'
}
