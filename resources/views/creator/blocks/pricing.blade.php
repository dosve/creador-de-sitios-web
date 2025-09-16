{{-- Bloques de Precios --}}
{
  id: 'pricing'
  , label: 'Precios'
  , attributes: {
    class: 'gjs-block-pricing'
  }
  , content: `<section class="py-16 pricing">
    <div class="container px-4 mx-auto">
        <h2 class="mb-12 text-3xl font-bold text-center">Planes y Precios</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="p-8 bg-white border-2 border-gray-200 rounded-lg shadow-lg">
                <h3 class="mb-4 text-xl font-bold">Básico</h3>
                <div class="mb-6 text-4xl font-bold text-blue-600">$19<span class="text-lg text-gray-600">/mes</span></div>
                <ul class="mb-8 space-y-3">
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Hasta 5 páginas</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Soporte básico</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> SSL incluido</li>
                </ul>
                <button class="w-full py-3 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">Elegir Plan</button>
            </div>
            <div class="relative p-8 bg-white border-2 border-blue-500 rounded-lg shadow-lg">
                <div class="absolute px-4 py-1 text-sm text-white transform -translate-x-1/2 bg-blue-500 rounded-full -top-4 left-1/2">Más Popular</div>
                <h3 class="mb-4 text-xl font-bold">Pro</h3>
                <div class="mb-6 text-4xl font-bold text-blue-600">$49<span class="text-lg text-gray-600">/mes</span></div>
                <ul class="mb-8 space-y-3">
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Páginas ilimitadas</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Soporte prioritario</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> SSL incluido</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Analytics avanzados</li>
                </ul>
                <button class="w-full py-3 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">Elegir Plan</button>
            </div>
            <div class="p-8 bg-white border-2 border-gray-200 rounded-lg shadow-lg">
                <h3 class="mb-4 text-xl font-bold">Enterprise</h3>
                <div class="mb-6 text-4xl font-bold text-blue-600">$99<span class="text-lg text-gray-600">/mes</span></div>
                <ul class="mb-8 space-y-3">
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Todo incluido</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Soporte 24/7</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Dominio personalizado</li>
                    <li class="flex items-center"><span class="mr-2 text-green-500">✓</span> Integración API</li>
                </ul>
                <button class="w-full py-3 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">Elegir Plan</button>
            </div>
        </div>
    </div>
  </section>`
}
