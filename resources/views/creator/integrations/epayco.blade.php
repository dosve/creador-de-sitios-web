@extends('layouts.creator')

@section('title', 'Integración Epayco')
@section('page-title', 'Integración Epayco')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Configuración de Epayco</h2>
                <p class="mt-1 text-sm text-gray-600">Configura la integración con la pasarela de pagos Epayco para procesar pagos en tu sitio web.</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                <span class="text-sm text-gray-600">Conectado</span>
            </div>
        </div>
    </div>

    <!-- Formulario de configuración -->
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('creator.integrations.epayco.store', $website) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Clave Pública -->
                <div>
                    <label for="epayco_public_key" class="block text-sm font-medium text-gray-700 mb-2">
                        Clave Pública (P_CUST_ID_CLIENTE)
                    </label>
                    <input type="text" 
                           id="epayco_public_key" 
                           name="epayco_public_key" 
                           value="{{ old('epayco_public_key') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu clave pública de Epayco"
                           required>
                    @error('epayco_public_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Clave Privada -->
                <div>
                    <label for="epayco_private_key" class="block text-sm font-medium text-gray-700 mb-2">
                        Clave Privada (P_KEY)
                    </label>
                    <input type="password" 
                           id="epayco_private_key" 
                           name="epayco_private_key" 
                           value="{{ old('epayco_private_key') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu clave privada de Epayco"
                           required>
                    @error('epayco_private_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer ID -->
                <div>
                    <label for="epayco_customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer ID
                    </label>
                    <input type="text" 
                           id="epayco_customer_id" 
                           name="epayco_customer_id" 
                           value="{{ old('epayco_customer_id') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu Customer ID"
                           required>
                    @error('epayco_customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- P Key -->
                <div>
                    <label for="epayco_p_key" class="block text-sm font-medium text-gray-700 mb-2">
                        P Key
                    </label>
                    <input type="text" 
                           id="epayco_p_key" 
                           name="epayco_p_key" 
                           value="{{ old('epayco_p_key') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu P Key"
                           required>
                    @error('epayco_p_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modo de prueba -->
            <div class="mt-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="epayco_test_mode" 
                           name="epayco_test_mode" 
                           value="1"
                           {{ old('epayco_test_mode') ? 'checked' : '' }}
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="epayco_test_mode" class="ml-2 block text-sm text-gray-900">
                        Activar modo de prueba
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">Habilita el modo de prueba para realizar transacciones sin procesar pagos reales.</p>
            </div>

            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('creator.dashboard') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Guardar Configuración
                </button>
            </div>
        </form>
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
                        <li>Las credenciales se almacenan de forma segura y encriptada.</li>
                        <li>En modo de prueba, no se procesarán pagos reales.</li>
                        <li>Una vez configurado, podrás procesar pagos desde tu tienda en línea.</li>
                        <li>Para obtener tus credenciales, visita el panel de Epayco.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
