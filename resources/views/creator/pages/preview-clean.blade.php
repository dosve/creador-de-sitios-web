<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - {{ $websiteName }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header de la vista previa -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-{{ $categoryIcon }} text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $pageTitle }}</h1>
                        <p class="text-sm text-gray-600">{{ $categoryName }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-{{ $pageType === 'common' ? 'star' : 'puzzle-piece' }} mr-2"></i>
                            <span>{{ $pageType === 'common' ? 'Página Esencial' : 'Página Especializada' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Vista Previa</span>
                        </div>
                    </div>
                    <button onclick="window.close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <main class="min-h-screen">
        @foreach($pageBlocks as $block)
            @switch($block['type'])
                @case('hero-navigator')
                    @include('creator.pages.preview-blocks.hero-navigator', ['block' => $block])
                    @break
                @case('hero-minimalist-navigator')
                    @include('creator.pages.preview-blocks.hero-minimalist-navigator', ['block' => $block])
                    @break
                @case('features-navigator')
                    @include('creator.pages.preview-blocks.features-navigator', ['block' => $block])
                    @break
                @case('product-grid-navigator')
                    @include('creator.pages.preview-blocks.product-grid-navigator', ['block' => $block])
                    @break
                @case('product-grid-minimalist-navigator')
                    @include('creator.pages.preview-blocks.product-grid-minimalist-navigator', ['block' => $block])
                    @break
                @case('contact-form-navigator')
                    @include('creator.pages.preview-blocks.contact-form-navigator', ['block' => $block])
                    @break
                @case('testimonials-navigator')
                    @include('creator.pages.preview-blocks.testimonials-navigator', ['block' => $block])
                    @break
                @case('offers-navigator')
                    @include('creator.pages.preview-blocks.offers-navigator', ['block' => $block])
                    @break
                @case('collection-banner-navigator')
                    @include('creator.pages.preview-blocks.collection-banner-navigator', ['block' => $block])
                    @break
                @case('lookbook-navigator')
                    @include('creator.pages.preview-blocks.lookbook-navigator', ['block' => $block])
                    @break
                @case('category-grid-navigator')
                    @include('creator.pages.preview-blocks.category-grid-navigator', ['block' => $block])
                    @break
                @case('cart-navigator')
                    @include('creator.pages.preview-blocks.cart-navigator', ['block' => $block])
                    @break
                @default
                    @include('creator.pages.preview-blocks.default', ['block' => $block])
            @endswitch
        @endforeach
    </main>

    <!-- Footer de la vista previa -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-4 mb-4">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-{{ $categoryIcon }} text-white text-sm"></i>
                </div>
                <span class="text-lg font-semibold">{{ $websiteName }}</span>
            </div>
            <p class="text-gray-400 text-sm mb-4">{{ $pageDescription }}</p>
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-400">
                <span class="flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa
                </span>
                <span class="flex items-center">
                    <i class="fas fa-{{ $pageType === 'common' ? 'star' : 'puzzle-piece' }} mr-2"></i>
                    {{ $pageType === 'common' ? 'Esencial' : 'Especializada' }}
                </span>
                <span class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Ejemplo: {{ $pageExample }}
                </span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.close();
            }
        });
        
        // Prevenir scroll en el body cuando se abre el modal
        document.body.style.overflow = 'auto';
    </script>
</body>
</html>
