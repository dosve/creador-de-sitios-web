<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }} - Vista Previa de Plantilla</title>
    <meta name="description" content="{{ $template->description ?? '' }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Header de Vista Previa de Plantilla -->
    <div class="px-4 py-2 bg-blue-100 border-b border-blue-200">
        <div class="flex items-center justify-between mx-auto max-w-7xl">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-medium text-blue-800">Vista Previa de Plantilla</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-blue-700">{{ $template->name }}</span>
                    @if($template->is_premium)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Premium
                        </span>
                    @endif
                </div>
                <a href="{{ route('creator.templates.index') }}" 
                   class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-700 bg-white border border-blue-300 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Plantillas
                </a>
            </div>
        </div>
    </div>

    <!-- Información de la plantilla -->
    <div class="px-4 py-3 bg-white border-b border-gray-200">
        <div class="mx-auto max-w-7xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h1>
                    @if($template->description)
                        <p class="mt-1 text-sm text-gray-600">{{ $template->description }}</p>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                        {{ ucfirst($template->category) }}
                    </span>
                    <a href="{{ route('creator.templates.show', $template) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Usar esta plantilla
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal - Solo el contenido de la plantilla -->
    <main class="min-h-screen">
        @if($template->html_content)
            <!-- Contenido HTML de la Plantilla -->
            <div class="template-content">
                {!! $template->html_content !!}
            </div>
        @else
            <!-- Mensaje cuando no hay contenido -->
            <div class="flex items-center justify-center min-h-screen bg-gray-50">
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Contenido no disponible</h3>
                    <p class="text-gray-600">Esta plantilla aún no tiene contenido.</p>
                </div>
            </div>
        @endif

        <!-- CSS personalizado de la plantilla -->
        @if($template->css_content)
            <style>
                {!! $template->css_content !!}
            </style>
        @endif
    </main>

    @yield('scripts')
    
    <!-- Script para cargar productos reales en la vista previa de plantilla -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Vista previa de plantilla cargada, buscando productos...');
            
            // Función para cargar productos reales
            function loadRealProductsInPreview() {
                console.log('🚀 Iniciando carga de productos en vista previa de plantilla...');
                
                // Buscar contenedores de productos
                let productsContainers = document.querySelectorAll('#products-container');
                console.log('📦 Contenedores por ID encontrados:', productsContainers.length);
                
                // Si no encuentra por ID, buscar por atributo data
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll('[data-dynamic-products="true"] .grid');
                    console.log('📦 Contenedores por atributo data encontrados:', productsContainers.length);
                }
                
                // Si aún no encuentra, buscar por clase
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll('.products-list .grid');
                    console.log('📦 Contenedores por clase .products-list .grid:', productsContainers.length);
                }
                
                if (productsContainers.length === 0) {
                    console.log('❌ No se encontraron contenedores de productos');
                    return;
                }
                
                console.log('✅ Cargando productos reales en la vista previa de plantilla...');
                
                productsContainers.forEach((container, index) => {
                    console.log(`🔄 Procesando contenedor ${index + 1}`);
                    
                    // Mostrar loading
                    container.innerHTML = `
                        <div class="flex items-center justify-center py-12 col-span-full">
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                                <p class="text-gray-600">Cargando productos...</p>
                            </div>
                        </div>
                    `;

                    // Para la vista previa de plantilla, mostrar productos de ejemplo mejorados
                    setTimeout(() => {
                        showEnhancedExampleProducts(container);
                    }, 1000);
                });
            }

            // Función para mostrar productos de ejemplo mejorados
            function showEnhancedExampleProducts(container) {
                const exampleProducts = [
                    {
                        title: "Producto Premium 1",
                        description: "Este es un producto de ejemplo que se mostrará en la vista previa de la plantilla.",
                        price: "99.99",
                        category: "Categoría A"
                    },
                    {
                        title: "Producto Premium 2", 
                        description: "Los productos reales se cargarán automáticamente cuando uses esta plantilla en tu sitio.",
                        price: "149.99",
                        category: "Categoría B"
                    },
                    {
                        title: "Producto Premium 3",
                        description: "La funcionalidad de carrito de compras está completamente integrada.",
                        price: "199.99",
                        category: "Categoría C"
                    }
                ];

                const productsHtml = exampleProducts.map(product => `
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">${product.title}</h3>
                        <span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">${product.category}</span>
                        <p class="mb-4 text-sm text-gray-600">${product.description}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">$${product.price}</span>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Ver Producto
                            </button>
                        </div>
                    </div>
                `).join('');

                // Agregar el botón "Ver más" después de los productos

                container.innerHTML = productsHtml;
            }
            
            // Cargar productos después de un breve delay
            setTimeout(() => {
                loadRealProductsInPreview();
            }, 500);
        });
    </script>
</body>
</html>
