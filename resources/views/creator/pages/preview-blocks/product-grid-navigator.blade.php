<!-- Product Grid Section - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Nuestros Productos' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Descubre nuestra selección cuidadosamente curada de productos de alta calidad' }}</p>
        </div>
        
        <!-- Filtros -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button class="px-6 py-2 bg-indigo-600 text-white rounded-full text-sm font-medium">Todos</button>
            <button class="px-6 py-2 bg-white text-gray-600 rounded-full text-sm font-medium hover:bg-gray-50">Destacados</button>
            <button class="px-6 py-2 bg-white text-gray-600 rounded-full text-sm font-medium hover:bg-gray-50">Nuevos</button>
            <button class="px-6 py-2 bg-white text-gray-600 rounded-full text-sm font-medium hover:bg-gray-50">Ofertas</button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @for($i = 1; $i <= 8; $i++)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Imagen del producto -->
                <div class="relative h-64 overflow-hidden">
                    <img src="https://picsum.photos/400/300?random={{ $i }}" 
                         alt="{{ $block['product_' . $i . '_name'] ?? 'Producto ' . $i }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    <!-- Badge de oferta -->
                    @if($i <= 3)
                    <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                        -{{ 20 + ($i * 5) }}%
                    </div>
                    @endif
                    <!-- Botón de favoritos -->
                    <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50 transition-colors">
                        <i class="fas fa-heart text-gray-400 hover:text-red-500"></i>
                    </button>
                </div>
                
                <div class="p-5">
                    <!-- Categoría -->
                    <div class="text-xs text-indigo-600 font-medium mb-2 uppercase tracking-wide">
                        {{ $i <= 2 ? 'Electrónicos' : ($i <= 4 ? 'Hogar' : 'Moda') }}
                    </div>
                    
                    <!-- Nombre del producto -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                        {{ $block['product_' . $i . '_name'] ?? 'Producto Premium ' . $i }}
                    </h3>
                    
                    <!-- Descripción -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $block['product_' . $i . '_description'] ?? 'Descripción detallada del producto con características destacadas' }}
                    </p>
                    
                    <!-- Rating -->
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($star = 1; $star <= 5; $star++)
                                <i class="fas fa-star text-xs"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 ml-2">({{ 100 + ($i * 23) }})</span>
                    </div>
                    
                    <!-- Precio y botón -->
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">${{ $block['product_' . $i . '_price'] ?? (99 + ($i * 25)) }}</span>
                            @if($i <= 3)
                            <span class="text-sm text-gray-500 line-through ml-2">${{ 150 + ($i * 30) }}</span>
                            @endif
                        </div>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        
        <!-- Botón ver más -->
        <div class="text-center mt-12">
            <button class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold border-2 border-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                Ver Todos los Productos
            </button>
        </div>
    </div>
</div>
