<!-- Product Grid Minimalist - Vista Previa del Navegador -->
<div class="py-12 mb-2 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Encabezado minimal -->
        <div class="mb-10">
            <h2 class="text-[42px] md:text-5xl tracking-tight font-extrabold text-gray-900 mb-3">{{ $block['title'] ?? 'Productos' }}</h2>
            <p class="text-gray-500 max-w-2xl">{{ $block['subtitle'] ?? 'Diseño limpio. Calidad premium. Paleta neutra.' }}</p>
        </div>

        <!-- Chips de categorías -->
        <div class="flex flex-wrap gap-2 mb-10">
            @php $chips = ['Mujer','Hombre','Accesorios','Calzado']; @endphp
            @foreach($chips as $idx => $chip)
            <button class="px-4 py-2 rounded-full text-sm {{ $idx===0 ? 'bg-black text-white' : 'border border-gray-300 text-gray-800 hover:bg-gray-50' }}">{{ $chip }}</button>
            @endforeach
        </div>

        <!-- Grid editorial asimétrico -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @for($i = 0; $i < 6; $i++)
            <div class="group">
                <div class="relative overflow-hidden rounded-2xl {{ $i % 3 === 0 ? 'h-[520px]' : 'h-[420px]' }} bg-gray-100">
                    <img src="https://picsum.photos/800/1000?random={{ 300 + $i }}" alt="Producto {{ $i+1 }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700 ease-out">
                </div>
                <div class="flex items-start justify-between mt-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $block['product_' . $i . '_name'] ?? 'Essential Item ' . ($i+1) }}</h3>
                        <p class="text-sm text-gray-500">{{ $block['product_' . $i . '_subtitle'] ?? 'Colección SS25' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-base font-semibold text-gray-900">${{ $block['product_' . $i . '_price'] ?? (120 + $i*10) }}</div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- CTA minimal -->
        <div class="mt-12">
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-full text-sm font-semibold text-gray-800 hover:bg-gray-50">
                Ver toda la colección
                <span class="text-gray-400">→</span>
            </a>
        </div>
    </div>
</div>
