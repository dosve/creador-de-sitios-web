<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Tienda Minimalista</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-minimalista.partials.header', [
            'badge' => 'ASISTENCIA',
            'title' => 'Contacto',
            'subtitle' => '¿Necesitas ayuda con tu pedido? Escríbenos: respondemos en menos de 24h.',
            'image' => 'https://picsum.photos/1600/600?grayscale&random=802'
        ])

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Información -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Información de contacto</h2>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center"><i class="fas fa-map-marker-alt w-6 text-gray-500"></i> Av. Minimal 101, Moda City</li>
                            <li class="flex items-center"><i class="fas fa-phone w-6 text-gray-500"></i> +57 300 000 0000</li>
                            <li class="flex items-center"><i class="fas fa-envelope w-6 text-gray-500"></i> hola@minimalista.com</li>
                            <li class="flex items-center"><i class="fas fa-clock w-6 text-gray-500"></i> Lun-Vie 9:00 - 18:00</li>
                        </ul>
                    </div>

                    <div class="rounded-2xl overflow-hidden border border-gray-100">
                        <img src="https://picsum.photos/1200/600?grayscale&random=992" alt="Mapa" class="w-full h-64 object-cover">
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <h3 class="font-semibold text-gray-900 mb-3">Atención al cliente</h3>
                        <p class="text-gray-600 text-sm">Cambios y devoluciones en 30 días. Envíos a todo el país.</p>
                    </div>
                </div>

                <!-- Formulario minimal -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Escríbenos</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black" placeholder="Tu nombre completo">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black" placeholder="tu@email.com">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asunto *</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                                <option>Consulta de producto</option>
                                <option>Mi pedido</option>
                                <option>Cambios y devoluciones</option>
                                <option>Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje *</label>
                            <textarea rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black" placeholder="Cuéntanos en qué podemos ayudarte..."></textarea>
                        </div>
                        <div class="flex items-start">
                            <input type="checkbox" id="privacy" class="mt-1 mr-3">
                            <label for="privacy" class="text-sm text-gray-600">Acepto la política de privacidad.</label>
                        </div>
                        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-900">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-minimalista.partials.footer')
    </main>
</body>
</html>
