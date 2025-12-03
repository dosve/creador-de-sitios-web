{{-- Contenido de Mis Órdenes (sin layout, para incluir en plantilla) --}}
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mis Órdenes</h1>
            <p class="text-gray-600">Revisa el estado y detalles de tus compras</p>
        </div>

        {{-- Lista de Órdenes --}}
        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="p-6">
                    {{-- Header de la orden --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                Orden #{{ $order->order_number }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        
                        <div class="flex flex-col md:items-end space-y-2">
                            {{-- Estado de la orden --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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

                    {{-- Productos --}}
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Productos:</h4>
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                            <div class="flex items-center space-x-3 text-sm">
                                {{-- Imagen del producto en miniatura --}}
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($item->product_image)
                                        <img src="{{ $item->product_image }}" 
                                             alt="{{ $item->product_name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.parentElement.innerHTML='<svg class=\'w-6 h-6 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\'></path></svg>'">
                                    @elseif($item->product && $item->product->featured_image)
                                        @php
                                            $imageUrl = $item->product->featured_image;
                                            // Si no es una URL completa, usar Storage::url
                                            if (!str_starts_with($imageUrl, 'http')) {
                                                $imageUrl = Storage::url($imageUrl);
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $item->product_name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.parentElement.innerHTML='<svg class=\'w-6 h-6 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\'></path></svg>'">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    @endif
                                </div>
                                
                                <div class="flex-1 flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-900">{{ $item->product_name }}</span>
                                        <span class="text-gray-500 ml-2">x{{ $item->quantity }}</span>
                                    </div>
                                    <span class="text-gray-900 font-medium">
                                        ${{ number_format($item->total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer con total y botón --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between pt-4 border-t border-gray-200">
                        <div class="mb-4 md:mb-0">
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format($order->total, 0, ',', '.') }} {{ $order->currency }}
                            </p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="/{{ $website->slug }}/order/{{ $order->order_number }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif

        @else
        {{-- Estado vacío --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes órdenes aún</h3>
            <p class="text-gray-600 mb-6">Comienza a explorar nuestros productos y realiza tu primera compra</p>
            <a href="/{{ $website->slug }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Ir a la Tienda
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Verificación de sesión al cargar la página --}}
<script>
document.addEventListener('DOMContentLoaded', async function() {
    // Verificar si la sesión sigue activa
    try {
        const response = await fetch('/customer/check');
        const data = await response.json();
        
        if (!data.authenticated) {
            // Sesión expirada o cerrada, redirigir a inicio
            console.warn('Sesión no activa, redirigiendo...');
            window.location.replace('/{{ $website->slug }}');
        }
    } catch (error) {
        console.error('Error verificando sesión:', error);
        // En caso de error, redirigir por seguridad
        window.location.replace('/{{ $website->slug }}');
    }
});

// Prevenir que se pueda usar el botón atrás para ver esta página sin sesión
window.addEventListener('pageshow', function(event) {
    // Si la página se carga desde el caché del navegador
    if (event.persisted) {
        // Verificar sesión nuevamente
        fetch('/customer/check')
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    window.location.replace('/{{ $website->slug }}');
                }
            })
            .catch(() => {
                window.location.replace('/{{ $website->slug }}');
            });
    }
});
</script>

