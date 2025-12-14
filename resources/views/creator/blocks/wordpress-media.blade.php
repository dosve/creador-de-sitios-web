{{-- Bloques de Medios de WordPress --}}
{
  id: 'audio',
  label: 'Audio',
  category: 'Multimedia',
  content: `
    <div class="audio-player bg-gray-100 rounded-lg p-6">
      <div class="flex items-center space-x-4">
        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.807L4.617 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.617l3.766-3.807a1 1 0 011.617.807zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="font-semibold text-gray-900">Título del Audio</h3>
          <p class="text-sm text-gray-600">Descripción del archivo de audio</p>
          <div class="mt-2 flex items-center space-x-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
              ▶ Reproducir
            </button>
            <span class="text-sm text-gray-500">3:45</span>
          </div>
        </div>
      </div>
    </div>
  `
},
{
  id: 'file',
  label: 'Archivo',
  category: 'Multimedia',
  content: `
    <div class="file-download bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
      <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="font-semibold text-gray-900">documento.pdf</h3>
          <p class="text-sm text-gray-600">2.5 MB • PDF</p>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Descargar
        </button>
      </div>
    </div>
  `
},
{
  id: 'cover-image',
  label: 'Imagen de Portada',
  category: 'Multimedia',
  content: `
    <div class="cover-image relative h-96 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg overflow-hidden">
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative z-10 flex items-center justify-center h-full text-center text-white p-8">
        <div>
          <h2 class="text-4xl font-bold mb-4">Título de la Portada</h2>
          <p class="text-xl mb-6">Subtítulo descriptivo que complementa el título principal</p>
          <button class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Llamada a la Acción
          </button>
        </div>
      </div>
    </div>
  `
},
{
  id: 'carousel',
  label: 'Carrusel',
  category: 'Multimedia',
  content: `
    <div class="carousel-container relative">
      <div class="carousel-wrapper overflow-hidden rounded-lg">
        <div class="carousel-track flex transition-transform duration-300">
          <div class="carousel-slide flex-shrink-0 w-full">
            <img src="https://via.placeholder.com/800x400" alt="Imagen 1" class="w-full h-64 object-cover">
          </div>
          <div class="carousel-slide flex-shrink-0 w-full">
            <img src="https://via.placeholder.com/800x400" alt="Imagen 2" class="w-full h-64 object-cover">
          </div>
          <div class="carousel-slide flex-shrink-0 w-full">
            <img src="https://via.placeholder.com/800x400" alt="Imagen 3" class="w-full h-64 object-cover">
          </div>
        </div>
      </div>
      <div class="carousel-controls flex justify-center space-x-2 mt-4">
        <button class="w-3 h-3 bg-gray-400 rounded-full hover:bg-gray-600"></button>
        <button class="w-3 h-3 bg-blue-600 rounded-full"></button>
        <button class="w-3 h-3 bg-gray-400 rounded-full hover:bg-gray-600"></button>
      </div>
    </div>
  `
},
{
  id: 'background-image',
  label: 'Imagen de Fondo',
  category: 'Multimedia',
  content: `
    <div class="background-image-section relative h-96 bg-cover bg-center bg-no-repeat rounded-lg overflow-hidden" style="background-image: url('https://via.placeholder.com/1200x600')">
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <div class="relative z-10 flex items-center justify-center h-full text-center text-white p-8">
        <div>
          <h2 class="text-3xl font-bold mb-4">Contenido sobre Imagen</h2>
          <p class="text-lg mb-6">Texto superpuesto sobre la imagen de fondo</p>
          <button class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Botón de Acción
          </button>
        </div>
      </div>
    </div>
  `
}
