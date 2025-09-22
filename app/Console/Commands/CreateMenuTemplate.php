<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;

class CreateMenuTemplate extends Command
{
    protected $signature = 'template:create-menu';
    protected $description = 'Crear una nueva plantilla con menús dinámicos';

    public function handle()
    {
        $this->info('Creando nueva plantilla con menús dinámicos...');
        
        $template = Template::updateOrCreate(
            ['name' => 'Plantilla con Menús'],
            [
                'description' => 'Plantilla moderna con menús dinámicos',
                'category' => 'modern',
                'preview_images' => ['/images/templates/menu-template.jpg'],
                'html_content' => $this->getMenuTemplateHTML(),
                'css_content' => $this->getMenuTemplateCSS(),
                'blocks' => ['header', 'footer', 'content', 'navigation'],
                'is_premium' => false,
                'is_active' => true,
            ]
        );
        
        $this->info("✅ Plantilla creada: {$template->name} (ID: {$template->id})");
        return 0;
    }
    
    private function getMenuTemplateHTML()
    {
        return '<!DOCTYPE html>
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
        body { font-family: \'Inter\', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b shadow-sm">
        <div class="container px-4 py-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-globe text-white text-lg"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $website->name ?? "Mi Sitio Web" }}</h1>
                    </div>
                    
                    <!-- Menú de Navegación -->
                    <nav class="hidden space-x-6 md:flex">
                        @if($website->menus()->where("location", "header")->exists())
                            @foreach($website->menus()->where("location", "header")->first()->activeItems as $item)
                                <a href="{{ $item->final_url }}" 
                                   target="{{ $item->target }}"
                                   class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                    @if($item->icon){{ $item->icon }} @endif
                                    {{ $item->title }}
                                </a>
                            @endforeach
                        @else
                            <!-- Menú por defecto -->
                            <a href="/" class="text-gray-600 hover:text-gray-900">Inicio</a>
                            <a href="/productos" class="text-gray-600 hover:text-gray-900">Productos</a>
                            <a href="/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>
                        @endif
                    </nav>
                </div>
                
                <!-- Botón móvil -->
                <button class="md:hidden p-2 text-gray-600 hover:text-gray-900" onclick="toggleMobileMenu()">
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
                               class="text-gray-600 hover:text-gray-900 transition-colors duration-200 py-2">
                                @if($item->icon){{ $item->icon }} @endif
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @else
                        <a href="/" class="text-gray-600 hover:text-gray-900 py-2">Inicio</a>
                        <a href="/productos" class="text-gray-600 hover:text-gray-900 py-2">Productos</a>
                        <a href="/contacto" class="text-gray-600 hover:text-gray-900 py-2">Contacto</a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="min-h-screen">
        @if($homePage && $homePage->html_content)
            <div class="container mx-auto px-4 py-8">
                <div class="prose max-w-none">
                    {!! $homePage->html_content !!}
                </div>
            </div>
        @else
            <!-- Contenido por defecto -->
            <section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="container px-4 mx-auto text-center">
                    <h2 class="mb-4 text-4xl font-bold">Bienvenido a tu sitio web</h2>
                    <p class="mb-8 text-xl">Crea contenido increíble y compártelo con el mundo</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/productos" class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">
                            Ver Productos
                        </a>
                        <a href="/contacto" class="px-8 py-3 font-semibold text-white transition-colors border-2 border-white rounded-lg hover:bg-white hover:text-blue-600">
                            Contactar
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>

    <!-- Footer -->
    <footer class="py-12 text-white bg-gray-900">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Información del sitio -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-globe text-white"></i>
                        </div>
                        <h5 class="text-xl font-semibold">{{ $website->name ?? "Mi Sitio Web" }}</h5>
                    </div>
                    <p class="text-gray-400">{{ $website->description ?? "Descripción de mi sitio web" }}</p>
                </div>
                
                <!-- Enlaces rápidos -->
                <div>
                    <h5 class="mb-4 text-xl font-semibold">Enlaces Rápidos</h5>
                    <ul class="space-y-2">
                        @if($website->menus()->where("location", "footer")->exists())
                            @foreach($website->menus()->where("location", "footer")->first()->activeItems as $item)
                                <li>
                                    <a href="{{ $item->final_url }}" 
                                       target="{{ $item->target }}"
                                       class="text-gray-400 hover:text-white transition-colors duration-200">
                                        @if($item->icon){{ $item->icon }} @endif
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li><a href="/productos" class="text-gray-400 hover:text-white">Productos</a></li>
                            <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>
                        @endif
                    </ul>
                </div>
                
                <!-- Información de contacto -->
                <div>
                    <h5 class="mb-4 text-xl font-semibold">Contacto</h5>
                    <div class="space-y-2 text-gray-400">
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
        window.websiteApiKey = "{{ $website->api_key }}";
        window.websiteApiUrl = "{{ $website->api_base_url }}";
        window.epaycoPublicKey = "{{ $website->epayco_public_key }}";
        window.epaycoPrivateKey = "{{ $website->epayco_private_key }}";
        window.epaycoCustomerId = "{{ $website->epayco_customer_id }}";
    </script>
</body>
</html>';
    }
    
    private function getMenuTemplateCSS()
    {
        return '/* Estilos para la plantilla con menús */
body {
    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: #374151;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Tipografía */
h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

/* Enlaces */
a {
    color: #2563eb;
    text-decoration: none;
    transition: color 0.2s ease;
}

a:hover {
    color: #1d4ed8;
}

/* Transiciones */
.transition-colors {
    transition: color 0.2s ease, background-color 0.2s ease;
}

/* Prose para contenido */
.prose {
    max-width: none;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose p {
    margin-bottom: 1.5rem;
}';
    }
}