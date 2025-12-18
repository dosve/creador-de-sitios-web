{{-- Bloques Multimedia --}}
{
  id: 'video',
  label: '<b>Video</b>',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-video'
  },
  content: {
    type: 'video',
    tagName: 'div',
    name: 'Video',
    editable: false,  // ✅ BLOQUEADO: No edición directa
    droppable: false, // ✅ BLOQUEADO: No acepta hijos
    removable: true,  // ✅ PERMITIDO: Se puede eliminar
    selectable: true, // ✅ PERMITIDO: Se puede seleccionar
    attributes: {
      class: 'mb-8 video-container',
      'data-gjs-type': 'video',
      'data-gjs-name': 'Video',
      'data-gjs-editable': 'false'
    },
    components: [
      {
        tagName: 'video',
        selectable: false,
        hoverable: false,
        draggable: false,
        removable: false,
        editable: false,
        attributes: {
          class: 'w-full rounded-lg shadow-lg',
          controls: 'true'
        },
        components: [
          {
            tagName: 'source',
            selectable: false,
            editable: false,
            removable: false,
            attributes: {
              src: 'https://www.w3schools.com/html/mov_bbb.mp4',
              type: 'video/mp4'
            }
          }
        ]
      }
    ]
    // Los traits están definidos en el componente video.js
  }
},
{
  id: 'gallery',
  label: 'Galería',
  category: 'Multimedia', attributes: {
    class: 'gjs-block-gallery'
  }
  , content: `<section class="py-16 gallery">
    <div class="container px-4 mx-auto">
        <h2 class="mb-12 text-3xl font-bold text-center">Galería de Imágenes</h2>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <img src="https://via.placeholder.com/300x300" alt="Imagen 1" class="object-cover w-full h-48 transition-transform rounded-lg hover:scale-105">
            <img src="https://via.placeholder.com/300x300" alt="Imagen 2" class="object-cover w-full h-48 transition-transform rounded-lg hover:scale-105">
            <img src="https://via.placeholder.com/300x300" alt="Imagen 3" class="object-cover w-full h-48 transition-transform rounded-lg hover:scale-105">
            <img src="https://via.placeholder.com/300x300" alt="Imagen 4" class="object-cover w-full h-48 transition-transform rounded-lg hover:scale-105">
        </div>
    </div>
  </section>`
}
