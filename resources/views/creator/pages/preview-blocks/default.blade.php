<!-- Default Block - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $block['name'] ?? 'Contenido' }}</h2>
            <p class="text-lg text-gray-600">{{ $block['description'] ?? 'Este es un bloque de contenido personalizable' }}</p>
        </div>
        
        <div class="bg-gray-50 rounded-2xl p-8 border-2 border-dashed border-gray-300">
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-{{ $block['icon'] ?? 'cog' }} text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $block['name'] ?? 'Bloque Personalizable' }}</h3>
                <p class="text-gray-600 mb-6">Este bloque se puede personalizar según las necesidades específicas de tu sitio web.</p>
                
                <!-- Contenido de ejemplo -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="bg-white rounded-xl p-6 shadow-sm border">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-{{ $block['icon'] ?? 'star' }} text-indigo-600"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Elemento {{ $i }}</h4>
                        <p class="text-gray-600 text-sm">Descripción del elemento {{ $i }} que se puede personalizar completamente.</p>
                    </div>
                    @endfor
                </div>
                
                <!-- Botón de acción -->
                <div class="mt-8">
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-{{ $block['icon'] ?? 'arrow-right' }} mr-2"></i>
                        Acción Personalizable
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>