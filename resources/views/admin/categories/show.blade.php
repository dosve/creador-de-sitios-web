@extends('layouts.admin')

@section('title', 'Detalles de Categoría')
@section('page-title', 'Detalles de Categoría')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">Categoría del sitio web</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->slug }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Sitio Web</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->website->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Propietario</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->website->user->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Artículos</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->blog_posts_count }} artículos</dd>
                </div>
                
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->description ?: 'Sin descripción' }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Creada</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Artículos asociados -->
    @if($category->blogPosts->count() > 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Artículos Asociados</h3>
                <p class="text-sm text-gray-500">{{ $category->blogPosts->count() }} artículos en esta categoría</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category->blogPosts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
