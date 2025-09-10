<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $website->name ?? 'Vista Previa')</title>
    <meta name="description" content="@yield('description', $website->description ?? '')">
    
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
    <!-- Header de Vista Previa -->
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
                <span class="text-sm text-yellow-700">{{ $website->name ?? 'Mi Sitio Web' }}</span>
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

    <!-- Navegación del Sitio Web -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('creator.preview.index', $website) }}" class="text-xl font-bold text-gray-900">
                        {{ $website->name ?? 'Mi Sitio Web' }}
                    </a>
                </div>

                <!-- Menú de Navegación -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('creator.preview.index', $website) }}" 
                           class="text-gray-900 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('creator.preview.index') ? 'bg-gray-100' : '' }}">
                            Inicio
                        </a>
                        
                        @if(isset($pages) && $pages->count() > 0)
                            @foreach($pages->where('is_home', false) as $page)
                                <a href="{{ route('creator.preview.page', [$website, $page]) }}" 
                                   class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('creator.preview.page') && request()->route('page')->id === $page->id ? 'bg-gray-100' : '' }}">
                                    {{ $page->title }}
                                </a>
                            @endforeach
                        @endif
                        
                        <a href="{{ route('creator.preview.blog', $website) }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('creator.preview.blog*') ? 'bg-gray-100' : '' }}">
                            Blog
                        </a>
                        
                        <a href="{{ route('creator.preview.contact', $website) }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('creator.preview.contact') ? 'bg-gray-100' : '' }}">
                            Contacto
                        </a>
                    </div>
                </div>

                <!-- Botón móvil -->
                <div class="md:hidden">
                    <button type="button" class="bg-gray-50 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div class="md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <a href="{{ route('creator.preview.index', $website) }}" 
                   class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('creator.preview.index') ? 'bg-gray-100' : '' }}">
                    Inicio
                </a>
                
                @if(isset($pages) && $pages->count() > 0)
                    @foreach($pages->where('is_home', false) as $page)
                        <a href="{{ route('creator.preview.page', [$website, $page]) }}" 
                           class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('creator.preview.page') && request()->route('page')->id === $page->id ? 'bg-gray-100' : '' }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif
                
                <a href="{{ route('creator.preview.blog', $website) }}" 
                   class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('creator.preview.blog*') ? 'bg-gray-100' : '' }}">
                    Blog
                </a>
                
                <a href="{{ route('creator.preview.contact', $website) }}" 
                   class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('creator.preview.contact') ? 'bg-gray-100' : '' }}">
                    Contacto
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ $website->name ?? 'Mi Sitio Web' }}</h3>
                    <p class="text-gray-300 text-sm">{{ $website->description ?? 'Descripción de tu sitio web' }}</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('creator.preview.index', $website) }}" class="text-gray-300 hover:text-white">Inicio</a></li>
                        <li><a href="{{ route('creator.preview.blog', $website) }}" class="text-gray-300 hover:text-white">Blog</a></li>
                        <li><a href="{{ route('creator.preview.contact', $website) }}" class="text-gray-300 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Información</h4>
                    <p class="text-gray-300 text-sm">Este es un sitio web creado con nuestro constructor de sitios web.</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ $website->name ?? 'Mi Sitio Web' }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
