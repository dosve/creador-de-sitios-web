<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantillas - Creador de Sitios Web</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Plantillas</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ $templates->flatten()->count() }} plantillas disponibles</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Categories Filter -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2">
                    <a href="#all" class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium">
                        Todas
                    </a>
                    @foreach($categories as $key => $name)
                        <a href="#{{ $key }}" class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-50 border">
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Templates by Category -->
            @foreach($templates as $category => $categoryTemplates)
                <div id="{{ $category }}" class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $categories[$category] ?? ucfirst($category) }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($categoryTemplates as $template)
                            <div class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition-shadow">
                                <!-- Template Preview -->
                                <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 relative">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-2 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-600">Vista previa</p>
                                        </div>
                                    </div>
                                    @if($template->is_premium)
                                        <div class="absolute top-2 right-2">
                                            <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                                Premium
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Template Info -->
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $template->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-3">{{ $template->description }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('creator.templates.preview', $template) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Vista previa
                                            </a>
                                            <a href="{{ route('creator.templates.show', $template) }}" 
                                               class="text-gray-600 hover:text-gray-800 text-sm">
                                                Detalles
                                            </a>
                                        </div>
                                        @if($template->is_premium)
                                            <span class="text-xs text-yellow-600 font-medium">Premium</span>
                                        @else
                                            <span class="text-xs text-green-600 font-medium">Gratis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($templates->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay plantillas disponibles</h3>
                    <p class="mt-1 text-sm text-gray-500">Las plantillas aparecerán aquí cuando estén disponibles.</p>
                </div>
            @endif
        </main>
    </div>

    <script>
        // Smooth scroll para filtros de categorías
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
