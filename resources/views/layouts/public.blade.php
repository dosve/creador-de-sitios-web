<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sitio Web')</title>
    
    <!-- Meta tags SEO -->
    <meta name="description" content="@yield('description', 'Descripción del sitio web')">
    <meta name="keywords" content="@yield('keywords', '')">
    <meta name="author" content="{{ $website->name ?? 'Sitio Web' }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Sitio Web')">
    <meta property="og:description" content="@yield('description', 'Descripción del sitio web')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Sitio Web')">
    <meta name="twitter:description" content="@yield('description', 'Descripción del sitio web')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .prose {
            color: #374151;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #111827;
            font-weight: 600;
        }
        .prose h1 {
            font-size: 2.25rem;
            margin-bottom: 1rem;
        }
        .prose h2 {
            font-size: 1.875rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .prose h3 {
            font-size: 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .prose p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose blockquote {
            border-left: 4px solid #3B82F6;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6B7280;
        }
        .prose a {
            color: #3B82F6;
            text-decoration: underline;
        }
        .prose a:hover {
            color: #1D4ED8;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .prose th, .prose td {
            border: 1px solid #E5E7EB;
            padding: 0.75rem;
            text-align: left;
        }
        .prose th {
            background-color: #F9FAFB;
            font-weight: 600;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Header del sitio -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="{{ route('website.show', $website->slug ?? 'sitio') }}" class="text-2xl font-bold text-gray-900">
                        {{ $website->name ?? 'Mi Sitio Web' }}
                    </a>
                </div>
                
                <!-- Navegación -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('website.show', $website->slug ?? 'sitio') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Inicio
                    </a>
                    <a href="{{ route('website.blog.index', $website->slug ?? 'sitio') }}" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Blog
                    </a>
                    <a href="#contacto" 
                       class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Contacto
                    </a>
                </nav>
                
                <!-- Menú móvil -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ $website->name ?? 'Mi Sitio Web' }}</h3>
                    <p class="text-gray-400">{{ $website->description ?? 'Descripción del sitio web' }}</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('website.show', $website->slug ?? 'sitio') }}" class="text-gray-400 hover:text-white">Inicio</a></li>
                        <li><a href="{{ route('website.blog.index', $website->slug ?? 'sitio') }}" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="#contacto" class="text-gray-400 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <p class="text-gray-400">© {{ date('Y') }} {{ $website->name ?? 'Mi Sitio Web' }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
