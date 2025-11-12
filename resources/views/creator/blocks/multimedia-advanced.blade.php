{{-- Bloques Multimedia Avanzados --}}
{
  id: 'audio-player',
  label: 'Reproductor de Audio',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-audio'
  },
  content: `
    <div class="audio-player bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
      <div class="flex items-center mb-4">
        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-4">
          <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"></path>
          </svg>
        </div>
        <div class="flex-1">
          <h3 data-gjs-type="text" data-gjs-name="audio-title" class="font-semibold text-gray-900">Título del Audio</h3>
          <p data-gjs-type="text" data-gjs-name="audio-artist" class="text-sm text-gray-600">Artista o Descripción</p>
        </div>
      </div>
      <audio controls class="w-full">
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
      </audio>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'audio-url',
      label: 'URL del Audio',
      placeholder: 'https://ejemplo.com/audio.mp3'
    },
    {
      type: 'checkbox',
      name: 'autoplay',
      label: 'Reproducción Automática',
      value: false
    },
    {
      type: 'checkbox',
      name: 'loop',
      label: 'Repetir',
      value: false
    }
  ]
},
{
  id: 'image-carousel',
  label: 'Carrusel de Imágenes',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-carousel'
  },
  content: `
    <div class="carousel-container relative bg-gray-100 rounded-lg overflow-hidden">
      <div class="carousel-wrapper">
        <div class="carousel-slide">
          <img src="https://via.placeholder.com/800x400/3b82f6/ffffff?text=Slide+1" alt="Slide 1" class="w-full h-96 object-cover">
        </div>
        <div class="carousel-slide hidden">
          <img src="https://via.placeholder.com/800x400/8b5cf6/ffffff?text=Slide+2" alt="Slide 2" class="w-full h-96 object-cover">
        </div>
        <div class="carousel-slide hidden">
          <img src="https://via.placeholder.com/800x400/ec4899/ffffff?text=Slide+3" alt="Slide 3" class="w-full h-96 object-cover">
        </div>
      </div>
      
      <!-- Controles -->
      <button class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <button class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>
      
      <!-- Indicadores -->
      <div class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <button class="w-3 h-3 bg-white rounded-full"></button>
        <button class="w-3 h-3 bg-white bg-opacity-50 rounded-full"></button>
        <button class="w-3 h-3 bg-white bg-opacity-50 rounded-full"></button>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'checkbox',
      name: 'autoplay',
      label: 'Reproducción Automática',
      value: false
    },
    {
      type: 'select',
      name: 'transition-speed',
      label: 'Velocidad de Transición',
      options: [
        { value: 'slow', name: 'Lento (5s)' },
        { value: 'normal', name: 'Normal (3s)' },
        { value: 'fast', name: 'Rápido (1s)' }
      ]
    },
    {
      type: 'checkbox',
      name: 'show-arrows',
      label: 'Mostrar Flechas',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-dots',
      label: 'Mostrar Indicadores',
      value: true
    }
  ]
},
{
  id: 'counter-animated',
  label: 'Contador Animado',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-counter'
  },
  content: `
    <div class="counter-block text-center p-6">
      <div class="inline-flex items-center justify-center w-20 h-20 mb-4 bg-blue-100 rounded-full">
        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
      </div>
      <div class="counter-number text-4xl font-bold text-gray-900 mb-2" data-target="1000">
        <span data-gjs-type="text" data-gjs-name="counter-value">1000</span>
        <span data-gjs-type="text" data-gjs-name="counter-suffix" class="text-blue-600">+</span>
      </div>
      <p data-gjs-type="text" data-gjs-name="counter-label" class="text-gray-600">Clientes Satisfechos</p>
    </div>
  `,
  traits: [
    {
      type: 'number',
      name: 'target-number',
      label: 'Número Objetivo',
      placeholder: '1000'
    },
    {
      type: 'text',
      name: 'prefix',
      label: 'Prefijo',
      placeholder: '$'
    },
    {
      type: 'text',
      name: 'suffix',
      label: 'Sufijo',
      placeholder: '+'
    },
    {
      type: 'select',
      name: 'animation-duration',
      label: 'Duración de Animación',
      options: [
        { value: '1000', name: '1 segundo' },
        { value: '2000', name: '2 segundos' },
        { value: '3000', name: '3 segundos' }
      ]
    }
  ]
},
{
  id: 'image-box-advanced',
  label: 'Caja de Imagen Avanzada',
  category: 'Media',
  attributes: {
    class: 'gjs-block-image-box'
  },
  content: `
    <div class="image-box group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
      <img src="https://via.placeholder.com/400x300" alt="Imagen" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-300">
      <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
          <h3 data-gjs-type="text" data-gjs-name="image-box-title" class="text-xl font-bold mb-2">Título de la Imagen</h3>
          <p data-gjs-type="text" data-gjs-name="image-box-description" class="text-sm">Descripción que aparece al hacer hover sobre la imagen.</p>
        </div>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'image-url',
      label: 'URL de Imagen',
      placeholder: 'https://ejemplo.com/imagen.jpg'
    },
    {
      type: 'select',
      name: 'overlay-style',
      label: 'Estilo de Overlay',
      options: [
        { value: 'gradient', name: 'Gradiente' },
        { value: 'solid', name: 'Sólido' },
        { value: 'none', name: 'Sin Overlay' }
      ]
    },
    {
      type: 'text',
      name: 'link-url',
      label: 'Enlace (opcional)',
      placeholder: 'https://ejemplo.com'
    }
  ]
},
{
  id: 'soundcloud-embed',
  label: 'SoundCloud',
  category: 'Multimedia',
  attributes: {
    class: 'gjs-block-soundcloud'
  },
  content: `
    <div class="soundcloud-embed rounded-lg overflow-hidden shadow-lg">
      <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" 
        src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/293&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true">
      </iframe>
      <div class="px-4 py-2 bg-gray-50 text-center">
        <p data-gjs-type="text" data-gjs-name="soundcloud-caption" class="text-sm text-gray-600">Reproductor de SoundCloud</p>
      </div>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'soundcloud-url',
      label: 'URL de SoundCloud',
      placeholder: 'https://soundcloud.com/...'
    },
    {
      type: 'select',
      name: 'player-type',
      label: 'Tipo de Reproductor',
      options: [
        { value: 'classic', name: 'Clásico' },
        { value: 'visual', name: 'Visual con Artwork' }
      ]
    },
    {
      type: 'checkbox',
      name: 'autoplay',
      label: 'Reproducción Automática',
      value: false
    }
  ]
}

