@extends('layouts.creator')

@section('title', 'Categorías - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Categorías</h1>
                    <p class="mt-2 text-gray-600">Organiza tus productos por categorías</p>
                </div>
                {{-- <button onclick="openCreateModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Nueva Categoría
                </button> --}}
            </div>
        </div>

        <!-- Controles de paginación -->
        @if($useExternalApi && $pagination)
            <div class="mb-6 flex justify-end">
                <x-per-page-selector label="Categorías por página:" />
            </div>
        @endif

        <!-- Categories Grid -->
        @if($useExternalApi && count($externalCategories) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($externalCategories as $category)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $category['categoria'] }}
                                </h3>
                                @if(isset($category['descripcion']) && $category['descripcion'])
                                    <p class="text-gray-600 text-sm">
                                        {{ Str::limit($category['descripcion'], 100) }}
                                    </p>
                                @else
                                    <p class="text-gray-500 text-sm italic">
                                        Sin descripción
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500">
                                    ID: {{ $category['id'] }}
                                </span>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">
                                    Externa
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!$useExternalApi && $categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $category->name }}
                                </h3>
                                @if($category->description)
                                    <p class="text-gray-600 text-sm">
                                        {{ Str::limit($category->description, 100) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500">
                                    {{ $category->blog_posts_count }} productos
                                </span>
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactiva
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button onclick="editCategory({{ $category->id }})" 
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Editar
                                </button>
                                <span class="text-gray-300">|</span>
                                <button onclick="deleteCategory({{ $category->id }})" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay categorías</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($useExternalApi)
                        No se encontraron categorías en la API externa.
                    @else
                        Comienza creando tu primera categoría.
                    @endif
                </p>
                {{-- @if(!$useExternalApi)
                    <div class="mt-6">
                        <button onclick="openCreateModal()" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Crear Categoría
                        </button>
                    </div>
                @endif --}}
            </div>
        @endif

        <!-- Paginación -->
        @if($useExternalApi && $pagination)
            <x-pagination :pagination="$pagination" :showPerPageSelector="false" />
        @endif
    </div>
</div>

<!-- Create/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Nueva Categoría</h3>
            <form id="categoryForm">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" checked
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Categoría activa</span>
                    </label>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nueva Categoría';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryModal').classList.remove('hidden');
}

function editCategory(id) {
    // Aquí implementarías la lógica para cargar los datos de la categoría
    document.getElementById('modalTitle').textContent = 'Editar Categoría';
    document.getElementById('categoryModal').classList.remove('hidden');
}

function deleteCategory(id) {
    if (confirm('¿Estás seguro de que quieres eliminar esta categoría?')) {
        // Aquí implementarías la lógica para eliminar la categoría
        console.log('Eliminar categoría:', id);
    }
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}
</script>
@endsection
