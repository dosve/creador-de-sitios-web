<!-- Offers Section - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gradient-to-br from-red-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Ofertas Especiales' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Aprovecha estas increíbles ofertas por tiempo limitado' }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $offers = [
                    [
                        'title' => 'Black Friday',
                        'discount' => '50%',
                        'description' => 'En todos los productos seleccionados',
                        'image' => 'https://picsum.photos/400/300?random=offer1',
                        'color' => 'red',
                        'expires' => '2 días restantes'
                    ],
                    [
                        'title' => 'Envío Gratis',
                        'discount' => '100%',
                        'description' => 'En compras superiores a $100',
                        'image' => 'https://picsum.photos/400/300?random=offer2',
                        'color' => 'green',
                        'expires' => 'Siempre disponible'
                    ],
                    [
                        'title' => 'Nuevos Productos',
                        'discount' => '30%',
                        'description' => 'Descuento en lanzamientos',
                        'image' => 'https://picsum.photos/400/300?random=offer3',
                        'color' => 'blue',
                        'expires' => '1 semana restante'
                    ]
                ];
            @endphp
            
            @foreach($offers as $index => $offer)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Imagen de la oferta -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $offer['image'] }}" 
                         alt="{{ $offer['title'] }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    
                    <!-- Badge de descuento -->
                    <div class="absolute top-4 left-4 bg-{{ $offer['color'] }}-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                        -{{ $offer['discount'] }}
                    </div>
                    
                    <!-- Tiempo restante -->
                    <div class="absolute top-4 right-4 bg-black/70 text-white px-3 py-1 rounded-full text-xs">
                        {{ $offer['expires'] }}
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $block['offer_' . ($index + 1) . '_title'] ?? $offer['title'] }}</h3>
                    <p class="text-gray-600 mb-4">{{ $block['offer_' . ($index + 1) . '_description'] ?? $offer['description'] }}</p>
                    
                    <!-- Botón de acción -->
                    <button class="w-full bg-{{ $offer['color'] }}-600 text-white py-3 rounded-lg font-semibold hover:bg-{{ $offer['color'] }}-700 transition-colors">
                        Aprovechar Oferta
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Banner principal de oferta -->
        <div class="mt-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white text-center">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-3xl font-bold mb-4">¡Gran Oferta de Lanzamiento!</h3>
                <p class="text-xl text-indigo-100 mb-6">Obtén un 40% de descuento en tu primera compra + envío gratis</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Comprar Ahora
                    </button>
                    <button class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition-colors">
                        <i class="fas fa-info-circle mr-2"></i>
                        Ver Detalles
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
