<!-- Testimonials Section - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Lo que dicen nuestros clientes' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? 'Miles de clientes satisfechos confían en nosotros' }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    [
                        'name' => 'María González',
                        'role' => 'Cliente desde 2020',
                        'image' => 'https://i.pravatar.cc/150?img=1',
                        'rating' => 5,
                        'text' => 'Excelente servicio y productos de alta calidad. El envío fue súper rápido y el producto llegó en perfectas condiciones.'
                    ],
                    [
                        'name' => 'Carlos Rodríguez',
                        'role' => 'Empresario',
                        'image' => 'https://i.pravatar.cc/150?img=2',
                        'rating' => 5,
                        'text' => 'La atención al cliente es excepcional. Resolvieron todas mis dudas de manera rápida y profesional.'
                    ],
                    [
                        'name' => 'Ana Martínez',
                        'role' => 'Diseñadora',
                        'image' => 'https://i.pravatar.cc/150?img=3',
                        'rating' => 5,
                        'text' => 'Los productos superaron mis expectativas. La calidad es increíble y el precio muy justo. ¡100% recomendado!'
                    ],
                    [
                        'name' => 'Luis Fernández',
                        'role' => 'Ingeniero',
                        'image' => 'https://i.pravatar.cc/150?img=4',
                        'rating' => 5,
                        'text' => 'Proceso de compra muy fácil y seguro. El seguimiento del pedido fue perfecto. Volveré a comprar sin duda.'
                    ],
                    [
                        'name' => 'Sofia Herrera',
                        'role' => 'Estudiante',
                        'image' => 'https://i.pravatar.cc/150?img=5',
                        'rating' => 5,
                        'text' => 'Me encanta la variedad de productos que ofrecen. Siempre encuentro lo que necesito y a buen precio.'
                    ],
                    [
                        'name' => 'Diego Morales',
                        'role' => 'Freelancer',
                        'image' => 'https://i.pravatar.cc/150?img=6',
                        'rating' => 5,
                        'text' => 'El soporte técnico es excelente. Me ayudaron a resolver un problema de manera muy eficiente.'
                    ]
                ];
            @endphp
            
            @foreach($testimonials as $index => $testimonial)
            <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300 group">
                <!-- Rating -->
                <div class="flex text-yellow-400 mb-4">
                    @for($star = 1; $star <= $testimonial['rating']; $star++)
                        <i class="fas fa-star text-sm"></i>
                    @endfor
                </div>
                
                <!-- Testimonial text -->
                <blockquote class="text-gray-700 mb-6 leading-relaxed">
                    "{{ $block['testimonial_' . ($index + 1) . '_text'] ?? $testimonial['text'] }}"
                </blockquote>
                
                <!-- Author -->
                <div class="flex items-center">
                    <img src="{{ $testimonial['image'] }}" 
                         alt="{{ $testimonial['name'] }}" 
                         class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $testimonial['name'] }}</div>
                        <div class="text-sm text-gray-600">{{ $testimonial['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Call to action -->
        <div class="text-center mt-16">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">¿Listo para unirte a nuestros clientes satisfechos?</h3>
                <p class="text-indigo-100 mb-6">Descubre por qué miles de personas confían en nosotros</p>
                <button class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Comenzar Ahora
                </button>
            </div>
        </div>
    </div>
</div>
