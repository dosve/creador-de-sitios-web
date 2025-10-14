{{-- Bloques de Navegación y Utilidad --}}
{
  id: 'navbar',
  label: 'Navegación',
  category: 'Navegación', content: `<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="#" class="text-xl font-bold text-gray-900">Mi Sitio Web</a>
            </div>
            <!-- Menú de Navegación -->
            <div class="hidden md:block">
                <div class="flex items-center ml-10 space-x-4">
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:text-gray-700">Inicio</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Acerca</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Servicios</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">Contacto</a>
                </div>
            </div>
            <!-- Botón móvil -->
            <div class="md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md bg-gray-50 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>`
},
{
  id: 'breadcrumbs',
  label: 'Migas de pan',
  category: 'Navegación', content: `<nav class="py-4 text-sm breadcrumbs">
    <div class="container px-4 mx-auto">
        <a href="#" class="text-blue-600 hover:text-blue-800">Inicio</a>
        <span class="mx-2 text-gray-500">/</span>
        <a href="#" class="text-blue-600 hover:text-blue-800">Categoría</a>
        <span class="mx-2 text-gray-500">/</span>
        <span class="text-gray-700">Página actual</span>
    </div>
  </nav>`
},
{
  id: 'tabs',
  label: 'Pestañas',
  category: 'Navegación', content: `<div class="py-8 tabs-container">
    <div class="container px-4 mx-auto">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px space-x-8">
                <button class="px-1 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-500">Pestaña 1</button>
                <button class="px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700">Pestaña 2</button>
                <button class="px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700">Pestaña 3</button>
            </nav>
        </div>
        <div class="mt-6">
            <div class="tab-content">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Contenido de la Pestaña 1</h3>
                <p class="text-gray-600">Este es el contenido de la primera pestaña. Puedes agregar cualquier contenido aquí.</p>
            </div>
        </div>
    </div>
  </div>`
},
{
  id: 'accordion',
  label: 'Acordeón',
  category: 'Navegación', content: `<div class="py-8 accordion">
    <div class="container max-w-4xl px-4 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center">Preguntas Frecuentes</h2>
        <div class="space-y-4">
            <div class="border border-gray-200 rounded-lg">
                <button class="flex items-center justify-between w-full px-6 py-4 font-medium text-left">
                    <span>¿Cómo funciona el servicio?</span>
                    <span>+</span>
                </button>
                <div class="px-6 pb-4 text-gray-600">
                    Nuestro servicio es muy fácil de usar. Solo necesitas registrarte y seguir los pasos del tutorial.
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg">
                <button class="flex items-center justify-between w-full px-6 py-4 font-medium text-left">
                    <span>¿Qué métodos de pago aceptan?</span>
                    <span>+</span>
                </button>
                <div class="hidden px-6 pb-4 text-gray-600">
                    Aceptamos tarjetas de crédito, débito, PayPal y transferencias bancarias.
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg">
                <button class="flex items-center justify-between w-full px-6 py-4 font-medium text-left">
                    <span>¿Puedo cancelar mi suscripción?</span>
                    <span>+</span>
                </button>
                <div class="hidden px-6 pb-4 text-gray-600">
                    Sí, puedes cancelar tu suscripción en cualquier momento desde tu panel de control.
                </div>
            </div>
        </div>
    </div>
  </div>`
}
