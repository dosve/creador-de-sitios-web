{{-- Bloques de Navegación y Utilidad --}}
{
  id: 'breadcrumbs'
  , label: 'Migas de pan'
  , content: `<nav class="py-4 text-sm breadcrumbs">
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
  id: 'tabs'
  , label: 'Pestañas'
  , content: `<div class="py-8 tabs-container">
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
  id: 'accordion'
  , label: 'Acordeón'
  , content: `<div class="py-8 accordion">
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
