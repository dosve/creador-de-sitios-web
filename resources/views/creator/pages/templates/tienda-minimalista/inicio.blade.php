<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Tienda Minimalista</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-white">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-minimalista.partials.header', [
            'badge' => 'SPRING/SUMMER 2025',
            'title' => 'Tienda Minimalista',
            'subtitle' => 'Página principal minimalista con productos destacados',
            'image' => 'https://picsum.photos/1600/600?grayscale&random=800'
        ])

        <!-- Banner Colección -->
        <section class="relative bg-black text-white mb-12">
            <div class="absolute inset-0">
                <img src="https://picsum.photos/1920/800?grayscale&random=610" class="w-full h-full object-cover" alt="Colección SS25">
                <div class="absolute inset-0 bg-black/45"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 py-24">
                <div class="max-w-3xl">
                    <span class="inline-block px-3 py-1 bg-white/10 rounded-full text-xs tracking-wider mb-4">SPRING/SUMMER 2025</span>
                    <h2 class="text-5xl font-extrabold tracking-tight mb-4">Colección SS25</h2>
                    <p class="text-lg text-gray-200 mb-8">Prendas esenciales con siluetas limpias y tonos neutros.</p>
                    <a class="px-6 py-3 bg-white text-black rounded-lg font-semibold hover:bg-gray-100" href="#">Comprar ahora</a>
                </div>
            </div>
        </section>

        <!-- Lookbook -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-end justify-between mb-8">
                    <h3 class="text-3xl font-bold text-gray-900">Lookbook</h3>
                    <a href="#" class="text-sm font-semibold text-gray-800 hover:text-black">Ver todo</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for($i = 0; $i < 3; $i++)
                    <div class="group">
                        <div class="relative h-96 overflow-hidden rounded-2xl">
                            <img src="https://picsum.photos/600/800?grayscale&random={{ 650 + $i }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Look {{ $i+1 }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent"></div>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Outfit {{ $i+1 }}</div>
                                <div class="font-semibold text-gray-900">Colección SS25</div>
                            </div>
                            <a href="#" class="text-sm font-medium text-gray-700 hover:text-black">Comprar el look →</a>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- Destacados -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">Destacados</h3>
                    <p class="text-gray-600">Selección cápsula de la temporada</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @for($i = 0; $i < 3; $i++)
                    <article class="group">
                        <div class="relative h-[420px] overflow-hidden rounded-2xl bg-gray-100">
                            <img src="https://picsum.photos/800/1000?grayscale&random={{ 700 + $i }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700" alt="Producto {{ $i+1 }}">
                        </div>
                        <div class="flex items-start justify-between mt-4">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Essential {{ $i+1 }}</h4>
                                <p class="text-sm text-gray-500">SS25</p>
                            </div>
                            <div class="text-right text-base font-semibold text-gray-900">${{ number_format(180000 + $i*20000, 0, ',', '.') }} COP</div>
                        </div>
                    </article>
                    @endfor
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-minimalista.partials.footer')
    </main>
</body>
</html>


