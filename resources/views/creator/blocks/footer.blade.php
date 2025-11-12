{{-- Bloques de Footer --}}
{
  id: 'navbar',
  label: 'Navegación',
  category: 'Footer', content: `<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="#" class="text-xl font-bold text-gray-900">Mi Sitio Web</a>
            </div>
            <!-- Menú de Navegación -->
            <div class="hidden md:block">
                <div class="flex items-baseline ml-10 space-x-4">
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
  id: 'footer',
  label: 'Footer',
  category: 'Footer', content: `<footer class="text-white bg-gray-800">
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div>
                <h3 class="mb-4 text-lg font-semibold">Mi Sitio Web</h3>
                <p class="text-sm text-gray-300">Descripción de tu sitio web o empresa.</p>
            </div>
            <div>
                <h4 class="mb-4 font-semibold text-md">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-300 hover:text-white">Inicio</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Acerca</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Servicios</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="mb-4 font-semibold text-md">Información</h4>
                <p class="text-sm text-gray-300">Información adicional sobre tu empresa o servicios.</p>
            </div>
        </div>
        <div class="pt-8 mt-8 text-center border-t border-gray-700">
            <p class="text-sm text-gray-400">&copy; 2025 Mi Sitio Web. Todos los derechos reservados.</p>
            <p class="mt-2 text-xs text-gray-500">
                Creado con <a href="https://eme10.com" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors">EME10</a> | 
                Gestión con <a href="https://adminnegocios.com" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors">Admin Negocios</a>
            </p>
        </div>
    </div>
  </footer>`
}
