{{-- Contenido de Mis Direcciones --}}
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mis Direcciones</h1>
            <p class="text-gray-600">Gestiona los lugares donde recibes tus pedidos</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-3 md:space-y-0">
                <div>
                    <p class="text-sm text-gray-500">Cliente</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $customerData['name'] ?? 'Cliente' }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $customerData['email'] ?? '' }}</p>
                </div>

                <div class="space-x-3">
                    <a href="/{{ $website->slug }}/profile"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver al perfil
                    </a>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                        </svg>
                        Nueva Dirección
                    </button>
                </div>
            </div>

            @if($addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($addresses as $address)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-200 transition-colors bg-gray-50">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-sm uppercase text-gray-500 font-semibold">
                                        {{ $address->name ?? 'Dirección' }}
                                    </p>
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $address->address }}
                                    </p>
                                </div>
                                @if($address->is_primary)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                        Principal
                                    </span>
                                @endif
                            </div>

                            <div class="text-sm text-gray-600 space-y-1">
                                <p>{{ $address->city }} @if($address->state) - {{ $address->state }} @endif</p>
                                @if(!empty($address->reference))
                                    <p class="text-gray-500">Referencia: {{ $address->reference }}</p>
                                @endif
                                <p class="text-gray-500">
                                    Registrada el {{ optional($address->created_at)->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="mt-4 flex items-center justify-between text-sm">
                                <button class="text-blue-600 hover:text-blue-700 font-medium">
                                    Editar
                                </button>
                                <button class="text-red-600 hover:text-red-700 font-medium">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes direcciones guardadas</h3>
                    <p class="text-gray-600 mb-4">
                        Agrega tus direcciones frecuentes para acelerar tu proceso de compra.
                    </p>
                    <button class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Agregar dirección
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

