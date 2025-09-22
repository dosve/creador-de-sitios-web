@extends('layouts.creator')

@section('title', 'Gestión de Menús')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestión de Menús</h1>
            <p class="text-gray-600 mt-2">Administra los menús de navegación de tu sitio web</p>
        </div>
        <a href="{{ route('creator.websites.menus.create', $website) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            ➕ Crear Menú
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($menus->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($menus as $menu)
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $menu->name }}</h3>
                            <p class="text-sm text-gray-600">{{ ucfirst($menu->location) }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($menu->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($menu->description)
                        <p class="text-gray-600 text-sm mb-4">{{ $menu->description }}</p>
                    @endif

                    <div class="mb-4">
                        <p class="text-sm text-gray-500">
                            {{ $menu->items->count() }} items
                        </p>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('creator.websites.menus.show', [$website, $menu]) }}" 
                           class="flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded-md text-sm text-center hover:bg-blue-100 transition-colors">
                            👁️ Ver
                        </a>
                        <a href="{{ route('creator.websites.menus.edit', [$website, $menu]) }}" 
                           class="flex-1 bg-gray-50 text-gray-600 px-3 py-2 rounded-md text-sm text-center hover:bg-gray-100 transition-colors">
                            ✏️ Editar
                        </a>
                        <form method="POST" action="{{ route('creator.websites.menus.destroy', [$website, $menu]) }}" 
                              class="flex-1" 
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este menú?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-50 text-red-600 px-3 py-2 rounded-md text-sm hover:bg-red-100 transition-colors">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">🧭</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay menús creados</h3>
            <p class="text-gray-600 mb-6">Crea tu primer menú para comenzar a organizar la navegación de tu sitio web.</p>
            <a href="{{ route('creator.websites.menus.create', $website) }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                ➕ Crear Primer Menú
            </a>
        </div>
    @endif

    <!-- Información sobre ubicaciones de menús -->
    <div class="mt-12 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">📍 Ubicaciones de Menús</h3>
        <div class="grid gap-4 md:grid-cols-3">
            <div class="flex items-start space-x-3">
                <div class="text-blue-600 text-xl">🔝</div>
                <div>
                    <h4 class="font-medium text-blue-900">Header</h4>
                    <p class="text-sm text-blue-700">Menú principal en la parte superior del sitio</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="text-blue-600 text-xl">🔽</div>
                <div>
                    <h4 class="font-medium text-blue-900">Footer</h4>
                    <p class="text-sm text-blue-700">Menú en la parte inferior del sitio</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="text-blue-600 text-xl">📱</div>
                <div>
                    <h4 class="font-medium text-blue-900">Sidebar</h4>
                    <p class="text-sm text-blue-700">Menú lateral para navegación secundaria</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
