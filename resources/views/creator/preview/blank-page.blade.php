<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} - {{ $website->name }}</title>
    <meta name="description" content="{{ $page->excerpt ?? $website->description ?? '' }}">
    
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
    <!-- Header de Vista Previa (solo en modo preview) -->
    <div class="bg-yellow-100 border-b border-yellow-200 px-4 py-2">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-800">Vista Previa del Sitio Web</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-yellow-700">{{ $page->title }} - {{ $website->name }}</span>
                <a href="{{ route('creator.dashboard') }}" 
                   class="inline-flex items-center px-3 py-1 border border-yellow-300 rounded-md text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Panel
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido Principal - Solo el contenido del editor visual -->
    <main class="min-h-screen">
        @if($page->html_content)
            <!-- Contenido HTML de la Página -->
            <div class="page-content">
                {!! $page->html_content !!}
            </div>
        @else
            <!-- Mensaje cuando no hay contenido -->
            <div class="flex items-center justify-center min-h-screen bg-gray-50">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Contenido no disponible</h3>
                    <p class="text-gray-600">Esta página aún no tiene contenido. Edita la página para agregar contenido.</p>
                </div>
            </div>
        @endif

        <!-- CSS personalizado de la página -->
        @if($page->css_content)
            <style>
                {!! $page->css_content !!}
            </style>
        @endif
    </main>

    @yield('scripts')
    
    <!-- Script para cargar productos reales en la vista previa -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Vista previa cargada, buscando productos...');
            
            // Función para cargar productos reales
            function loadRealProductsInPreview() {
                console.log('🚀 Iniciando carga de productos en vista previa...');
                
                // Buscar contenedores de productos de múltiples formas
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
                
                // Si aún no encuentra, buscar cualquier grid que contenga productos de ejemplo
                if (productsContainers.length === 0) {
                    const allGrids = document.querySelectorAll('.grid');
                    productsContainers = Array.from(allGrids).filter(grid => 
                        grid.innerHTML.includes('Producto de Ejemplo') || 
                        grid.innerHTML.includes('products-container')
                    );
                    console.log('📦 Contenedores por contenido encontrados:', productsContainers.length);
                }
                
                if (productsContainers.length === 0) {
                    console.log('❌ No se encontraron contenedores de productos en la vista previa');
                    return;
                }
                
                console.log('✅ Cargando productos reales en la vista previa...');
                
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

                    // Hacer petición a la API
                    const apiUrl = '{{ route("creator.store.products", $website) }}?per_page=6';
                    console.log('🔍 Haciendo petición a:', apiUrl);
                    
                    fetch(apiUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('📡 Respuesta recibida:', response.status, response.statusText);
                        return response.json();
                    })
                    .then(data => {
                        console.log('📦 Datos recibidos:', data);
                        console.log('✅ Success:', data.success);
                        console.log('📋 Products:', data.products);
                        console.log('🔢 Products count:', data.products ? data.products.length : 0);
                        
                        if (data.success && data.products && data.products.length > 0) {
                            console.log('✅ Renderizando productos reales...');
                            renderRealProducts(container, data.products);
                        } else {
                            console.log('❌ No hay productos o error en la respuesta');
                            showNoProductsMessage(container);
                        }
                    })
                    .catch(error => {
                        console.error('💥 Error al cargar productos:', error);
                        showErrorLoadingProducts(container);
                    });
                });
            }

            // Función para renderizar productos reales
            function renderRealProducts(container, products) {
                const productsHtml = products.map(product => {
                    const isExternal = product.producto !== undefined;
                    const title = isExternal ? product.producto : product.title;
                    const description = isExternal ? product.descripcion : product.content;
                    const price = isExternal ? product.precio : product.price;
                    const image = isExternal ? product.img : (product.featured_image ? `/storage/${product.featured_image}` : null);
                    const category = isExternal ? product.categoria : product.category;
                    
                    return `
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            ${image ? 
                                `<div class="mb-4 aspect-w-16 aspect-h-9">
                                    <img src="${image}" alt="${title}" class="object-cover w-full h-48 rounded-lg">
                                </div>` :
                                `<div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>`
                            }
                            <h3 class="mb-2 text-lg font-semibold text-gray-900">${title}</h3>
                            ${category ? 
                                `<span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">${isExternal ? category.categoria : category.name}</span>` : ''
                            }
                            <p class="mb-4 text-sm text-gray-600 line-clamp-2">${description ? (isExternal ? description : description.replace(/<[^>]*>/g, '')) : 'Sin descripción'}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-green-600">$${price || '0.00'}</span>
                                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                    Ver Producto
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');

                // Agregar el botón "Ver más" después de los productos
                const seeMoreButton = `
                    <div class="mt-12 text-center col-span-full">
                        <a href="{{ route('creator.store.products', $website) }}" class="inline-flex items-center px-8 py-3 text-base font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Ver más productos
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                `;

                container.innerHTML = productsHtml + seeMoreButton;
            }

            // Función para mostrar mensaje cuando no hay productos
            function showNoProductsMessage(container) {
                container.innerHTML = `
                    <div class="py-12 text-center col-span-full">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">No hay productos disponibles</h3>
                        <p class="text-gray-600">Los productos aparecerán aquí cuando estén disponibles.</p>
                    </div>
                `;
            }

            // Función para mostrar error al cargar productos
            function showErrorLoadingProducts(container) {
                container.innerHTML = `
                    <div class="py-12 text-center col-span-full">
                        <svg class="w-12 h-12 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">Error al cargar productos</h3>
                        <p class="text-gray-600">No se pudieron cargar los productos. Verifica la configuración de la API.</p>
                    </div>
                `;
            }

            // Cargar productos después de un breve delay
            setTimeout(() => {
                loadRealProductsInPreview();
            }, 500);
        });
    </script>
</body>
</html>
