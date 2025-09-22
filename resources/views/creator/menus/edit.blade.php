@extends('layouts.creator')

@section('title', 'Editar Menú')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Editar Menú</h1>
            <p class="text-gray-600 mt-2">Modifica la configuración del menú "{{ $menu->name }}"</p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <form method="POST" action="{{ route('creator.websites.menus.update', [$website, $menu]) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Menú *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $menu->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ej: Menú Principal, Menú Footer"
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Ubicación del Menú *
                    </label>
                    <select id="location" 
                            name="location" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">Selecciona una ubicación</option>
                        <option value="header" {{ old('location', $menu->location) === 'header' ? 'selected' : '' }}>
                            🔝 Header (Parte superior)
                        </option>
                        <option value="footer" {{ old('location', $menu->location) === 'footer' ? 'selected' : '' }}>
                            🔽 Footer (Parte inferior)
                        </option>
                        <option value="sidebar" {{ old('location', $menu->location) === 'sidebar' ? 'selected' : '' }}>
                            📱 Sidebar (Lateral)
                        </option>
                    </select>
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción (Opcional)
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Describe el propósito de este menú...">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Menú activo</span>
                    </label>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('creator.websites.menus.show', [$website, $menu]) }}" 
                       class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Actualizar Menú
                    </button>
                </div>
            </form>
        </div>

        <!-- Información del menú -->
        <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Información del Menú</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <h4 class="font-medium text-gray-900">Items del Menú</h4>
                    <p class="text-sm text-gray-600">{{ $menu->items->count() }} items configurados</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Estado</h4>
                    <p class="text-sm text-gray-600">
                        @if($menu->is_active)
                            <span class="text-green-600">✅ Activo</span>
                        @else
                            <span class="text-red-600">❌ Inactivo</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
