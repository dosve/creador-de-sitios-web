<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - {{ $websiteName }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <main class="min-h-screen">
        <!-- Header reutilizable -->
        @include('creator.pages.templates.tienda-minimalista.partials.header', [
            'badge' => 'SPRING/SUMMER 2025',
            'title' => 'Productos',
            'subtitle' => 'Catálogo con diseño minimalista: esenciales de temporada en paleta neutra.',
            'image' => 'https://picsum.photos/1600/600?grayscale&random=801'
        ])

        <!-- Chips de categorías -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-wrap gap-2">
                    @foreach(['Mujer','Hombre','Accesorios','Calzado','Bolsos'] as $i => $chip)
                        <button class="px-4 py-2 rounded-full text-sm {{ $i===0 ? 'bg-black text-white' : 'border border-gray-300 text-gray-800 hover:bg-gray-50' }}">{{ $chip }}</button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Grid editorial asimétrico -->
        <section class="pb-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @for($i = 0; $i < 6; $i++)
                    <article class="group">
                        <div class="relative overflow-hidden rounded-2xl {{ $i % 3 === 0 ? 'h-[520px]' : 'h-[420px]' }} bg-gray-100">
                            <img src="https://picsum.photos/800/1000?grayscale&random={{ 700 + $i }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700 ease-out" alt="Producto {{ $i+1 }}">
                        </div>
                        <div class="flex items-start justify-between mt-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Essential {{ $i+1 }}</h3>
                                <p class="text-sm text-gray-500">Colección SS25</p>
                            </div>
                            <div class="text-right">
                                <div class="text-base font-semibold text-gray-900">${{ 120 + $i*15 }}</div>
                            </div>
                        </div>
                    </article>
                    @endfor
                </div>

                <div class="mt-12">
                    <a href="#" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-full text-sm font-semibold text-gray-800 hover:bg-gray-50">Ver toda la colección <span class="text-gray-400">→</span></a>
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-minimalista.partials.footer')
    </main>
</body>
</html>
