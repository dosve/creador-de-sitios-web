<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Tienda Virtual</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-virtual.partials.header', [
            'image' => 'https://picsum.photos/1920/900?random=952',
            'title' => 'Categorías',
            'subtitle' => 'Encuentra lo que buscas por secciones',
            'badge' => 'CATÁLOGO'
        ])

        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php $cats=['Electrónica','Hogar','Moda','Deportes','Belleza','Oficina','Mascotas','Bebés']; @endphp
                    @foreach($cats as $idx => $name)
                    <a href="#" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="relative h-44 overflow-hidden">
                            <img src="https://picsum.photos/600/400?random={{ 970 + $idx }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>
                        <div class="p-5 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
                            <span class="text-sm text-gray-500 group-hover:text-gray-700">Ver →</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-virtual.partials.footer')
    </main>
</body>
</html>


