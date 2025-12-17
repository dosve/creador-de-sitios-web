{{-- 
  ========================================
  📝 WIDGETS DE BLOG
  ========================================
  Categoría: Blog
  Widget: Listado de Posts Dinámicos
--}}

{{-- Widget 1: Listado de Posts Dinámicos (Con API) --}}
{
  id: 'blog-posts-list-dynamic',
  label: '📝 Listado de Posts',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-blog-posts',
    title: 'Listado dinámico de posts del blog con estilos adaptativos'
  },
  content: `<section class="py-16 bg-gray-50 blog-list" data-dynamic-blog="true">
    <div class="container px-4 mx-auto">
      <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Últimos Artículos</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="blog-posts-container" data-website-id="">
        <!-- Los posts se cargarán dinámicamente aquí -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div class="p-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
              <span>15 Enero, 2024</span>
              <span class="mx-2">•</span>
              <span>5 min lectura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Título del Artículo de Ejemplo</h3>
            <p class="text-gray-600 mb-4">Los posts reales se mostrarán en la vista previa con los estilos de tu plantilla.</p>
            <div class="flex items-center justify-between mt-4">
              <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Autor</span>
              </div>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
            </div>
          </div>
        </article>
        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="w-full h-48 bg-gradient-to-br from-green-100 to-blue-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div class="p-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
              <span>12 Enero, 2024</span>
              <span class="mx-2">•</span>
              <span>7 min lectura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Otro Artículo de Ejemplo</h3>
            <p class="text-gray-600 mb-4">Los posts reales se cargarán automáticamente cuando agregues contenido a tu blog.</p>
            <div class="flex items-center justify-between mt-4">
              <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Autor</span>
              </div>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
            </div>
          </div>
        </article>
        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="w-full h-48 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div class="p-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
              <span>10 Enero, 2024</span>
              <span class="mx-2">•</span>
              <span>4 min lectura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Tercer Artículo de Ejemplo</h3>
            <p class="text-gray-600 mb-4">La funcionalidad de blog está completamente integrada con tu sistema.</p>
            <div class="flex items-center justify-between mt-4">
              <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Autor</span>
              </div>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>`
}

