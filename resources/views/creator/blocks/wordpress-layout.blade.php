{{-- Bloques de Diseño de WordPress --}}
{
  id: 'group',
  label: 'Grupo',
  category: 'Diseño',
  content: `
    <div class="group-container bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6">
      <div class="text-center text-gray-600">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <p class="text-sm">Grupo de bloques</p>
        <p class="text-xs text-gray-500">Arrastra bloques aquí</p>
      </div>
    </div>
  `
},
{
  id: 'separator',
  label: 'Separador',
  category: 'Diseño',
  content: `
    <div class="separator-container my-8">
      <hr class="border-t-2 border-gray-300">
    </div>
  `
},
{
  id: 'spacer',
  label: 'Espaciador',
  category: 'Diseño',
  content: `
    <div class="spacer-container">
      <div class="h-16 bg-gray-100 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
        <span class="text-gray-500 text-sm">Espaciador</span>
      </div>
    </div>
  `
},
{
  id: 'cover',
  label: 'Cobertura',
  category: 'Diseño',
  content: `
    <div class="cover-container relative h-96 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg overflow-hidden">
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative z-10 flex items-center justify-center h-full text-center text-white p-8">
        <div>
          <h2 class="text-4xl font-bold mb-4">Título de Cobertura</h2>
          <p class="text-xl mb-6">Texto superpuesto sobre imagen de fondo</p>
          <button class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Acción Principal
          </button>
        </div>
      </div>
    </div>
  `
}
