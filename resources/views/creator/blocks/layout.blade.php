{{-- Bloques de Layout --}}
{
  id: 'hero'
  , label: 'Hero'
  , category: 'Layout'
  , content: `<section class="relative py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="container px-4 mx-auto text-center">
      <h1 class="mb-6 text-4xl font-bold md:text-6xl">Título Principal</h1>
      <p class="mb-8 text-xl text-blue-100">Subtítulo descriptivo que explica tu propuesta de valor</p>
      <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
        <button class="px-8 py-3 text-lg font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">
          Llamada a la Acción
        </button>
        <button class="px-8 py-3 text-lg font-semibold text-white transition-colors border-2 border-white rounded-lg hover:bg-white hover:text-blue-600">
          Acción Secundaria
        </button>
      </div>
    </div>
  </section>`
},
{
  id: 'features'
  , label: 'Características'
  , category: 'Layout'
  , content: `<section class="py-16 bg-white">
    <div class="container px-4 mx-auto">
      <div class="mb-12 text-center">
        <h2 class="mb-4 text-3xl font-bold text-gray-900">Nuestras Características</h2>
        <p class="text-lg text-gray-600">Descubre lo que nos hace únicos</p>
      </div>
      <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="p-6 text-center">
          <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 text-blue-600 bg-blue-100 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-xl font-semibold text-gray-900">Rápido</h3>
          <p class="text-gray-600">Descripción de la característica</p>
        </div>
        <div class="p-6 text-center">
          <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 text-green-600 bg-green-100 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-xl font-semibold text-gray-900">Confiable</h3>
          <p class="text-gray-600">Descripción de la característica</p>
        </div>
        <div class="p-6 text-center">
          <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 text-purple-600 bg-purple-100 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-xl font-semibold text-gray-900">Fácil de usar</h3>
          <p class="text-gray-600">Descripción de la característica</p>
        </div>
      </div>
    </div>
  </section>`
},
{
  id: 'testimonials'
  , label: 'Testimonios'
  , category: 'Layout'
  , attributes: {
    class: 'gjs-block-testimonial'
  }
  , content: `<section class="py-16 testimonials bg-gray-50">
    <div class="container px-4 mx-auto">
        <h2 class="mb-12 text-3xl font-bold text-center">Lo que dicen nuestros clientes</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 mr-4 rounded-full">
                    <div>
                        <h4 class="font-semibold">María García</h4>
                        <p class="text-sm text-gray-600">CEO, Empresa XYZ</p>
                    </div>
                </div>
                <p class="text-gray-700">"Excelente servicio, muy recomendable. La atención al cliente es excepcional."</p>
                <div class="flex mt-4 text-yellow-400">
                    ★★★★★
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 mr-4 rounded-full">
                    <div>
                        <h4 class="font-semibold">Juan Pérez</h4>
                        <p class="text-sm text-gray-600">Director, ABC Corp</p>
                    </div>
                </div>
                <p class="text-gray-700">"Los resultados superaron nuestras expectativas. Muy profesionales."</p>
                <div class="flex mt-4 text-yellow-400">
                    ★★★★★
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 mr-4 rounded-full">
                    <div>
                        <h4 class="font-semibold">Ana López</h4>
                        <p class="text-sm text-gray-600">Fundadora, StartupABC</p>
                    </div>
                </div>
                <p class="text-gray-700">"Una experiencia increíble. Sin duda volveríamos a trabajar con ellos."</p>
                <div class="flex mt-4 text-yellow-400">
                    ★★★★★
                </div>
            </div>
        </div>
    </div>
  </section>`
},
{
  id: 'cta'
  , label: 'Llamada a la Acción'
  , category: 'Layout'
  , content: `<section class="py-16 bg-blue-600">
    <div class="container px-4 mx-auto text-center">
      <h2 class="mb-4 text-3xl font-bold text-white">¿Listo para comenzar?</h2>
      <p class="mb-8 text-xl text-blue-100">Únete a miles de usuarios que ya confían en nosotros</p>
      <button class="px-8 py-3 text-lg font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">
        Comenzar Ahora
      </button>
    </div>
  </section>`
}
