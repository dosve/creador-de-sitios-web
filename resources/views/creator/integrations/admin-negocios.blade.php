@extends('layouts.creator')

@section('title', 'Integración Admin Negocios')
@section('page-title', 'Integración Admin Negocios')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Configuración de Admin Negocios</h2>
                <p class="mt-1 text-sm text-gray-600">Conecta tu sistema de inventarios Admin Negocios para sincronizar productos y stock con tu tienda en línea.</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <span class="text-sm text-gray-600">Pendiente</span>
            </div>
        </div>
    </div>

    <!-- Formulario de configuración -->
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('creator.integrations.admin-negocios.store', $website) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- URL del sistema -->
                <div>
                    <label for="admin_negocios_url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL del Sistema Admin Negocios
                    </label>
                    <input type="url" 
                           id="admin_negocios_url" 
                           name="admin_negocios_url" 
                           value="{{ old('admin_negocios_url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="https://tu-admin-negocios.com"
                           required>
                    @error('admin_negocios_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- API Key -->
                    <div>
                        <label for="admin_negocios_api_key" class="block text-sm font-medium text-gray-700 mb-2">
                            API Key
                        </label>
                        <input type="text" 
                               id="admin_negocios_api_key" 
                               name="admin_negocios_api_key" 
                               value="{{ old('admin_negocios_api_key') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Tu API Key"
                               required>
                        @error('admin_negocios_api_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usuario -->
                    <div>
                        <label for="admin_negocios_username" class="block text-sm font-medium text-gray-700 mb-2">
                            Usuario
                        </label>
                        <input type="text" 
                               id="admin_negocios_username" 
                               name="admin_negocios_username" 
                               value="{{ old('admin_negocios_username') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Usuario de Admin Negocios"
                               required>
                        @error('admin_negocios_username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="admin_negocios_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <input type="password" 
                               id="admin_negocios_password" 
                               name="admin_negocios_password" 
                               value="{{ old('admin_negocios_password') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Contraseña de Admin Negocios"
                               required>
                        @error('admin_negocios_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('creator.dashboard') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Conectar Admin Negocios
                </button>
            </div>
        </form>
    </div>

    <!-- Funcionalidades disponibles -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Funcionalidades disponibles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Sincronización de Inventario</h4>
                    <p class="text-sm text-gray-600">Sincroniza automáticamente el stock de productos entre Admin Negocios y tu tienda en línea.</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Gestión de Productos</h4>
                    <p class="text-sm text-gray-600">Importa productos desde Admin Negocios y conviértelos en posts de tu tienda.</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Actualización de Precios</h4>
                    <p class="text-sm text-gray-600">Los precios se actualizan automáticamente desde Admin Negocios.</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Control de Stock</h4>
                    <p class="text-sm text-gray-600">Mantén el control del inventario en tiempo real.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Necesitas tener acceso de API en tu sistema Admin Negocios.</li>
                        <li>La sincronización se realiza automáticamente cada hora.</li>
                        <li>Los productos se importan como posts de blog con funcionalidad de tienda.</li>
                        <li>Puedes sincronizar manualmente desde el módulo de tienda en línea.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
