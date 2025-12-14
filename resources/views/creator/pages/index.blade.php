@extends('layouts.creator')

@section('title', 'Páginas - ' . $website->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con botones -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Páginas</h2>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('creator.pages.create') }}" 
                       class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                    Nueva Página
                </a>
        @if($website && $website->template_id)
                    <a href="{{ route('creator.pages.import', ['website' => $website->id]) }}" 
                       class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                        <i class="fas fa-download mr-2"></i>
                        Importar desde Plantilla
                    </a>
                    <button type="button" 
                            class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition-colors"
                            onclick="openModal()">
                        <i class="fas fa-compass mr-2"></i>
                        Navegador de Páginas
            </button>
        @endif
    </div>
</div>

            <!-- Lista de páginas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pages as $page)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 group">
                    <div class="p-6">
                        <!-- Header con título -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors mb-2">
                                {{ $page->title }}
                            </h3>
                            @if($page->is_home)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                    <i class="fas fa-home mr-1"></i>
                                    Página de Inicio
                </span>
                            @endif
        </div>

                        <!-- Descripción -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($page->meta_description, 120) }}
                        </p>
                        
                        <!-- Botones de acción -->
                        <div class="flex gap-2 mb-4">
                            <a href="{{ route('creator.pages.edit', ['website' => $website->id, 'page' => $page->id]) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
                            </a>
                            <a href="{{ route('creator.pages.editor', ['page' => $page->id]) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <i class="fas fa-paint-brush mr-2"></i>
                                Constructor
                            </a>
                            <form method="POST" action="{{ route('creator.pages.destroy', ['page' => $page->id]) }}" class="flex-1" onsubmit="return confirm('¿Seguro que deseas eliminar esta página? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                    <i class="fas fa-trash mr-2"></i>
                                    Eliminar
                                </button>
                            </form>
                        </div>

                        <!-- Footer con slug y fecha -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-md">
                                    <i class="fas fa-link mr-1"></i>
                                    /{{ $page->slug }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $page->updated_at->diffForHumans() }}
                            </div>
                        </div>
    </div>
</div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-file-alt text-3xl text-gray-400"></i>
    </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">No hay páginas creadas</h3>
                            <p class="text-gray-600 mb-8">Comienza creando tu primera página o importa páginas desde una plantilla.</p>
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="{{ route('creator.pages.create') }}" 
                                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
        Crear Primera Página
    </a>
                                @if($website && $website->template_id)
                                <button onclick="openModal()" 
                                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    <i class="fas fa-compass mr-2"></i>
                                    Navegador de Páginas
                                </button>
@endif
                    </div>
                        </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@include('creator.pages.modal-pages-clean')

@push('scripts')
<script>
// Pasar el ID del website al JavaScript
window.websiteId = {{ $website->id }};
// Slugs ya existentes en el sitio para evitar importarlos de nuevo
window.existingPageSlugs = @json($pages->pluck('slug')->values());
</script>
<script src="{{ asset('js/pages-navigator.js') }}"></script>
@endpush
@endsection