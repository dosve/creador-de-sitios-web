{{-- Bloques Avanzados --}}
{
  id: 'timeline',
  label: 'Timeline',
  content: `
    <div class="timeline relative">
      <div class="flex items-start mb-6">
        <div class="flex-shrink-0 w-4 h-4 bg-blue-500 rounded-full mt-1"></div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Evento 1</h3>
          <p class="text-gray-600">Descripción del primer evento</p>
          <span class="text-sm text-gray-500">2024</span>
        </div>
      </div>
      <div class="flex items-start mb-6">
        <div class="flex-shrink-0 w-4 h-4 bg-green-500 rounded-full mt-1"></div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Evento 2</h3>
          <p class="text-gray-600">Descripción del segundo evento</p>
          <span class="text-sm text-gray-500">2023</span>
        </div>
      </div>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'progress-bars',
  label: 'Barras de Progreso',
  content: `
    <div class="space-y-4">
      <div>
        <div class="flex justify-between mb-2">
          <span class="text-sm font-medium">HTML</span>
          <span class="text-sm text-gray-600">90%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
        </div>
      </div>
      <div>
        <div class="flex justify-between mb-2">
          <span class="text-sm font-medium">CSS</span>
          <span class="text-sm text-gray-600">85%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
        </div>
      </div>
      <div>
        <div class="flex justify-between mb-2">
          <span class="text-sm font-medium">JavaScript</span>
          <span class="text-sm text-gray-600">70%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div class="bg-purple-600 h-2 rounded-full" style="width: 70%"></div>
        </div>
      </div>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'team-card',
  label: 'Tarjeta de Equipo',
  content: `
    <div class="team-card max-w-sm mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
      <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
        <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
        </svg>
      </div>
      <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900">Nombre del Miembro</h3>
        <p class="text-blue-600 font-medium">Cargo/Puesto</p>
        <p class="text-gray-600 mt-2">Descripción breve del miembro del equipo</p>
        <div class="flex space-x-3 mt-4">
          <a href="#" class="text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M20 4.477v.005c0 .264-.112.515-.31.707L17.65 7.05a.5.5 0 01-.707-.707l2.04-2.04a1 1 0 00-.707-1.707H4.477a1 1 0 00-.707 1.707l2.04 2.04a.5.5 0 01-.707.707L.31 5.182a1 1 0 00-.31.707v9.586c0 .264.112.515.31.707l2.04 2.04a.5.5 0 01.707-.707l-2.04-2.04a1 1 0 00.707-1.707h15.046a1 1 0 00.707 1.707l-2.04 2.04a.5.5 0 01.707.707l2.04-2.04c.198-.192.31-.443.31-.707V4.477z" clip-rule="evenodd"></path>
            </svg>
          </a>
          <a href="#" class="text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M20 4.477v.005c0 .264-.112.515-.31.707L17.65 7.05a.5.5 0 01-.707-.707l2.04-2.04a1 1 0 00-.707-1.707H4.477a1 1 0 00-.707 1.707l2.04 2.04a.5.5 0 01-.707.707L.31 5.182a1 1 0 00-.31.707v9.586c0 .264.112.515.31.707l2.04 2.04a.5.5 0 01.707-.707l-2.04-2.04a1 1 0 00.707-1.707h15.046a1 1 0 00.707 1.707l-2.04 2.04a.5.5 0 01.707.707l2.04-2.04c.198-.192.31-.443.31-.707V4.477z" clip-rule="evenodd"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'pricing-card',
  label: 'Tarjeta de Precios',
  content: `
    <div class="pricing-card bg-white rounded-lg shadow-lg border border-gray-200 p-6 max-w-sm mx-auto">
      <div class="text-center mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Plan Básico</h3>
        <div class="mt-4">
          <span class="text-4xl font-bold text-blue-600">$29</span>
          <span class="text-gray-600">/mes</span>
        </div>
      </div>
      <ul class="space-y-3 mb-6">
        <li class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-700">Característica 1</span>
        </li>
        <li class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-700">Característica 2</span>
        </li>
        <li class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-700">Característica 3</span>
        </li>
      </ul>
      <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
        Seleccionar Plan
      </button>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'faq-accordion',
  label: 'FAQ Acordeón',
  content: `
    <div class="faq-accordion space-y-4">
      <div class="border border-gray-200 rounded-lg">
        <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
          <span class="font-medium">¿Pregunta frecuente 1?</span>
          <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div class="px-6 pb-4 text-gray-600">
          Respuesta detallada a la primera pregunta frecuente...
        </div>
      </div>
      <div class="border border-gray-200 rounded-lg">
        <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
          <span class="font-medium">¿Pregunta frecuente 2?</span>
          <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div class="px-6 pb-4 text-gray-600">
          Respuesta detallada a la segunda pregunta frecuente...
        </div>
      </div>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'blog-card',
  label: 'Tarjeta de Blog',
  content: `
    <article class="blog-card bg-white rounded-lg shadow-lg overflow-hidden max-w-sm mx-auto">
      <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
      <div class="p-6">
        <div class="flex items-center text-sm text-gray-500 mb-2">
          <span>15 Enero, 2024</span>
          <span class="mx-2">•</span>
          <span>5 min lectura</span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Título del Artículo</h3>
        <p class="text-gray-600 mb-4">Descripción breve del artículo de blog que explica de qué trata...</p>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-gray-300 rounded-full mr-3"></div>
            <span class="text-sm text-gray-700">Autor</span>
          </div>
          <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
        </div>
      </div>
    </article>
  `,
  category: 'Avanzados'
},
{
  id: 'countdown-timer',
  label: 'Contador Regresivo',
  content: `
    <div class="countdown-timer text-center p-8 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg">
      <h2 class="text-2xl font-bold mb-4">¡Oferta Especial!</h2>
      <div class="grid grid-cols-4 gap-4 max-w-md mx-auto">
        <div class="bg-white bg-opacity-20 rounded-lg p-4">
          <div class="text-3xl font-bold" id="days">00</div>
          <div class="text-sm opacity-80">Días</div>
        </div>
        <div class="bg-white bg-opacity-20 rounded-lg p-4">
          <div class="text-3xl font-bold" id="hours">00</div>
          <div class="text-sm opacity-80">Horas</div>
        </div>
        <div class="bg-white bg-opacity-20 rounded-lg p-4">
          <div class="text-3xl font-bold" id="minutes">00</div>
          <div class="text-sm opacity-80">Min</div>
        </div>
        <div class="bg-white bg-opacity-20 rounded-lg p-4">
          <div class="text-3xl font-bold" id="seconds">00</div>
          <div class="text-sm opacity-80">Seg</div>
        </div>
      </div>
      <button class="mt-6 bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
        ¡Aprovechar Ahora!
      </button>
    </div>
  `,
  category: 'Avanzados'
},
{
  id: 'flip-card',
  label: 'Tarjeta Volteable',
  content: `
    <div class="flip-card w-64 h-48 mx-auto perspective-1000">
      <div class="flip-card-inner relative w-full h-full text-center transition-transform duration-700 transform-style-preserve-3d hover:rotate-y-180">
        <div class="flip-card-front absolute w-full h-full backface-hidden bg-blue-600 text-white rounded-lg flex items-center justify-center">
          <div>
            <h3 class="text-xl font-bold mb-2">Frente</h3>
            <p>Contenido del frente</p>
          </div>
        </div>
        <div class="flip-card-back absolute w-full h-full backface-hidden bg-green-600 text-white rounded-lg flex items-center justify-center rotate-y-180">
          <div>
            <h3 class="text-xl font-bold mb-2">Reverso</h3>
            <p>Contenido del reverso</p>
          </div>
        </div>
      </div>
    </div>
  `,
  category: 'Avanzados'
}
