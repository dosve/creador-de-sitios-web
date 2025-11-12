<!-- Contact Form Section - Vista Previa del Navegador -->
<div class="py-16 mb-8 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $block['title'] ?? 'Contáctanos' }}</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $block['subtitle'] ?? '¿Tienes alguna pregunta? Estamos aquí para ayudarte' }}</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Información de contacto -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Dirección</h4>
                                <p class="text-gray-600">{{ $block['address'] ?? '123 Calle Principal, Ciudad, País' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Teléfono</h4>
                                <p class="text-gray-600">{{ $block['phone'] ?? '+1 (555) 123-4567' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600">{{ $block['email'] ?? 'info@tienda.com' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Horarios</h4>
                                <p class="text-gray-600">Lun - Vie: 9:00 - 18:00<br>Sáb: 10:00 - 16:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Redes sociales -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Tu nombre completo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="tu@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="+1 (555) 123-4567">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asunto *</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option>Consulta General</option>
                            <option>Soporte Técnico</option>
                            <option>Información de Productos</option>
                            <option>Devoluciones</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje *</label>
                        <textarea rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Cuéntanos más detalles..."></textarea>
                    </div>
                    <div class="flex items-start">
                        <input type="checkbox" id="privacy" class="mt-1 mr-3">
                        <label for="privacy" class="text-sm text-gray-600">
                            Acepto la <a href="#" class="text-indigo-600 hover:underline">política de privacidad</a> y el tratamiento de mis datos personales.
                        </label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-indigo-700 transition-colors w-full md:w-auto">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
