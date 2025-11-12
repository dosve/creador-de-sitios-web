<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Tienda Minimalista</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-minimalista.partials.header', [
            'badge' => 'CATÁLOGO',
            'title' => 'Categorías',
            'subtitle' => 'Explora por Mujer, Hombre, Accesorios y Calzado',
            'image' => 'https://picsum.photos/1600/600?grayscale&random=804'
        ])

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        $categories = [
                            ['name' => 'Mujer', 'img' => 1201],
                            ['name' => 'Hombre', 'img' => 1202],
                            ['name' => 'Accesorios', 'img' => 1203],
                            ['name' => 'Calzado', 'img' => 1204],
                            ['name' => 'Bolsos', 'img' => 1205],
                            ['name' => 'Abrigos', 'img' => 1206],
                            ['name' => 'Camisas', 'img' => 1207],
                            ['name' => 'Pantalones', 'img' => 1208],
                        ];
                    @endphp

                    @foreach($categories as $i => $cat)
                    <a href="#" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="relative h-44 overflow-hidden">
                            <img src="https://picsum.photos/600/400?grayscale&random={{ $cat['img'] }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>
                        <div class="p-5 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $cat['name'] }}</h3>
                            <span class="text-sm text-gray-500 group-hover:text-gray-700">Ver →</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-minimalista.partials.footer')
    </main>
</body>
</html>
