<div class="space-y-6">
    {{-- Información General --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
        <div>
            <p class="text-sm text-gray-600">Número de Orden</p>
            <p class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Fecha</p>
            <p class="text-base text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Cliente</p>
            <p class="text-base text-gray-900">{{ $order->customer->name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-500">{{ $order->customer->email ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Estado</p>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                @if($order->status === 'pending') Pendiente
                @elseif($order->status === 'processing') Procesando
                @elseif($order->status === 'shipped') Enviado
                @elseif($order->status === 'delivered') Entregado
                @elseif($order->status === 'cancelled') Cancelado
                @else {{ ucfirst($order->status) }}
                @endif
            </span>
        </div>
    </div>

    {{-- Productos --}}
    <div>
        <h4 class="text-base font-semibold text-gray-900 mb-4">Productos</h4>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                {{-- Imagen del producto --}}
                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($item->product_image)
                        <img src="{{ $item->product_image }}" 
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover"
                             onerror="this.parentElement.innerHTML='<svg class=\'w-8 h-8 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg>'">
                    @elseif($item->product && $item->product->featured_image)
                        @php
                            $imageUrl = $item->product->featured_image;
                            if (!str_starts_with($imageUrl, 'http')) {
                                $imageUrl = Storage::url($imageUrl);
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover"
                             onerror="this.parentElement.innerHTML='<svg class=\'w-8 h-8 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg>'">
                    @else
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                
                {{-- Información del producto --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                    <p class="text-sm text-gray-600">
                        Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 0, ',', '.') }}
                    </p>
                </div>
                
                {{-- Total --}}
                <div class="text-right">
                    <p class="text-base font-semibold text-gray-900">
                        ${{ number_format($item->total, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Resumen de Totales --}}
    <div class="border-t pt-4">
        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span class="text-gray-900 font-medium">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            
            @if($order->tax_amount > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Impuestos</span>
                <span class="text-gray-900 font-medium">${{ number_format($order->tax_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            @if($order->shipping_amount > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Envío</span>
                <span class="text-gray-900 font-medium">${{ number_format($order->shipping_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            <div class="flex justify-between text-lg font-bold border-t pt-2">
                <span class="text-gray-900">Total</span>
                <span class="text-gray-900">${{ number_format($order->total, 0, ',', '.') }} {{ $order->currency }}</span>
            </div>
        </div>
    </div>

    {{-- Información de Envío --}}
    @if($order->shipping_address)
    <div>
        <h4 class="text-base font-semibold text-gray-900 mb-3">Dirección de Envío</h4>
        <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-700">
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
    @endif
</div>

