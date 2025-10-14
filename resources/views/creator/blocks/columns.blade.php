{{-- Bloques de Columnas --}}
{
  id: '1-column',
  label: '1 Columna',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="w-full p-4 bg-white border border-gray-200 rounded-lg">
        <h3 class="mb-2 text-lg font-semibold">Contenido de 1 Columna</h3>
        <p class="text-gray-600">Este es un contenedor de una sola columna. Perfecto para contenido centrado.</p>
      </div>
    </div>
  `
},
{
  id: '2-columns',
  label: '2 Columnas',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 1</h3>
          <p class="text-gray-600">Contenido de la primera columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 2</h3>
          <p class="text-gray-600">Contenido de la segunda columna.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '3-columns',
  label: '3 Columnas',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 1</h3>
          <p class="text-gray-600">Primera columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 2</h3>
          <p class="text-gray-600">Segunda columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 3</h3>
          <p class="text-gray-600">Tercera columna.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '4-columns',
  label: '4 Columnas',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 1</h3>
          <p class="text-gray-600">Primera columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 2</h3>
          <p class="text-gray-600">Segunda columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 3</h3>
          <p class="text-gray-600">Tercera columna.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna 4</h3>
          <p class="text-gray-600">Cuarta columna.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '2-columns-3-7',
  label: '2 Columnas 3/7',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-10 gap-4">
        <div class="md:col-span-3 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna Pequeña</h3>
          <p class="text-gray-600">30% del ancho.</p>
        </div>
        <div class="md:col-span-7 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna Grande</h3>
          <p class="text-gray-600">70% del ancho. Perfecto para contenido principal con sidebar.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '2-columns-7-3',
  label: '2 Columnas 7/3',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-10 gap-4">
        <div class="md:col-span-7 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Contenido Principal</h3>
          <p class="text-gray-600">70% del ancho. Área principal de contenido.</p>
        </div>
        <div class="md:col-span-3 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Sidebar</h3>
          <p class="text-gray-600">30% del ancho. Widgets y enlaces.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '2-columns-1-1',
  label: '2 Columnas 1/1',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna Izquierda</h3>
          <p class="text-gray-600">50% del ancho. Columna izquierda.</p>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Columna Derecha</h3>
          <p class="text-gray-600">50% del ancho. Columna derecha.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: '3-columns-1-2-1',
  label: '3 Columnas 1/2/1',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-1 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Sidebar</h3>
          <p class="text-gray-600">25% del ancho.</p>
        </div>
        <div class="md:col-span-2 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Contenido Central</h3>
          <p class="text-gray-600">50% del ancho. Área principal.</p>
        </div>
        <div class="md:col-span-1 p-4 bg-white border border-gray-200 rounded-lg">
          <h3 class="mb-2 text-lg font-semibold">Sidebar</h3>
          <p class="text-gray-600">25% del ancho.</p>
        </div>
      </div>
    </div>
  `
},
{
  id: 'section-container',
  label: 'Contenedor',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <div class="w-full p-6 bg-gray-50 border border-gray-200 rounded-lg">
        <h3 class="mb-2 text-lg font-semibold">Contenedor de Sección</h3>
        <p class="text-gray-600">Un contenedor simple para agrupar contenido.</p>
      </div>
    </div>
  `
},
{
  id: 'divider',
  label: 'Divisor',
  category: 'Columnas',
  content: `
    <div class="container mx-auto px-4">
      <hr class="my-8 border-gray-300">
    </div>
  `
}
