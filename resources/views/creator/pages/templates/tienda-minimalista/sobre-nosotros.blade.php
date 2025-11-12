<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Tienda Minimalista</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-minimalista.partials.header', [
            'badge' => 'NUESTRA MARCA',
            'title' => 'Sobre nosotros',
            'subtitle' => 'Creamos esenciales de moda con diseño atemporal. Menos ruido, más calidad.',
            'image' => 'https://picsum.photos/1600/600?grayscale&random=803'
        ])

        <!-- Manifiesto -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Manifiesto</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">Creemos en prendas que funcionan todos los días. Siluetas limpias, materiales responsables y una paleta neutra que combina con todo. Diseñamos para durar más allá de la temporada.</p>
                    <p class="text-gray-600 leading-relaxed">Nuestro proceso privilegia la calidad: proveedores locales, confección cuidada y control de cada detalle para entregarte piezas esenciales, sin exceso.</p>
                </div>
                <aside class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-semibold text-gray-900 mb-3">Valores</h3>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-check mr-2 text-gray-500"></i>Diseño atemporal</li>
                        <li class="flex items-center"><i class="fas fa-check mr-2 text-gray-500"></i>Calidad responsable</li>
                        <li class="flex items-center"><i class="fas fa-check mr-2 text-gray-500"></i>Producción consciente</li>
                        <li class="flex items-center"><i class="fas fa-check mr-2 text-gray-500"></i>Transparencia</li>
                    </ul>
                </aside>
            </div>
        </section>

        <!-- Línea de tiempo -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Nuestra historia</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sm text-gray-500 mb-1">2019</div>
                        <div class="font-semibold text-gray-900 mb-2">La idea</div>
                        <p class="text-gray-600 text-sm">Nace la visión de una marca simple, honesta y funcional.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sm text-gray-500 mb-1">2021</div>
                        <div class="font-semibold text-gray-900 mb-2">Primera colección</div>
                        <p class="text-gray-600 text-sm">Lanzamos nuestra cápsula de básicos: camisetas, pantalones y abrigos.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sm text-gray-500 mb-1">2024</div>
                        <div class="font-semibold text-gray-900 mb-2">Expansión</div>
                        <p class="text-gray-600 text-sm">Sumamos accesorios y calzado, manteniendo la esencia minimalista.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Equipo / Contacto breve -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">El equipo</h2>
                    <p class="text-gray-600">Un grupo de diseñadores y artesanos comprometidos con hacer menos, pero mejor.</p>
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        @for($i=1;$i<=4;$i++)
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/80?img={{ 30+$i }}" class="w-12 h-12 rounded-full object-cover" alt="Miembro {{ $i }}">
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">Miembro {{ $i }}</div>
                                <div class="text-xs text-gray-500">Diseño</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-semibold text-gray-900 mb-3">Contacto</h3>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>Av. Minimal 101, Moda City</li>
                        <li class="flex items-center"><i class="fas fa-phone mr-2 text-gray-500"></i>+57 300 000 0000</li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-2 text-gray-500"></i>hola@minimalista.com</li>
                    </ul>
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-minimalista.partials.footer')
    </main>
</body>
</html>
