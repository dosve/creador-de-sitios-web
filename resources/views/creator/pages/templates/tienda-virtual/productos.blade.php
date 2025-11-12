<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - {{ $websiteName }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-virtual.partials.header', [
            'image' => 'https://picsum.photos/1920/900?random=888',
            'title' => 'Productos',
            'subtitle' => 'Catálogo completo con filtros y ofertas.',
            'badge' => 'CATÁLOGO',
            'cta' => ['primary' => 'Ver Más', 'secondary' => 'Contactar']
        ])

        <!-- Grid de productos clásico -->
        <section class="mt-10 pb-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @for($i = 1; $i <= 8; $i++)
                        @include('creator.pages.templates.tienda-virtual.partials.product-card', ['index' => $i])
                    @endfor
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-virtual.partials.footer')
    </main>
</body>
</html>
