@extends('layouts.creator')

@section('title', 'Gestión de Menús')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestión de Menús</h1>
            <p class="text-gray-600 mt-2">Administra los menús de navegación de tu sitio web</p>
        </div>
        <a href="{{ route('creator.menus.create') }}" 
           class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Crear Menú
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
                        <a href="{{ route('creator.menus.show', $menu) }}" 
                           class="flex items-center justify-center flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded-md text-sm hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver
                        </a>
                        <a href="{{ route('creator.menus.edit', $menu) }}" 
                           class="flex items-center justify-center flex-1 bg-gray-50 text-gray-600 px-3 py-2 rounded-md text-sm hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </a>
                        <form method="POST" action="{{ route('creator.menus.destroy', $menu) }}" 
                              class="flex-1" 
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este menú?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center justify-center w-full bg-red-50 text-red-600 px-3 py-2 rounded-md text-sm hover:bg-red-100 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay menús creados</h3>
            <p class="text-gray-600 mb-6">Crea tu primer menú para comenzar a organizar la navegación de tu sitio web.</p>
            <a href="{{ route('creator.menus.create') }}" 
               class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear Primer Menú
            </a>
        </div>
    @endif
</div>
@endsection
