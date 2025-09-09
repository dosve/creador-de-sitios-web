@extends('layouts.admin')

@section('title', 'Detalles de Página')
@section('page-title', 'Detalles de Página')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $page->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $website->name }} - /{{ $page->slug }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.pages.editor', [$website, $page]) }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Editor Visual
                    </a>
                    <a href="{{ route('admin.pages.edit', [$website, $page]) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('admin.websites.show', $website) }}" 
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
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Estado</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                    </span>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Slug</h4>
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $page->slug }}</code>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Sitio Web</h4>
                    <p class="text-sm text-gray-600">{{ $website->name }}</p>
                </div>
            </div>
            
            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Creada</h4>
                    <p class="text-sm text-gray-600">{{ $page->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Última actualización</h4>
                    <p class="text-sm text-gray-600">{{ $page->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <!-- Meta Descripción -->
            @if($page->meta_description)
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Descripción Meta (SEO)</h4>
                <p class="text-sm text-gray-600">{{ $page->meta_description }}</p>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Vista Previa del Contenido -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Vista Previa del Contenido</h3>
        </div>
        <div class="p-6">
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="prose max-w-none">
                    {!! $page->html_content !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Estilos CSS -->
    @if($page->css_content)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Estilos CSS</h3>
        </div>
        <div class="p-6">
            <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto text-sm"><code>{{ $page->css_content }}</code></pre>
        </div>
    </div>
    @endif
    
    <!-- Datos GrapesJS -->
    @if($page->grapesjs_data)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Datos del Editor Visual</h3>
        </div>
        <div class="p-6">
            <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto text-sm"><code>{{ json_encode($page->grapesjs_data, JSON_PRETTY_PRINT) }}</code></pre>
        </div>
    </div>
    @endif
</div>
@endsection
