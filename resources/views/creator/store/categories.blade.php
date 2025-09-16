@extends('layouts.creator')

@section('title', 'Categorías - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Categorías</h1>
                    <p class="mt-2 text-gray-600">Organiza tus productos por categorías</p>
                </div>
                {{-- <button onclick="openCreateModal()" 
                        class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    Nueva Categoría
                </button> --}}
            </div>
        </div>

        <!-- Paginación superior -->
        @if($useExternalApi && $pagination)
            <div class="mb-4">
                <x-pagination :pagination="$pagination" :showPerPageSelector="true" label="categorías" />
            </div>
        @endif

        <!-- Categories Grid -->
        @if($useExternalApi && count($externalCategories) > 0)
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($externalCategories as $category)
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                    {{ $category['categoria'] }}
                                </h3>
                                @if(isset($category['descripcion']) && $category['descripcion'])
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($category['descripcion'], 100) }}
                                    </p>
                                @else
                                    <p class="text-sm italic text-gray-500">
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
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($categories as $category)
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                    {{ $category->name }}
                                </h3>
                                @if($category->description)
                                    <p class="text-sm text-gray-600">
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
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Editar
                                </button>
                                <span class="text-gray-300">|</span>
                                <button onclick="deleteCategory({{ $category->id }})" 
                                        class="text-sm font-medium text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                            Crear Categoría
                        </button>
                    </div>
                @endif --}}
            </div>
        @endif

        <!-- Paginación -->
        @if($useExternalApi && $pagination)
            <x-pagination :pagination="$pagination" :showPerPageSelector="true" label="categorías" />
        @endif
    </div>
</div>

<!-- Create/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
        <div class="mt-3">
            <h3 class="mb-4 text-lg font-medium text-gray-900" id="modalTitle">Nueva Categoría</h3>
            <form id="categoryForm">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Descripción</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" checked
                               class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Categoría activa</span>
                    </label>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
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
