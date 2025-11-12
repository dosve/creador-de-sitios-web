<!-- Features Section - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? '¿Por qué elegirnos?' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Descubre las ventajas que nos hacen únicos en el mercado' }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'fas fa-shipping-fast', 'title' => 'Envío Gratis', 'desc' => 'Envío gratuito en compras superiores a $50', 'color' => 'blue'],
                    ['icon' => 'fas fa-shield-alt', 'title' => 'Compra Segura', 'desc' => 'Protección SSL y garantía de devolución', 'color' => 'green'],
                    ['icon' => 'fas fa-headset', 'title' => 'Soporte 24/7', 'desc' => 'Atención al cliente disponible las 24 horas', 'color' => 'purple'],
                    ['icon' => 'fas fa-award', 'title' => 'Calidad Premium', 'desc' => 'Productos seleccionados por su excelencia', 'color' => 'yellow'],
                    ['icon' => 'fas fa-undo', 'title' => 'Devolución Fácil', 'desc' => '30 días para devolver sin preguntas', 'color' => 'red'],
                    ['icon' => 'fas fa-mobile-alt', 'title' => 'App Móvil', 'desc' => 'Compra desde cualquier lugar con nuestra app', 'color' => 'indigo']
                ];
            @endphp
            
            @foreach($features as $index => $feature)
            <div class="text-center p-8 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="w-20 h-20 bg-gradient-to-br from-{{ $feature['color'] }}-100 to-{{ $feature['color'] }}-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="{{ $feature['icon'] }} text-3xl text-{{ $feature['color'] }}-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-{{ $feature['color'] }}-600 transition-colors">
                    {{ $block['feature_' . ($index + 1) . '_title'] ?? $feature['title'] }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $block['feature_' . ($index + 1) . '_description'] ?? $feature['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
        
        <!-- Estadísticas -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">10K+</div>
                <div class="text-gray-600">Clientes Satisfechos</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">500+</div>
                <div class="text-gray-600">Productos</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">99%</div>
                <div class="text-gray-600">Satisfacción</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">24/7</div>
                <div class="text-gray-600">Soporte</div>
            </div>
        </div>
    </div>
</div>
