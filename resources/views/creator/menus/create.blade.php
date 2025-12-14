@extends('layouts.creator')

@section('title', 'Crear Menú')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Crear Nuevo Menú</h1>
            <p class="text-gray-600 mt-2">Configura un nuevo menú de navegación para tu sitio web</p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <form method="POST" action="{{ route('creator.menus.store') }}">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Menú *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
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
                        <option value="header" {{ old('location') === 'header' ? 'selected' : '' }}>
                            Header (Parte superior)
                        </option>
                        <option value="footer" {{ old('location') === 'footer' ? 'selected' : '' }}>
                            Footer (Parte inferior)
                        </option>
                        <option value="sidebar" {{ old('location') === 'sidebar' ? 'selected' : '' }}>
                            Sidebar (Lateral)
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
                              placeholder="Describe el propósito de este menú...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('creator.menus.index') }}" 
                       class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Crear Menú
                    </button>
                </div>
            </form>
        </div>

        <!-- Información sobre tipos de menús -->
        <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Tipos de Menús Recomendados</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="text-blue-600 text-xl">🔝</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Menú Principal (Header)</h4>
                        <p class="text-sm text-gray-600">Incluye enlaces principales como Inicio, Productos, Servicios, Contacto</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="text-blue-600 text-xl">🔽</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Menú Footer</h4>
                        <p class="text-sm text-gray-600">Enlaces secundarios como Política de Privacidad, Términos, Redes Sociales</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="text-blue-600 text-xl">📱</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Menú Sidebar</h4>
                        <p class="text-sm text-gray-600">Navegación secundaria o categorías de productos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
