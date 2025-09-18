@extends('layouts.creator')

@section('title', 'Integración Epayco')
@section('page-title', 'Integración Epayco')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="p-6 bg-white rounded-lg shadow">
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
    <div class="p-6 bg-white rounded-lg shadow">
        <form action="{{ route('creator.integrations.epayco.store', $website) }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Public Key -->
                <div>
                    <label for="epayco_public_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Public Key
                    </label>
                    <input type="text" 
                           id="epayco_public_key" 
                           name="epayco_public_key" 
                           value="{{ old('epayco_public_key', $website->epayco_public_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu Public Key de Epayco"
                           required>
                    @error('epayco_public_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Private Key -->
                <div>
                    <label for="epayco_private_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Private Key
                    </label>
                    <input type="password" 
                           id="epayco_private_key" 
                           name="epayco_private_key" 
                           value="{{ old('epayco_private_key', $website->epayco_private_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu Private Key de Epayco"
                           required>
                    @error('epayco_private_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ePayco ID Cliente -->
                <div>
                    <label for="epayco_customer_id" class="block mb-2 text-sm font-medium text-gray-700">
                        ePayco ID Cliente
                    </label>
                    <input type="text" 
                           id="epayco_customer_id" 
                           name="epayco_customer_id" 
                           value="{{ old('epayco_customer_id', $website->epayco_customer_id) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ingresa tu ePayco ID Cliente"
                           required>
                    @error('epayco_customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <!-- Botones -->
            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('creator.dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="p-6 border border-blue-200 rounded-lg bg-blue-50">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Las credenciales se almacenan de forma segura y encriptada.</li>
                        <li>Una vez configurado, podrás procesar pagos desde tu tienda en línea.</li>
                        <li>Para obtener tus credenciales, visita el panel de Epayco.</li>
                        <li>La Private Key se oculta por seguridad y no se muestra en pantalla.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
