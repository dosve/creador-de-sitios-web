<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Contacto' }} - {{ $websiteName ?? 'Tienda' }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-virtual.partials.header', [
            'image' => 'https://picsum.photos/1920/900?random=777',
            'title' => 'Contacto',
            'subtitle' => 'Estamos aquí para ayudarte',
            'badge' => 'ATENCIÓN',
            'cta' => ['primary' => 'Escríbenos', 'secondary' => 'Ver tienda']
        ])

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un mensaje</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg" placeholder="Tu nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                            <input type="email" class="w-full border-gray-300 rounded-lg" placeholder="tu@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                            <textarea rows="5" class="w-full border-gray-300 rounded-lg" placeholder="¿Cómo podemos ayudarte?"></textarea>
                        </div>
                        <button type="button" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">Enviar</button>
                    </form>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Información</h2>
                    <ul class="space-y-4 text-gray-700">
                        <li><i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i> Dirección: Calle 123, Ciudad</li>
                        <li><i class="fas fa-phone text-indigo-600 mr-2"></i> Teléfono: +57 300 000 0000</li>
                        <li><i class="fas fa-envelope text-indigo-600 mr-2"></i> Email: contacto@tienda.com</li>
                        <li><i class="fas fa-clock text-indigo-600 mr-2"></i> Horarios: Lun-Vie 9:00 - 18:00</li>
                    </ul>
                    <div class="mt-6 h-56 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">Mapa</div>
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-virtual.partials.footer')
    </main>
</body>
</html>








