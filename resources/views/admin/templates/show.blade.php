@extends('layouts.admin')

@section('title', 'Detalles de Plantilla')
@section('page-title', 'Detalles de Plantilla')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $template->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $template->description }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.templates.edit', $template) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('admin.templates.index') }}" 
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
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Categoría</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($template->category) }}
                    </span>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Tipo</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $template->is_premium ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ $template->is_premium ? 'Premium' : 'Gratuita' }}
                    </span>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Estado</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $template->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Sitios Web que usan esta plantilla</h4>
                    <p class="text-2xl font-bold text-blue-600">{{ $template->websites->count() }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Bloques disponibles</h4>
                    <p class="text-2xl font-bold text-green-600">{{ is_array($template->blocks) ? count($template->blocks) : 0 }}</p>
                </div>
            </div>
            
            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Creada</h4>
                    <p class="text-sm text-gray-600">{{ $template->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Última actualización</h4>
                    <p class="text-sm text-gray-600">{{ $template->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenido HTML -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Contenido HTML</h3>
        </div>
        <div class="p-6">
            <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto text-sm"><code>{{ $template->html_content }}</code></pre>
        </div>
    </div>
    
    <!-- Contenido CSS -->
    @if($template->css_content)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Contenido CSS</h3>
        </div>
        <div class="p-6">
            <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto text-sm"><code>{{ $template->css_content }}</code></pre>
        </div>
    </div>
    @endif
    
    <!-- Bloques -->
    @if($template->blocks && is_array($template->blocks) && count($template->blocks) > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Bloques Disponibles</h3>
        </div>
        <div class="p-6">
            <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto text-sm"><code>{{ json_encode($template->blocks, JSON_PRETTY_PRINT) }}</code></pre>
        </div>
    </div>
    @endif
    
    <!-- Sitios Web que usan esta plantilla -->
    @if($template->websites->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Sitios Web que usan esta plantilla</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($template->websites as $website)
                    <div class="border rounded-md p-4">
                        <h4 class="font-medium text-gray-900">{{ $website->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $website->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $website->created_at->format('d/m/Y') }}</p>
                        <a href="{{ route('admin.websites.show', $website) }}" 
                           class="text-blue-600 hover:text-blue-900 text-sm">Ver sitio</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
