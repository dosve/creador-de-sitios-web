<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Tienda Virtual</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <main class="min-h-screen">
        @include('creator.pages.templates.tienda-virtual.partials.header', [
            'image' => 'https://picsum.photos/1920/900?random=951',
            'title' => 'Bienvenido a Tienda Virtual',
            'subtitle' => 'Ofertas, envíos rápidos y soporte 24/7',
            'badge' => 'INICIO',
            'cta' => ['primary' => 'Ver Ofertas', 'secondary' => 'Contáctanos']
        ])

        <!-- Sección Destacados con card unificada -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Productos destacados</h2>
                    <p class="text-gray-600">Los más populares de la semana</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @for($i = 1; $i <= 8; $i++)
                        @include('creator.pages.templates.tienda-virtual.partials.product-card', ['index' => $i])
                    @endfor
                </div>
            </div>
        </section>

        <!-- Beneficios/por qué comprar aquí -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl border border-gray-100 bg-gray-50">
                    <div class="text-indigo-600 mb-2"><i class="fas fa-truck text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Envío rápido</h3>
                    <p class="text-sm text-gray-600">Despachos a todo el país en 24-48h.</p>
                </div>
                <div class="p-6 rounded-2xl border border-gray-100 bg-gray-50">
                    <div class="text-indigo-600 mb-2"><i class="fas fa-shield-alt text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Compra segura</h3>
                    <p class="text-sm text-gray-600">Pagos protegidos y datos cifrados.</p>
                </div>
                <div class="p-6 rounded-2xl border border-gray-100 bg-gray-50">
                    <div class="text-indigo-600 mb-2"><i class="fas fa-undo text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Devoluciones fáciles</h3>
                    <p class="text-sm text-gray-600">Tienes 30 días para cambiar o devolver.</p>
                </div>
            </div>
        </section>

        <!-- Sección Nuevos lanzamientos -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Nuevos lanzamientos</h2>
                    <p class="text-gray-600">Lo último en nuestro catálogo</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @for($i = 9; $i <= 12; $i++)
                        @include('creator.pages.templates.tienda-virtual.partials.product-card', ['index' => $i])
                    @endfor
                </div>
            </div>
        </section>

        @include('creator.pages.templates.tienda-virtual.partials.footer')
    </main>
</body>
</html>


