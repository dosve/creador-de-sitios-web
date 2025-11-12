@php
    // Props esperados: $index (int)
    $i = $index ?? 1;
@endphp
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
    <div class="relative h-56">
        <img src="https://picsum.photos/500/400?random={{ 900 + $i }}" class="w-full h-full object-cover" alt="Producto {{ $i }}">
        @if($i <= 3)
        <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">-{{ 10 + $i*5 }}%</div>
        @endif
        <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center text-gray-400 hover:text-red-500">
            <i class="fas fa-heart"></i>
        </button>
    </div>
    <div class="p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Producto {{ $i }}</h3>
        <p class="text-sm text-gray-600 mb-3">Descripción breve del producto.</p>
        <div class="flex items-center justify-between">
            <div>
                <span class="text-2xl font-bold text-gray-900">${{ number_format(99000 + $i*20000, 0, ',', '.') }} COP</span>
            </div>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">Comprar</button>
        </div>
    </div>
</div>


