<!-- Category Grid - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Explora por Categorías' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Encuentra rápido lo que buscas navegando por categorías' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php
                $categories = [
                    ['name' => 'Electrónica', 'icon' => 'fas fa-plug', 'items' => 128, 'color' => 'blue'],
                    ['name' => 'Hogar', 'icon' => 'fas fa-couch', 'items' => 96, 'color' => 'emerald'],
                    ['name' => 'Moda', 'icon' => 'fas fa-tshirt', 'items' => 210, 'color' => 'pink'],
                    ['name' => 'Deportes', 'icon' => 'fas fa-basketball-ball', 'items' => 74, 'color' => 'orange'],
                    ['name' => 'Belleza', 'icon' => 'fas fa-spa', 'items' => 65, 'color' => 'purple'],
                    ['name' => 'Oficina', 'icon' => 'fas fa-briefcase', 'items' => 52, 'color' => 'indigo'],
                    ['name' => 'Bebés', 'icon' => 'fas fa-baby', 'items' => 38, 'color' => 'rose'],
                    ['name' => 'Mascotas', 'icon' => 'fas fa-paw', 'items' => 59, 'color' => 'teal'],
                ];
            @endphp

            @foreach($categories as $i => $cat)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <div class="relative h-40 overflow-hidden">
                    <img src="https://picsum.photos/400/300?random={{ $i+20 }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $cat['name'] }}</h3>
                        <span class="text-sm text-gray-500">{{ $cat['items'] }} items</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="{{ $cat['icon'] }} mr-2 text-gray-500"></i>
                        Ver productos
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
