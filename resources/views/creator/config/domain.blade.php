@extends('layouts.creator')

@section('title', 'Configuración de Dominio - ' . $website->name)
@section('page-title', 'Configuración de Dominio')
@section('content')
            <!-- Domain Configuration Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Vincular Dominio Personalizado</h2>
                            <p class="text-sm text-gray-600 mt-1">Conecta tu dominio personalizado con {{ $website->name }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($domains->count() > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Dominio Vinculado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Sin Dominio
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($domains->count() == 0)
            <!-- Add Domain Form -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Vincular tu Dominio</h3>
                    <p class="text-sm text-gray-600 mt-1">Ingresa el dominio que quieres conectar con tu sitio web</p>
                </div>
                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('creator.config.domain.store') }}">
                        @csrf
                        <div class="max-w-md">
                            <label for="domain_name" class="block text-sm font-medium text-gray-700">Tu Dominio</label>
                            <div class="mt-1">
                                <input type="text" name="domain_name" id="domain_name" 
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('domain_name') border-red-300 @enderror" 
                                       placeholder="midominio.com" required>
                            </div>
                            @error('domain_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Ejemplo: midominio.com, www.midominio.com</p>
                        </div>
                        <div class="mt-6">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Vincular Dominio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <!-- Current Domain Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Dominio Vinculado</h3>
                </div>
                <div class="px-6 py-4">
                    @foreach($domains as $domain)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $domain->domain }}</h4>
                                <div class="flex items-center space-x-2 mt-1">
                                    @if($domain->is_verified)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Verificado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pendiente de verificación
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(!$domain->is_verified)
                                <form method="POST" action="{{ route('creator.config.domain.verify', $domain) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Verificar
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('creator.config.domain.destroy', $domain) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm"
                                        onclick="return confirm('¿Estás seguro de que quieres desvincular este dominio?')">
                                    Desvincular
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- DNS Configuration Help -->
            @if($domains->count() > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">¿Necesitas ayuda con la configuración DNS?</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Para que tu dominio funcione correctamente, necesitarás configurar los registros DNS en tu proveedor de dominios. Una vez vinculado, te mostraremos las instrucciones específicas.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
@endsection
