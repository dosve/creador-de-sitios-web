{{-- Componente de navegación entre páginas en vista previa --}}
<div class="preview-navigation bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo/Nombre del sitio -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-bold text-gray-900">{{ $website->name }}</h1>
                </div>
            </div>

            <!-- Navegación de páginas -->
            <div class="flex items-center space-x-1">
                @if($pages && $pages->count() > 0)
                    <div class="hidden md:flex items-center space-x-1">
                        @foreach($pages as $navPage)
                            <a href="{{ route('creator.preview.page', $navPage->id) }}" 
                               class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ 
                                   $currentPage && $currentPage->id === $navPage->id 
                                       ? 'bg-blue-100 text-blue-700' 
                                       : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' 
                               }}">
                                {{ $navPage->title }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Menú móvil -->
                    <div class="md:hidden">
                        <div class="relative">
                            <button id="mobile-menu-button" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">
                                <span id="current-page-name">{{ $currentPage ? $currentPage->title : 'Páginas' }}</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Menú desplegable móvil -->
                            <div id="mobile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-50">
                                <div class="py-1">
                                    @foreach($pages as $navPage)
                                        <a href="{{ route('creator.preview.page', $navPage->id) }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ 
                                               $currentPage && $currentPage->id === $navPage->id 
                                                   ? 'bg-blue-50 text-blue-700' 
                                                   : '' 
                                           }}">
                                            {{ $navPage->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-sm text-gray-500">
                        No hay páginas disponibles
                    </div>
                @endif
            </div>

            <!-- Botón de regreso al editor -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('creator.pages.index') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Editor
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
});
</script>
