@extends('layouts.admin')

@section('title', 'Detalles de Sitio Web')
@section('page-title', 'Detalles de Sitio Web')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $website->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $website->description }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.websites.edit', $website) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('admin.websites.index') }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Propietario</h4>
                    <p class="text-sm text-gray-600">{{ $website->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $website->user->email }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Dominio</h4>
                    @if($website->domain)
                        <p class="text-sm text-gray-600">{{ $website->domain }}</p>
                    @elseif($website->subdomain)
                        <p class="text-sm text-gray-600">{{ $website->subdomain }}.tudominio.com</p>
                    @else
                        <p class="text-sm text-gray-400">Sin dominio</p>
                    @endif
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Estado</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $website->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $website->is_published ? 'Publicado' : 'Borrador' }}
                    </span>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Páginas</h4>
                    <p class="text-2xl font-bold text-blue-600">{{ $website->pages->count() }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Artículos de Blog</h4>
                    <p class="text-2xl font-bold text-green-600">{{ $website->blogPosts->count() }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Categorías</h4>
                    <p class="text-2xl font-bold text-purple-600">{{ $website->categories->count() }}</p>
                </div>
            </div>
            
            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Creado</h4>
                    <p class="text-sm text-gray-600">{{ $website->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Última actualización</h4>
                    <p class="text-sm text-gray-600">{{ $website->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <!-- Información del Usuario -->
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Información del Propietario</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Nombre:</span> {{ $website->user->name }}
                    </div>
                    <div>
                        <span class="font-medium">Email:</span> {{ $website->user->email }}
                    </div>
                    <div>
                        <span class="font-medium">Rol:</span> {{ $website->user->role === 'admin' ? 'Administrador' : 'Creador' }}
                    </div>
                    <div>
                        <span class="font-medium">Plan:</span> {{ $website->user->plan ? $website->user->plan->name : 'Sin plan' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Páginas del Sitio -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Páginas del Sitio</h3>
            <div class="flex space-x-3">
                <a href="{{ route('admin.pages.index', $website) }}" 
                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    Ver todas las páginas
                </a>
                <a href="{{ route('admin.pages.create', $website) }}" 
                   class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 text-sm">
                    Nueva Página
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($website->pages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($website->pages as $page)
                        <div class="border rounded-md p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-medium text-gray-900">{{ $page->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $page->slug }}</p>
                            <p class="text-sm text-gray-500">{{ $page->created_at->format('d/m/Y') }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                                </span>
                                <a href="{{ route('admin.pages.editor', [$website, $page]) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Editar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay páginas</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando la primera página.</p>
                    <div class="mt-4">
                        <a href="{{ route('admin.pages.create', $website) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nueva Página
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Artículos de Blog -->
    @if($website->blogPosts->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Artículos de Blog</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($website->blogPosts as $post)
                    <div class="border rounded-md p-4">
                        <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $post->slug }}</p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->format('d/m/Y') }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    <!-- Categorías -->
    @if($website->categories->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Categorías</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                @foreach($website->categories as $category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
