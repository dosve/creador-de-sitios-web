<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class DefaultTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear plantilla básica por defecto
        Template::updateOrCreate(
            ['name' => 'Plantilla Básica'],
            [
                'description' => 'Plantilla básica por defecto con estilos limpios y responsivos',
                'category' => 'basic',
                'preview_images' => ['/images/templates/basic-template.jpg'],
                'html_content' => $this->getBasicTemplate(),
                'css_content' => $this->getBasicCSS(),
                'blocks' => ['header', 'footer', 'content'],
                'is_premium' => false,
                'is_active' => true,
            ]
        );
    }

    private function getBasicTemplate()
    {
        return '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? $website->name ?? "Mi Sitio Web" }}</title>
    <meta name="description" content="{{ $page->meta_description ?? $website->description ?? "Descripción de mi sitio web" }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
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
                    @php
                        $headerMenu = $website->menus()->where("location", "header")->where("is_active", true)->first();
                    @endphp
                    @if($headerMenu && $headerMenu->activeItems()->count() > 0)
                        @foreach($headerMenu->activeItems as $item)
                            <a href="{{ $item->final_url }}" 
                               target="{{ $item->target }}"
                               class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
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
                    @if($headerMenu && $headerMenu->activeItems()->count() > 0)
                        @foreach($headerMenu->activeItems as $item)
                            <a href="{{ $item->final_url }}" 
                               target="{{ $item->target }}"
                               class="text-gray-600 hover:text-blue-600 transition-colors duration-200 py-2">
                                @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
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
            @if($page && $page->html_content)
                <div class="prose max-w-none">
                    {!! $page->html_content !!}
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
                        @php
                            $footerMenu = $website->menus()->where("location", "footer")->where("is_active", true)->first();
                        @endphp
                        @if($footerMenu && $footerMenu->activeItems()->count() > 0)
                            @foreach($footerMenu->activeItems as $item)
                                <a href="{{ $item->final_url }}" 
                                   target="{{ $item->target }}"
                                   class="block text-gray-300 hover:text-white transition-colors duration-200">
                                    @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
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
</body>
</html>';
    }

    private function getBasicCSS()
    {
        return '/* Estilos básicos para la plantilla */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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

h1 { font-size: 2.25rem; }
h2 { font-size: 1.875rem; }
h3 { font-size: 1.5rem; }
h4 { font-size: 1.25rem; }
h5 { font-size: 1.125rem; }
h6 { font-size: 1rem; }

p {
    margin-bottom: 1rem;
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

/* Botones */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-align: center;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: #2563eb;
    color: white;
}

.btn-primary:hover {
    background-color: #1d4ed8;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

/* Grid */
.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

/* Flexbox */
.flex { display: flex; }
.flex-col { flex-direction: column; }
.items-center { align-items: center; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.space-x-3 > * + * { margin-left: 0.75rem; }
.space-x-6 > * + * { margin-left: 1.5rem; }
.space-y-2 > * + * { margin-top: 0.5rem; }
.space-y-4 > * + * { margin-top: 1rem; }

/* Espaciado */
.p-4 { padding: 1rem; }
.p-6 { padding: 1.5rem; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.mt-4 { margin-top: 1rem; }
.mt-8 { margin-top: 2rem; }

/* Colores */
.bg-white { background-color: white; }
.bg-gray-50 { background-color: #f9fafb; }
.bg-gray-100 { background-color: #f3f4f6; }
.bg-gray-800 { background-color: #1f2937; }
.bg-blue-600 { background-color: #2563eb; }
.text-white { color: white; }
.text-gray-600 { color: #4b5563; }
.text-gray-900 { color: #111827; }

/* Bordes */
.border { border: 1px solid #e5e7eb; }
.border-b { border-bottom: 1px solid #e5e7eb; }
.border-gray-200 { border-color: #e5e7eb; }
.rounded-lg { border-radius: 0.5rem; }

/* Sombras */
.shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

/* Responsive */
@media (min-width: 768px) {
    .md\\:flex { display: flex; }
    .md\\:hidden { display: none; }
    .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}

@media (min-width: 640px) {
    .sm\\:flex-row { flex-direction: row; }
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
}

.prose ul, .prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}';
    }
}
