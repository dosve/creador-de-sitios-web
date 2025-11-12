{{-- Bloques Multimedia --}}
{
  id: 'video',
  label: 'Video',
  category: 'Multimedia', attributes: {
    class: 'gjs-block-video'
  }
  , content: `<div class="mb-8 video-container">
    <video controls class="w-full rounded-lg shadow-lg">
        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>
  </div>`
},
{
  id: 'youtube',
  label: 'YouTube',
  category: 'Multimedia', 
  attributes: {
    class: 'gjs-block-video'
  },
  content: {
    type: 'youtube-video',
    name: 'YouTube',
    draggable: true,
    droppable: false,
    selectable: true,
    editable: true,
    removable: true,
    hoverable: true,
    layerable: true,
    attributes: {
      'data-gjs-type': 'youtube-video',
      'data-gjs-name': 'YouTube',
      class: 'mb-8 youtube-container',
      style: 'position: relative; cursor: pointer;'
    },
    components: [
      {
        tagName: 'div',
        selectable: false,
        hoverable: false,
        draggable: false,
        removable: false,
        editable: false,
        attributes: {
          class: 'relative overflow-hidden rounded-lg',
          style: 'padding-bottom: 56.25%;'
        },
        components: [
          {
            tagName: 'iframe',
            selectable: false,
            hoverable: false,
            draggable: false,
            removable: false,
            editable: false,
            attributes: {
              class: 'absolute top-0 left-0 w-full h-full',
              src: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
              frameborder: '0',
              allowfullscreen: '',
              allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
            }
          }
        ]
      }
    ]
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
