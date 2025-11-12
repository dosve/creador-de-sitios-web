<!-- Lookbook - Vista Previa del Navegador -->
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-8">
            <h3 class="text-3xl font-bold text-gray-900">Lookbook</h3>
            <a href="#" class="text-sm font-semibold text-gray-800 hover:text-black">Ver todo</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i = 0; $i < 3; $i++)
            <div class="group">
                <div class="relative h-96 overflow-hidden rounded-2xl">
                    <img src="https://picsum.photos/600/800?random={{ 200 + $i }}" alt="Look {{ $i+1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Outfit {{ $i+1 }}</div>
                        <div class="font-semibold text-gray-900">Colección SS25</div>
                    </div>
                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-black">Comprar el look →</a>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
