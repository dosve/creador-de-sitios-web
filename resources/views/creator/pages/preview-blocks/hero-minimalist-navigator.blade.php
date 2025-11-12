<!-- Hero Minimalist - Vista Previa del Navegador -->
<div class="relative py-24 mb-10 overflow-hidden bg-white">
    <div class="absolute inset-0">
        <img src="https://picsum.photos/1920/900?blur=2&grayscale&random=555" alt="Minimal Hero" class="w-full h-full object-cover opacity-20">
    </div>
    <div class="relative max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            <span class="inline-block text-xs tracking-wider text-gray-500 mb-4">SPRING/SUMMER 2025</span>
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-4">{{ $block['title'] ?? 'Colección Minimalista' }}</h1>
            <p class="text-xl text-gray-600 mb-8">{{ $block['subtitle'] ?? 'Cortes limpios, paleta neutra y detalles premium' }}</p>
            <div class="flex flex-wrap gap-3">
                <a class="px-6 py-3 bg-black text-white rounded-full font-semibold hover:bg-gray-900">{{ $block['primary_button'] ?? 'Comprar' }}</a>
                <a class="px-6 py-3 border border-gray-300 rounded-full font-semibold text-gray-900 hover:bg-gray-50">{{ $block['secondary_button'] ?? 'Lookbook' }}</a>
            </div>
        </div>
    </div>
</div>
