<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        {{-- Breadcrumb --}}
        <div class="mb-6">
            <a href="/{{ $website->slug }}/my-orders" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver a Mis Órdenes
            </a>
        </div>

        {{-- Header --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        Orden #{{ $order->order_number }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        Realizada el {{ $order->created_at->format('d/m/Y') }} a las {{ $order->created_at->format('H:i') }}
                    </p>
                </div>
                
                <div class="mt-4 md:mt-0 flex flex-col space-y-2">
                    {{-- Estado de la orden --}}
                    <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @if($order->status === 'pending') ⏳ Pendiente
                        @elseif($order->status === 'processing') 🔄 Procesando
                        @elseif($order->status === 'shipped') 📦 Enviado
                        @elseif($order->status === 'delivered') ✅ Entregado
                        @elseif($order->status === 'cancelled') ❌ Cancelado
                        @else {{ ucfirst($order->status) }}
                        @endif
                    </span>
                    
                    {{-- Estado del pago --}}
                    <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                        @elseif($order->payment_status === 'refunded') bg-gray-100 text-gray-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @if($order->payment_status === 'pending') 💳 Pago Pendiente
                        @elseif($order->payment_status === 'paid') ✓ Pagado
                        @elseif($order->payment_status === 'failed') ✗ Pago Fallido
                        @elseif($order->payment_status === 'refunded') ↩ Reembolsado
                        @else {{ ucfirst($order->payment_status) }}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Columna Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Productos --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Productos</h2>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-start space-x-4 pb-4 @if(!$loop->last) border-b border-gray-200 @endif">
                                {{-- Placeholder de imagen --}}
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-medium text-gray-900 mb-1">
                                        {{ $item->product_name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Cantidad: {{ $item->quantity }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Precio unitario: ${{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-900">
                                        ${{ number_format($item->total, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Direcciones --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Información de Envío</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Dirección de Envío --}}
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Dirección de Envío
                                </h3>
                                <div class="text-sm text-gray-600 space-y-1">
                                    @if(is_array($order->shipping_address))
                                        <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                        <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}</p>
                                        <p>{{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                        <p>{{ $order->shipping_address['country'] ?? '' }}</p>
                                    @else
                                        <p>{{ $order->shipping_address }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Dirección de Facturación --}}
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Dirección de Facturación
                                </h3>
                                <div class="text-sm text-gray-600 space-y-1">
                                    @if(is_array($order->billing_address))
                                        <p>{{ $order->billing_address['address'] ?? '' }}</p>
                                        <p>{{ $order->billing_address['city'] ?? '' }}, {{ $order->billing_address['state'] ?? '' }}</p>
                                        <p>{{ $order->billing_address['postal_code'] ?? '' }}</p>
                                        <p>{{ $order->billing_address['country'] ?? '' }}</p>
                                    @else
                                        <p>{{ $order->billing_address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información del Cliente --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Cliente</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Nombre</p>
                                <p class="text-base font-medium text-gray-900">{{ $order->customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Email</p>
                                <p class="text-base font-medium text-gray-900">{{ $order->customer->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Teléfono</p>
                                <p class="text-base font-medium text-gray-900">{{ $order->customer->phone ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Método de Pago</p>
                                <p class="text-base font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Notas</p>
                            <p class="text-base text-gray-900">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar - Resumen --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-4">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Resumen de Orden</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900 font-medium">
                                    ${{ number_format($order->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            @if($order->tax_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Impuestos</span>
                                <span class="text-gray-900 font-medium">
                                    ${{ number_format($order->tax_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif
                            
                            @if($order->shipping_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Envío</span>
                                <span class="text-gray-900 font-medium">
                                    ${{ number_format($order->shipping_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($order->total, 0, ',', '.') }} {{ $order->currency }}
                                </span>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="space-y-3">
                            @if($order->payment_status === 'pending')
                            <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                Pagar Ahora
                            </button>
                            @endif
                            
                            <a href="/{{ $website->slug }}" 
                               class="block w-full text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                Continuar Comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

