@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Dominios Personalizados</h1>
            <p class="text-gray-600">Vincula tu propio dominio (de GoDaddy, Hostinger, etc.) a tu sitio web</p>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Información del sitio actual -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
            <h3 class="font-semibold text-blue-900 mb-2">📌 URL Actual de tu Sitio</h3>
            <p class="text-blue-800 mb-2">
                <strong>Sitio:</strong> {{ $website->name }}
            </p>
            @if($website->subdomain)
                <p class="text-blue-800">
                    <strong>URL:</strong> 
                    <a href="https://{{ $website->subdomain }}.paginas.eme10.com" target="_blank" class="underline">
                        {{ $website->subdomain }}.paginas.eme10.com
                    </a>
                </p>
            @else
                <p class="text-blue-800">
                    <strong>URL:</strong> <span class="text-gray-600">Sin subdominio asignado</span>
                </p>
            @endif
        </div>

        <!-- Formulario para agregar dominio -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">Agregar Dominio Personalizado</h2>
            
            <form action="{{ route('domains.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ingresa tu dominio
                    </label>
                    <input type="text" 
                           name="domain" 
                           placeholder="www.minegocio.com o minegocio.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    <p class="text-xs text-gray-500 mt-2">
                        ✅ Ejemplos válidos: www.minegocio.com, minegocio.com, tienda.minegocio.com
                    </p>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    Agregar Dominio
                </button>
            </form>
        </div>

        <!-- Lista de dominios -->
        @if($domains->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-bold">Mis Dominios</h2>
                </div>
                
                <div class="divide-y">
                    @foreach($domains as $domain)
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            {{ $domain->domain }}
                                        </h3>
                                        
                                        @if($domain->is_primary)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                                Principal
                                            </span>
                                        @endif
                                        
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $domain->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $domain->is_verified ? '✓ Verificado' : '⏳ Pendiente' }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600">
                                        Tipo: <span class="font-medium">{{ ucfirst($domain->type) }}</span> | 
                                        Estado: <span class="font-medium">{{ ucfirst($domain->status) }}</span>
                                    </p>
                                    
                                    @if($domain->notes)
                                        <p class="text-sm text-gray-500 mt-2">
                                            📝 {{ $domain->notes }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Acciones -->
                            <div class="flex gap-3 mt-4">
                                @if(!$domain->is_verified)
                                    <form action="{{ route('domains.verify', $domain->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded">
                                            Verificar Ahora
                                        </button>
                                    </form>
                                @endif
                                
                                @if($domain->is_verified && !$domain->is_primary)
                                    <form action="{{ route('domains.set-primary', $domain->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded">
                                            Establecer como Principal
                                        </button>
                                    </form>
                                @endif
                                
                                @if(!$domain->is_primary)
                                    <form action="{{ route('domains.destroy', $domain->id) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este dominio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <!-- Instrucciones DNS si no está verificado -->
                            @if(!$domain->is_verified)
                                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <h4 class="font-semibold text-yellow-900 mb-3">📋 Configuración DNS Requerida</h4>
                                    <p class="text-sm text-yellow-800 mb-3">
                                        Configura estos registros en tu proveedor de DNS (GoDaddy, Hostinger, etc.):
                                    </p>
                                    
                                    <div class="bg-white p-4 rounded border border-yellow-300 font-mono text-sm">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div>
                                                <span class="font-semibold">Tipo:</span><br>
                                                CNAME
                                            </div>
                                            <div>
                                                <span class="font-semibold">Nombre/Host:</span><br>
                                                @
                                            </div>
                                            <div>
                                                <span class="font-semibold">Apunta a:</span><br>
                                                paginas.eme10.com
                                            </div>
                                        </div>
                                        <div class="mt-2 pt-2 border-t border-gray-200">
                                            <span class="font-semibold">TTL:</span> 3600 (1 hora)
                                        </div>
                                    </div>
                                    
                                    <p class="text-xs text-yellow-700 mt-3">
                                        ⏱️ La propagación DNS puede tardar hasta 24-48 horas
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Guía de configuración -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">📚 Guía Rápida: Cómo Configurar tu Dominio</h2>
            
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        1
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Compra un dominio</h3>
                        <p class="text-sm text-gray-600">
                            En GoDaddy, Hostinger, Namecheap u otro proveedor (ej: www.minegocio.com)
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        2
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Agrega el dominio aquí</h3>
                        <p class="text-sm text-gray-600">
                            Usa el formulario de arriba para agregar tu dominio
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        3
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Configura DNS</h3>
                        <p class="text-sm text-gray-600">
                            En tu proveedor, crea un registro CNAME apuntando a <code class="bg-gray-100 px-2 py-1 rounded">paginas.eme10.com</code>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                        4
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Espera y verifica</h3>
                        <p class="text-sm text-gray-600">
                            Espera la propagación DNS (24-48 hrs) y haz clic en "Verificar Ahora"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

