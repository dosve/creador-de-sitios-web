@extends('layouts.admin')

@section('title', 'Gestión de Categorías')
@section('page-title', 'Categorías')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Gestión de Categorías</h2>
            <p class="text-gray-600">Administra todas las categorías de los sitios web</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            Nueva Categoría
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Categorías</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categories->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Activas</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categories->where('is_active', true)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Inactivas</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categories->where('is_active', false)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-purple-500 rounded-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Con Artículos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categories->where('blog_posts_count', '>', 0)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Lista de Categorías</h3>
        </div>

        @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Categoría</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Sitio Web</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Artículos</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Creada</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-4 h-4 mr-3 rounded-full" style="background-color: {{ $category->color ?: '#6B7280' }}"></div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                    @if($category->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $category->website->name }}</div>
                            <div class="text-sm text-gray-500">{{ $category->website->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $category->blog_posts_count }} artículos
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $category->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                        {{ $category->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay categorías</h3>
            <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva categoría.</p>
            <div class="mt-6">
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Categoría
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection