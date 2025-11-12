<!-- Cart - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Tu Carrito' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Revisa tus productos y finaliza tu compra' }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lista de productos -->
            <div class="lg:col-span-2 space-y-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
                    <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://picsum.photos/200/200?random={{ $i+50 }}" alt="Producto {{ $i }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $block['item_' . $i . '_name'] ?? 'Producto ' . $i }}</h3>
                                <p class="text-sm text-gray-600">Talla M · Color Negro</p>
                            </div>
                            <button class="text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="inline-flex items-center border rounded-lg">
                                <button class="px-3 py-2 text-gray-600">-</button>
                                <span class="px-4 py-2">1</span>
                                <button class="px-3 py-2 text-gray-600">+</button>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-900">${{ 49 + ($i * 20) }}</div>
                                <div class="text-sm text-gray-500 line-through">${{ 69 + ($i * 25) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Resumen -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Resumen de la Orden</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">$248</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Envío</span>
                            <span class="font-semibold">Gratis</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Descuento</span>
                            <span class="font-semibold text-green-600">-$30</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-base">
                            <span class="font-bold text-gray-900">Total</span>
                            <span class="font-bold text-gray-900">$218</span>
                        </div>
                    </div>
                    <button class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Ir a Pagar
                    </button>
                    <p class="text-xs text-gray-500 mt-3">Al continuar aceptas nuestros Términos y Política de Privacidad.</p>
                </div>
                <div class="mt-4 bg-indigo-50 border border-indigo-200 text-indigo-800 rounded-xl p-4 text-sm">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Compra 100% segura con protección al comprador
                </div>
            </div>
        </div>
    </div>
</div>
