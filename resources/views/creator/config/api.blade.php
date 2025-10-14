@extends('layouts.creator')

@section('title', 'Configuración API - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Configuración API</h1>
            <p class="mt-2 text-gray-600">Configura la integración con tu sistema de inventario externo</p>
        </div>

        <!-- API Configuration Form -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Configuración de API Externa</h2>
                <p class="mt-1 text-sm text-gray-500">Ingresa los datos de tu API para sincronizar productos, categorías y pedidos</p>
            </div>

            <form method="POST" action="{{ route('creator.config.api.update') }}" class="p-6">
                @csrf
                @method('PUT')

                <!-- API Base URL -->
                <div class="mb-6">
                    <label for="api_base_url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Base de la API
                    </label>
                    <input type="url" 
                           id="api_base_url" 
                           name="api_base_url" 
                           value="{{ old('api_base_url', $website->api_base_url) }}"
                           placeholder="https://tu-servidor.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('api_base_url') border-red-500 @enderror">
                    @error('api_base_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">URL base de tu servidor de API (ej: https://tu-servidor.com)</p>
                </div>

                <!-- API Key -->
                <div class="mb-6">
                    <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
                        API Key
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="api_key" 
                               name="api_key" 
                               value="{{ old('api_key', $website->api_key) }}"
                               placeholder="sk_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('api_key') border-red-500 @enderror">
                        <button type="button" 
                                onclick="toggleApiKeyVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eye-icon" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('api_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Tu clave API para acceder a los endpoints externos</p>
                </div>

                <!-- Test Connection Button -->
                @if($website->api_key && $website->api_base_url)
                    <div class="mb-6">
                        <button type="button" 
                                onclick="testApiConnection()" 
                                id="test-button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Probar Conexión
                        </button>
                        <div id="test-result" class="mt-2 hidden"></div>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('creator.config.general') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>

        <!-- API Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Información sobre la API</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Una vez configurada la API, podrás:</p>
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            <li>Sincronizar productos desde tu sistema de inventario</li>
                            <li>Ver categorías de productos actualizadas</li>
                            <li>Gestionar pedidos en tiempo real</li>
                            <li>Mantener información actualizada automáticamente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Endpoints Info -->
        @if($website->api_key && $website->api_base_url)
            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Endpoints Disponibles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <h4 class="font-medium text-gray-700">Productos</h4>
                        <p class="text-gray-600">GET {{ $website->api_base_url }}/api/api-key/products</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">Categorías</h4>
                        <p class="text-gray-600">GET {{ $website->api_base_url }}/api/api-key/categories</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">Pedidos</h4>
                        <p class="text-gray-600">GET {{ $website->api_base_url }}/api/api-key/orders</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">Información del Negocio</h4>
                        <p class="text-gray-600">GET {{ $website->api_base_url }}/api/api-key/business</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleApiKeyVisibility() {
    const apiKeyInput = document.getElementById('api_key');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        apiKeyInput.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

function testApiConnection() {
    const button = document.getElementById('test-button');
    const result = document.getElementById('test-result');
    
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Probando...
    `;
    
    fetch('{{ route("creator.config.api.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        result.classList.remove('hidden');
        if (data.success) {
            result.className = 'mt-2 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md';
            result.innerHTML = `
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Conexión exitosa</p>
                        <p class="text-sm">${data.message}</p>
                    </div>
                </div>
            `;
        } else {
            result.className = 'mt-2 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md';
            result.innerHTML = `
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Error de conexión</p>
                        <p class="text-sm">${data.message}</p>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        result.classList.remove('hidden');
        result.className = 'mt-2 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md';
        result.innerHTML = `
            <div class="flex">
                <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-medium">Error de conexión</p>
                    <p class="text-sm">No se pudo conectar con el servidor</p>
                </div>
            </div>
        `;
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Probar Conexión
        `;
    });
}
</script>
@endsection
