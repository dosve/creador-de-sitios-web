{{-- Bloques de Widgets de WordPress --}}
{
  id: 'shortcode',
  label: 'HTML Corto',
  category: 'WordPress Widgets',
  content: `
    <div class="shortcode-container bg-gray-100 border border-gray-300 rounded-lg p-4">
      <div class="flex items-center space-x-2 mb-2">
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m-4 16l-4-16m4 16l-4-4m4 4l4-4"></path>
        </svg>
        <span class="text-sm font-medium text-gray-700">Shortcode</span>
      </div>
      <div class="bg-white border border-gray-200 rounded p-3 font-mono text-sm text-gray-600">
        [mi_shortcode parametro="valor"]
      </div>
    </div>
  `
},
{
  id: 'archives',
  label: 'Archivos',
  category: 'WordPress Widgets',
  content: `
    <div class="archives-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Archivos</h3>
      <ul class="space-y-2">
        <li><a href="#" class="text-blue-600 hover:text-blue-800">Enero 2024 (5)</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800">Diciembre 2023 (8)</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800">Noviembre 2023 (12)</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800">Octubre 2023 (6)</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800">Septiembre 2023 (9)</a></li>
      </ul>
    </div>
  `
},
{
  id: 'calendar',
  label: 'Calendario',
  category: 'WordPress Widgets',
  content: `
    <div class="calendar-widget bg-white border border-gray-200 rounded-lg p-4">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Calendario</h3>
      <div class="calendar-grid">
        <div class="grid grid-cols-7 gap-1 text-center text-sm">
          <div class="p-2 font-medium text-gray-500">L</div>
          <div class="p-2 font-medium text-gray-500">M</div>
          <div class="p-2 font-medium text-gray-500">X</div>
          <div class="p-2 font-medium text-gray-500">J</div>
          <div class="p-2 font-medium text-gray-500">V</div>
          <div class="p-2 font-medium text-gray-500">S</div>
          <div class="p-2 font-medium text-gray-500">D</div>
          <div class="p-2 text-gray-400">29</div>
          <div class="p-2 text-gray-400">30</div>
          <div class="p-2 text-gray-400">31</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">1</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">2</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">3</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">4</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">5</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">6</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">7</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">8</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">9</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">10</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">11</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">12</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">13</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">14</div>
          <div class="p-2 bg-blue-600 text-white rounded">15</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">16</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">17</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">18</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">19</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">20</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">21</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">22</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">23</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">24</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">25</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">26</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">27</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">28</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">29</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">30</div>
          <div class="p-2 hover:bg-blue-100 cursor-pointer">31</div>
        </div>
      </div>
    </div>
  `
},
{
  id: 'categories',
  label: 'Categorías',
  category: 'WordPress Widgets',
  content: `
    <div class="categories-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Categorías</h3>
      <ul class="space-y-2">
        <li class="flex justify-between items-center">
          <a href="#" class="text-blue-600 hover:text-blue-800">Tecnología</a>
          <span class="text-sm text-gray-500">(12)</span>
        </li>
        <li class="flex justify-between items-center">
          <a href="#" class="text-blue-600 hover:text-blue-800">Diseño</a>
          <span class="text-sm text-gray-500">(8)</span>
        </li>
        <li class="flex justify-between items-center">
          <a href="#" class="text-blue-600 hover:text-blue-800">Negocios</a>
          <span class="text-sm text-gray-500">(15)</span>
        </li>
        <li class="flex justify-between items-center">
          <a href="#" class="text-blue-600 hover:text-blue-800">Marketing</a>
          <span class="text-sm text-gray-500">(6)</span>
        </li>
        <li class="flex justify-between items-center">
          <a href="#" class="text-blue-600 hover:text-blue-800">Sin categoría</a>
          <span class="text-sm text-gray-500">(3)</span>
        </li>
      </ul>
    </div>
  `
},
{
  id: 'recent-comments',
  label: 'Comentarios Recientes',
  category: 'WordPress Widgets',
  content: `
    <div class="recent-comments-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Comentarios Recientes</h3>
      <ul class="space-y-3">
        <li class="border-l-4 border-blue-500 pl-3">
          <div class="text-sm">
            <span class="font-medium text-gray-900">Juan Pérez</span> en
            <a href="#" class="text-blue-600 hover:text-blue-800">Cómo crear una página web</a>
          </div>
          <div class="text-xs text-gray-500 mt-1">Hace 2 horas</div>
        </li>
        <li class="border-l-4 border-green-500 pl-3">
          <div class="text-sm">
            <span class="font-medium text-gray-900">María García</span> en
            <a href="#" class="text-blue-600 hover:text-blue-800">Diseño responsive</a>
          </div>
          <div class="text-xs text-gray-500 mt-1">Hace 5 horas</div>
        </li>
        <li class="border-l-4 border-purple-500 pl-3">
          <div class="text-sm">
            <span class="font-medium text-gray-900">Carlos López</span> en
            <a href="#" class="text-blue-600 hover:text-blue-800">SEO para principiantes</a>
          </div>
          <div class="text-xs text-gray-500 mt-1">Hace 1 día</div>
        </li>
      </ul>
    </div>
  `
},
{
  id: 'recent-posts',
  label: 'Entradas Recientes',
  category: 'WordPress Widgets',
  content: `
    <div class="recent-posts-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Entradas Recientes</h3>
      <ul class="space-y-4">
        <li class="flex space-x-3">
          <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0"></div>
          <div class="flex-1">
            <h4 class="font-medium text-gray-900 mb-1">
              <a href="#" class="hover:text-blue-600">Título de la entrada reciente</a>
            </h4>
            <div class="text-sm text-gray-500">15 Enero, 2024</div>
          </div>
        </li>
        <li class="flex space-x-3">
          <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0"></div>
          <div class="flex-1">
            <h4 class="font-medium text-gray-900 mb-1">
              <a href="#" class="hover:text-blue-600">Otra entrada interesante</a>
            </h4>
            <div class="text-sm text-gray-500">12 Enero, 2024</div>
          </div>
        </li>
        <li class="flex space-x-3">
          <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0"></div>
          <div class="flex-1">
            <h4 class="font-medium text-gray-900 mb-1">
              <a href="#" class="hover:text-blue-600">Tercera entrada del blog</a>
            </h4>
            <div class="text-sm text-gray-500">10 Enero, 2024</div>
          </div>
        </li>
      </ul>
    </div>
  `
},
{
  id: 'rss',
  label: 'RSS',
  category: 'WordPress Widgets',
  content: `
    <div class="rss-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">RSS</h3>
      <div class="space-y-3">
        <div class="flex items-center space-x-2">
          <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3.429 2.571c0 1.5 1.179 2.679 2.679 2.679 1.5 0 2.679-1.179 2.679-2.679 0-1.5-1.179-2.679-2.679-2.679-1.5 0-2.679 1.179-2.679 2.679zm2.679 14.25c-7.5 0-13.607-6.107-13.607-13.607h3.429c0 5.625 4.554 10.179 10.179 10.179v3.428zm0-7.5c-3.393 0-6.107-2.714-6.107-6.107h3.429c0 1.5 1.179 2.679 2.679 2.679v3.428z"></path>
          </svg>
          <span class="text-sm text-gray-700">Feed RSS</span>
        </div>
        <div class="text-sm text-gray-600">
          <p>Última actualización: Hace 2 horas</p>
          <p>Elementos: 15</p>
        </div>
        <button class="bg-orange-600 text-white px-4 py-2 rounded text-sm hover:bg-orange-700">
          Ver Feed
        </button>
      </div>
    </div>
  `
},
{
  id: 'search',
  label: 'Búsqueda',
  category: 'WordPress Widgets',
  content: `
    <div class="search-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Búsqueda</h3>
      <form class="space-y-3">
        <div>
          <input type="text" placeholder="Buscar..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
          Buscar
        </button>
      </form>
    </div>
  `
},
{
  id: 'tags',
  label: 'Etiquetas',
  category: 'WordPress Widgets',
  content: `
    <div class="tags-widget bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Etiquetas</h3>
      <div class="flex flex-wrap gap-2">
        <a href="#" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">WordPress</a>
        <a href="#" class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm hover:bg-green-200">Diseño</a>
        <a href="#" class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm hover:bg-purple-200">Desarrollo</a>
        <a href="#" class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm hover:bg-red-200">SEO</a>
        <a href="#" class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm hover:bg-yellow-200">Marketing</a>
        <a href="#" class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm hover:bg-indigo-200">Tutorial</a>
        <a href="#" class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-sm hover:bg-pink-200">Blog</a>
        <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200">Web</a>
      </div>
    </div>
  `
}
