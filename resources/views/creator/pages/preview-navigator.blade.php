@extends('layouts.creator')

@section('title', 'Vista Previa - ' . $pageTitle)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header de la vista previa -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <button onclick="window.close()" 
                            class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle }}</h1>
                        <p class="text-sm text-gray-600">{{ $pageDescription }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pageType === 'common' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        <i class="fas fa-{{ $pageType === 'common' ? 'star' : 'puzzle-piece' }} mr-2"></i>
                        {{ $pageType === 'common' ? 'Página Esencial' : 'Página Especializada' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        <i class="fas fa-{{ $categoryIcon }} mr-2"></i>
                        {{ $categoryName }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de la vista previa -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Información de la página -->
        <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Descripción de la Página</h3>
                    <p class="text-gray-600 mb-4">{{ $pageDescription }}</p>
                    
                    <h4 class="text-md font-medium text-gray-900 mb-2">Ejemplo de Uso:</h4>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-0.5"></i>
                            <p class="text-sm text-yellow-800">{{ $pageExample }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Características</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Diseño responsive y moderno</span>
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Optimizado para SEO</span>
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Fácil de personalizar</span>
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Compatible con todos los dispositivos</span>
                        </li>
                    </ul>
                    
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Bloques Incluidos:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($pageBlocks as $block)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-{{ $block['icon'] }} mr-1"></i>
                                {{ $block['name'] }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista previa del contenido -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="bg-gray-50 px-6 py-3 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Vista Previa del Contenido</h3>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <span class="text-sm text-gray-500">Vista previa</span>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <!-- Aquí se renderizará el contenido de la página -->
                <div class="max-w-4xl mx-auto">
                    @foreach($pageBlocks as $block)
                        @include('creator.pages.preview-blocks.' . $block['type'], ['block' => $block])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="mt-8 flex justify-center">
            <div class="flex space-x-4">
                <button onclick="window.close()" 
                        class="px-6 py-3 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cerrar Vista Previa
                </button>
                <button onclick="importThisPage()" 
                        class="px-6 py-3 text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:ring-2 focus:ring-indigo-500 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Importar Esta Página
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function importThisPage() {
    // Aquí se implementaría la lógica para importar la página
    alert('Función de importación en desarrollo');
}

// Cerrar ventana con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.close();
    }
});
</script>
@endpush
@endsection
