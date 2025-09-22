<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $homePage->title ?? $website->name ?? "Mi Sitio Web" }}</title>
    <meta name="description" content="{{ $homePage->meta_description ?? $website->description ?? "Descripción de mi sitio web" }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        {!! $template->css_content !!}
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header de Vista Previa (solo en modo preview) -->
    <div class="px-4 py-2 bg-yellow-100 border-b border-yellow-200">
        <div class="flex items-center justify-between mx-auto max-w-7xl">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-800">Vista Previa del Sitio Web</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-yellow-700">{{ $website->name ?? 'Mi Sitio Web' }}</span>
                <a href="{{ route('creator.dashboard') }}" 
                   class="inline-flex items-center px-3 py-1 text-sm font-medium text-yellow-700 bg-white border border-yellow-300 rounded-md hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Panel
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-globe text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $website->name ?? "Mi Sitio Web" }}</h1>
                </div>
                
                <!-- Menú de Navegación -->
                <nav class="hidden md:flex space-x-6">
                    @if($website->menus()->where("location", "header")->exists())
                        @foreach($website->menus()->where("location", "header")->first()->activeItems as $item)
                            <a href="{{ $item->final_url }}" 
                               target="{{ $item->target }}"
                               class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                @if($item->icon){{ $item->icon }} @endif
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @else
                        <!-- Menú por defecto -->
                        <a href="/" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Inicio</a>
                        <a href="/productos" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Productos</a>
                        <a href="/contacto" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Contacto</a>
                    @endif
                </nav>
                
                <!-- Botón móvil -->
                <button class="md:hidden p-2 text-gray-600 hover:text-blue-600" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Menú móvil -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-200">
                <nav class="flex flex-col space-y-2 mt-4">
                    @if($website->menus()->where("location", "header")->exists())
                        @foreach($website->menus()->where("location", "header")->first()->activeItems as $item)
                            <a href="{{ $item->final_url }}" 
                               target="{{ $item->target }}"
                               class="text-gray-600 hover:text-blue-600 transition-colors duration-200 py-2">
                                @if($item->icon){{ $item->icon }} @endif
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @else
                        <a href="/" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 py-2">Inicio</a>
                        <a href="/productos" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 py-2">Productos</a>
                        <a href="/contacto" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 py-2">Contacto</a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            @if($homePage && $homePage->html_content)
                <div class="prose max-w-none">
                    {!! $homePage->html_content !!}
                </div>
            @else
                <!-- Contenido por defecto -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-edit text-blue-600 text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Bienvenido a tu sitio web</h2>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Esta es tu página de inicio. Puedes editar este contenido desde el panel de administración.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/productos" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Ver Productos
                        </a>
                        <a href="/contacto" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            Contactar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Información del sitio -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-globe text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold">{{ $website->name ?? "Mi Sitio Web" }}</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        {{ $website->description ?? "Descripción de mi sitio web" }}
                    </p>
                </div>
                
                <!-- Enlaces rápidos -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                    <nav class="space-y-2">
                        @if($website->menus()->where("location", "footer")->exists())
                            @foreach($website->menus()->where("location", "footer")->first()->activeItems as $item)
                                <a href="{{ $item->final_url }}" 
                                   target="{{ $item->target }}"
                                   class="block text-gray-300 hover:text-white transition-colors duration-200">
                                    @if($item->icon){{ $item->icon }} @endif
                                    {{ $item->title }}
                                </a>
                            @endforeach
                        @else
                            <a href="/" class="block text-gray-300 hover:text-white transition-colors duration-200">Inicio</a>
                            <a href="/productos" class="block text-gray-300 hover:text-white transition-colors duration-200">Productos</a>
                            <a href="/contacto" class="block text-gray-300 hover:text-white transition-colors duration-200">Contacto</a>
                        @endif
                    </nav>
                </div>
                
                <!-- Información de contacto -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p><i class="fas fa-envelope mr-2"></i> contacto@misitio.com</p>
                        <p><i class="fas fa-phone mr-2"></i> +1 (555) 123-4567</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Ciudad, País</p>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date("Y") }} {{ $website->name ?? "Mi Sitio Web" }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
        }
    </script>
    
    <!-- Configuración de credenciales API y Epayco -->
    <script>
        // Configurar las credenciales API del sitio web
        window.websiteApiKey = "{{ $website->api_key }}";
        window.websiteApiUrl = "{{ $website->api_base_url }}";
        
        // Configurar las credenciales de ePayco
        window.epaycoPublicKey = "{{ $website->epayco_public_key }}";
        window.epaycoPrivateKey = "{{ $website->epayco_private_key }}";
        window.epaycoCustomerId = "{{ $website->epayco_customer_id }}";
        
        console.log('🔧 Configuración de API cargada:', {
            apiKey: window.websiteApiKey ? 'Configurada' : 'No configurada',
            apiUrl: window.websiteApiUrl || 'No configurada',
            epaycoPublicKey: window.epaycoPublicKey ? 'Configurada' : 'No configurada',
            epaycoCustomerId: window.epaycoCustomerId ? 'Configurado' : 'No configurado'
        });
    </script>
</body>
</html>
