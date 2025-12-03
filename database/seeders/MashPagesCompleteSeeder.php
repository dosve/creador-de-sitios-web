<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class MashPagesCompleteSeeder extends Seeder
{
    /**
     * Crear páginas estilo MASH COMPLETAS con todo el JavaScript funcional
     */
    public function run(): void
    {
        // Obtener todos los sitios web
        $websites = Website::all();
        
        if ($websites->isEmpty()) {
            $this->command->error('❌ No hay sitios web disponibles.');
            return;
        }
        
        // Mostrar lista de sitios web
        $this->command->info('📋 Sitios web disponibles:');
        $this->command->newLine();
        
        foreach ($websites as $index => $site) {
            $this->command->line(sprintf(
                '  %d. %s (slug: %s, ID: %d)',
                $index + 1,
                $site->name,
                $site->slug,
                $site->id
            ));
        }
        
        $this->command->newLine();
        
        // Preguntar cuál sitio usar
        $choice = $this->command->ask('¿Para cuál sitio crear las páginas? (número o slug)');
        
        // Buscar el sitio web seleccionado
        if (is_numeric($choice)) {
            // Si es número, usar como índice
            $index = (int)$choice - 1;
            $website = $websites->get($index);
        } else {
            // Si no, buscar por slug
            $website = $websites->firstWhere('slug', $choice);
        }
        
        if (!$website) {
            $this->command->error('❌ Sitio web no encontrado.');
            return;
        }
        
        // Confirmar la selección
        $this->command->newLine();
        $this->command->warn('⚠️  ATENCIÓN: Esto sobrescribirá las páginas existentes de este sitio.');
        $this->command->line('   Sitio seleccionado: ' . $website->name . ' (' . $website->slug . ')');
        
        if (!$this->command->confirm('¿Deseas continuar?', true)) {
            $this->command->info('❌ Operación cancelada.');
            return;
        }
        
        $this->command->newLine();
        $this->command->info('🚀 Creando páginas MASH completas para: ' . $website->name);

        // Página de Inicio
        $this->createPage($website, [
            'title' => 'Inicio',
            'slug' => 'inicio',
            'is_home' => true,
            'enable_store' => true,
            'html_content' => $this->getHomePageHTML(),
        ]);

        // Página de Tienda  
        $this->createPage($website, [
            'title' => 'Tienda',
            'slug' => 'tienda',
            'is_home' => false,
            'enable_store' => true,
            'html_content' => $this->getShopPageHTML(),
        ]);

        // Página Quiénes Somos
        $this->createPage($website, [
            'title' => 'Quiénes Somos',
            'slug' => 'quienes-somos',
            'is_home' => false,
            'enable_store' => false,
            'html_content' => $this->getAboutPageHTML(),
        ]);

        $this->command->info('✅ Páginas MASH creadas exitosamente!');
    }

    private function createPage($website, $data)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => $data['slug']],
            [
                'title' => $data['title'],
                'meta_description' => $data['meta_description'] ?? 'Página ' . $data['title'],
                'is_published' => true,
                'is_home' => $data['is_home'],
                'enable_store' => $data['enable_store'],
                'sort_order' => $data['sort_order'] ?? 1,
                'html_content' => $data['html_content'],
                'css_content' => $this->getGlobalCSS(),
            ]
        );

        $this->command->info("✓ {$data['title']} (ID: {$page->id})");
    }

    private function getHomePageHTML()
    {
        // Basado en el TemplateSeeder que SÍ funciona
        return $this->getHeader() . '
        
<!-- Hero Banner -->
<section class="relative bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="relative bg-cover bg-center rounded-lg overflow-hidden" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(\'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200\'); min-height: 400px;">
            <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-lg font-bold text-sm">NEW</div>
            <div class="flex items-center justify-center h-full py-16">
                <h2 class="text-white text-6xl font-bold tracking-widest">GOORIN BROS.</h2>
            </div>
        </div>
    </div>
</section>

<!-- Brands Carousel -->
<section class="bg-white py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center space-x-6 overflow-x-auto">
            <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-xl">ADIDAS</span>
            </div>
            <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-center text-sm">GOORIN<br>BROS</span>
            </div>
            <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-center text-xs">BASS PRO<br>SHOPS</span>
            </div>
            <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-xl">NEW ERA</span>
            </div>
        </div>
    </div>
</section>

<!-- Campaigns -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-900">CAMPAÑAS</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative bg-gray-800 rounded-lg overflow-hidden h-80">
                <img src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=600" alt="Gorras" class="w-full h-full object-cover opacity-70">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-6">
                    <h3 class="text-3xl font-bold mb-4">COLECCIÓN URBANA</h3>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">Ver más...</button>
                </div>
            </div>
            <div class="relative bg-gray-800 rounded-lg overflow-hidden h-80">
                <img src="https://images.unsplash.com/photo-1529958030586-3aae4ca485ff?w=600" alt="Agropecuario" class="w-full h-full object-cover opacity-70">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-6">
                    <h3 class="text-3xl font-bold mb-2">El mejor lugar</h3>
                    <h4 class="text-2xl font-bold mb-4">AGROPECUARIO</h4>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">Ver más</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products (Solo 20 productos destacados, SIN filtros ni búsqueda) -->
<section class="py-16 bg-white" data-products-source="api" data-dynamic-products="true" data-max-products="20" data-show-filters="false">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">PRODUCTOS DESTACADOS</h2>
        
        <!-- Grid de productos (sin barra de búsqueda) -->
        <div class="products-list">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="products-container">
            <!-- Los productos se cargarán dinámicamente aquí (máximo 20) -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="relative">
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">NUEVO</div>
                    <button class="absolute top-2 right-2 bg-white p-2 rounded-full shadow-md">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Cargando...</h3>
                    <p class="text-sm text-gray-600 mb-3">Productos</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-green-600">$0</span>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
        <!-- Botón Ver Todos los Productos -->
        <div class="text-center mt-12">
            <a href="/sitio/tienda" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300">
                <span>VER TODOS LOS PRODUCTOS</span>
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

' . $this->getFooter() . $this->getCartAndScripts();
    }

    private function getShopPageHTML()
    {
        return $this->getHeader() . '
        
<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Nuestra Tienda</h1>
        <p class="text-xl">Descubre todos nuestros productos</p>
    </div>
</section>

<!-- Shop Content (Página de Tienda con filtros y búsqueda completa - agregados automáticamente por Laravel) -->
<section class="py-12 bg-gray-50" data-products-source="api" data-dynamic-products="true" data-max-products="12" data-show-filters="true">
    <div class="container mx-auto px-4">
        <!-- La barra de búsqueda se agregará automáticamente por el componente products-script -->
        
        <!-- Grid de productos (con scroll infinito) -->
        <div class="products-list">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="products-container">
                <div class="col-span-full flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                        <p class="text-gray-600">Cargando productos...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Indicador de carga para scroll infinito -->
        <div id="loading-more" class="hidden text-center py-8">
            <div class="w-10 h-10 mx-auto border-b-2 border-blue-600 rounded-full animate-spin"></div>
            <p class="text-gray-600 mt-2">Cargando más productos...</p>
        </div>
    </div>
</section>

' . $this->getFooter() . $this->getCartAndScripts();
    }

    private function getAboutPageHTML()
    {
        return $this->getHeader() . '
        
<!-- Hero -->
<section class="bg-gradient-to-r from-red-600 to-red-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Quiénes Somos</h1>
        <p class="text-xl">Nuestra historia y compromiso</p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-3xl font-bold text-center mb-6">Nuestra Historia</h2>
        <div class="bg-gray-100 rounded-lg p-8 mb-12">
            <p class="text-lg text-gray-700 mb-4">
                Desde 2010, MASH se ha consolidado como la tienda líder en gorras y accesorios de alta calidad en Colombia.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-blue-50 rounded-lg p-8">
                <h3 class="text-2xl font-bold mb-4">Nuestra Misión</h3>
                <p class="text-gray-700">Ofrecer la mejor experiencia de compra online.</p>
            </div>
            <div class="bg-red-50 rounded-lg p-8">
                <h3 class="text-2xl font-bold mb-4">Nuestra Visión</h3>
                <p class="text-gray-700">Ser la tienda número uno de gorras en Colombia.</p>
            </div>
        </div>
    </div>
</section>

' . $this->getFooter() . $this->getCartAndScripts();
    }

    private function getHeader()
    {
        return '
<header class="bg-red-600 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold">MASH</h1>
                <p class="text-xs">🚚 ENVÍOS A TODO COLOMBIA</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Menú para usuarios invitados (no autenticados) -->
                <div id="guest-menu" class="hidden">
                    <button id="login-button" class="hover:text-red-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menú para usuarios autenticados -->
                <div id="user-menu" class="hidden relative">
                    <button id="user-menu-button" class="hover:text-red-200 transition-colors flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown del usuario -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="/sitio/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            👤 Mi Perfil
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button id="logout-button" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            🚪 Cerrar Sesión
                        </button>
                    </div>
                </div>

                <!-- Carrito de compras -->
                <button id="cart-button" class="hover:text-red-200 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span id="cart-counter" class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center space-x-6">
            <a href="/sitio" class="hover:text-yellow-400 transition-colors">INICIO</a>
            <a href="/sitio/tienda" class="hover:text-yellow-400 transition-colors">TIENDA</a>
            <a href="/sitio/quienes-somos" class="hover:text-yellow-400 transition-colors">QUIÉNES SOMOS</a>
        </div>
    </div>
</nav>
';
    }

    private function getFooter()
    {
        return '
<footer class="bg-gray-900 text-white py-12 mt-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MASH</h3>
                <p class="text-gray-400">Tu tienda online de confianza</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">ENLACES</h4>
                <ul class="space-y-2">
                    <li><a href="/sitio" class="text-gray-400 hover:text-white">Inicio</a></li>
                    <li><a href="/sitio/tienda" class="text-gray-400 hover:text-white">Tienda</a></li>
                    <li><a href="/sitio/quienes-somos" class="text-gray-400 hover:text-white">Quiénes Somos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">CONTACTO</h4>
                <p class="text-gray-400">Mash, Acacías (Meta) - Colombia</p>
                <p class="text-gray-400">Email: info@mash.com</p>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-400 text-sm">© 2024 MASH - Todos los derechos reservados</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/573XXXXXXXXX" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors z-50">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>
';
    }

    private function getCartAndScripts()
    {
        // Este código es copiado directamente del TemplateSeeder que SÍ funciona
        return '
<!-- Sidebar del Carrito -->
<div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-96">
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-between p-4 border-b bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Carrito de Compras</h3>
            <button id="close-cart" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex-1 p-4 overflow-y-auto">
            <div id="cart-items" class="space-y-4">
                <div class="py-8 text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-300" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/><path fill="currentColor" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/></svg>
                    <p>Tu carrito está vacío</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 border-t bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-semibold">Total:</span>
                <span id="cart-total" class="text-xl font-bold text-green-600">$0.00</span>
            </div>
            <button id="checkout-btn" class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
                Proceder al Pago
            </button>
        </div>
    </div>
</div>

<div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50"></div>

<script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cartButton = document.getElementById("cart-button");
    const cartSidebar = document.getElementById("cart-sidebar");
    const cartOverlay = document.getElementById("cart-overlay");
    const closeCartBtn = document.getElementById("close-cart");
    const cartItems = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const checkoutBtn = document.getElementById("checkout-btn");
    const cartCounter = document.getElementById("cart-counter");
    
    let cart = JSON.parse(localStorage.getItem("cart") || "[]");
    
    const to2 = n => (Math.round(n * 100) / 100);
    
    function applyDiscountGross(gross, pct = 0) {
        return gross * (1 - (pct / 100));
    }
    
    function lineAmounts(it) {
        const ivaRate = (parseFloat(it.iva) || 0) / 100;
        const unitGross = applyDiscountGross(parseFloat(it.price || 0), parseFloat(it.discountPct || 0));
        const unitBase = ivaRate > 0 ? unitGross / (1 + ivaRate) : unitGross;
        const unitIva = unitGross - unitBase;
        return {
            unitGross: to2(unitGross),
            unitBase: to2(unitBase),
            unitIva: to2(unitIva),
            ivaRate
        };
    }
    
    function computeTotals(cart) {
        let gross = 0, base = 0, iva = 0;
        for (const it of cart) {
            const { unitGross, unitBase, unitIva } = lineAmounts(it);
            const qty = parseInt(it.quantity || 1, 10);
            gross += unitGross * qty;
            base += unitBase * qty;
            iva += unitIva * qty;
        }
        return {
            gross: to2(gross),
            taxBase: to2(base),
            tax: to2(iva),
            taxIco: to2(0)
        };
    }
    
    function openCart() {
        cartSidebar.classList.remove("translate-x-full");
        cartOverlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    }
    
    function closeCart() {
        cartSidebar.classList.add("translate-x-full");
        cartOverlay.classList.add("hidden");
        document.body.style.overflow = "auto";
    }
    
    function updateCartCounter() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCounter.textContent = totalItems;
    }
    
    function updateCartTotal() {
        const totals = computeTotals(cart);
        cartTotal.textContent = "$" + totals.gross.toFixed(2);
        checkoutBtn.disabled = cart.length === 0;
    }
    
    function renderCartItems() {
        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="py-8 text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-300" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/><path fill="currentColor" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/></svg>
                    <p>Tu carrito está vacío</p>
                </div>
            `;
            return;
        }
        
        cartItems.innerHTML = cart.map((item, index) => `
            <div class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">${item.name}</h4>
                    <p class="text-sm text-gray-600">$${item.price.toFixed(2)}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="updateQuantity(${index}, -1)" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                    <span class="w-8 text-center">${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                </div>
                <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `).join("");
    }
    
    function addToCart(productData) {
        const existingItem = cart.find(item => item.id === productData.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productData.id,
                name: productData.name,
                price: parseFloat(productData.price),
                descripcion: productData.descripcion,
                existencia: parseInt(productData.existencia || 0, 10),
                iva: parseFloat(productData.iva),
                discountPct: 0,
                quantity: 1
            });
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
        // openCart(); ← Quitado: no abrir sidebar automáticamente
    }
    
    window.updateQuantity = function(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
    };
    
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
    };
    
    if (cartButton) cartButton.addEventListener("click", openCart);
    if (closeCartBtn) closeCartBtn.addEventListener("click", closeCart);
    if (cartOverlay) cartOverlay.addEventListener("click", closeCart);
    
    updateCartCounter();
    updateCartTotal();
    renderCartItems();
    
    // ========================================
    // CARGA DE PRODUCTOS DINÁMICOS
    // ========================================
    let loadAttempts = 0;
    const maxAttempts = 20;
    
    function loadRealProducts() {
        // ESPERAR a que las variables globales estén disponibles
        if ((!window.websiteApiKey || !window.websiteApiUrl) && loadAttempts < maxAttempts) {
            loadAttempts++;
            setTimeout(loadRealProducts, 100);
            return;
        }
        
        if (loadAttempts >= maxAttempts) {
            console.error("❌ Variables API no disponibles");
            return;
        }
        
        let productsContainers = document.querySelectorAll("#products-container");
        
        if (productsContainers.length === 0) {
            productsContainers = document.querySelectorAll("[data-dynamic-products=true] .grid");
        }
        
        if (productsContainers.length === 0) {
            productsContainers = document.querySelectorAll(".products-list .grid");
        }
        
        if (productsContainers.length === 0) {
            return;
        }
        
        productsContainers.forEach((container, index) => {
            // Verificar si este contenedor tiene límite de productos
            const section = container.closest("section");
            const maxProducts = section ? (section.getAttribute("data-max-products") || "50") : "50";
            const showFilters = section ? (section.getAttribute("data-show-filters") !== "false") : true;
            
            container.innerHTML = "<div class=\\"flex items-center justify-center py-12 col-span-full\\"><div class=\\"text-center\\"><div class=\\"w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin\\"></div><p class=\\"text-gray-600\\">Cargando productos...</p></div></div>";
            
            const apiKey = window.websiteApiKey;
            const apiBaseUrl = window.websiteApiUrl;
            
            if (apiKey && apiBaseUrl) {
                const productsToLoad = maxProducts || "20";
                
                fetch(apiBaseUrl + "/api-key/products?paginate=" + productsToLoad + "&estado=1", {
                    method: "GET",
                    headers: {
                        "X-API-Key": apiKey,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // LOG: Ver respuesta completa del servidor
                    console.log("📡 RESPUESTA DEL SERVIDOR:", data);
                    console.log("📦 Total productos recibidos:", data.data ? data.data.length : 0);
                    
                    // LOG: Ver estructura del primer producto
                    if (data.data && data.data.length > 0) {
                        console.log("🔍 PRIMER PRODUCTO COMPLETO:", data.data[0]);
                        console.log("🖼️ Campo imagenes del primer producto:", data.data[0].imagenes);
                        console.log("🖼️ Campo img del primer producto:", data.data[0].img);
                    }
                    
                    let products = [];
                    if (data && data.data && Array.isArray(data.data)) {
                        products = data.data;
                    } else if (data && data.data && typeof data.data === "object") {
                        products = Object.values(data.data);
                    }
                    
                    // Limitar productos según el atributo data-max-products
                    const maxProductsInt = parseInt(maxProducts, 10);
                    if (products.length > maxProductsInt) {
                        products = products.slice(0, maxProductsInt);
                    }
                    
                    if (products.length > 0) {
                        renderRealProducts(container, products);
                    } else {
                        container.innerHTML = "<div class=\\"col-span-full text-center py-8\\"><p class=\\"text-gray-600\\">No hay productos disponibles</p></div>";
                    }
                })
                .catch(error => {
                    console.error("❌ Error:", error.message);
                    container.innerHTML = `<div class="col-span-full text-center py-8 bg-red-50 rounded p-4"><p class="text-red-600 font-bold">Error al cargar productos</p></div>`;
                });
            } else {
                container.innerHTML = "<div class=\\"col-span-full text-center py-8\\"><p class=\\"text-orange-600 font-bold\\">API no configurada</p></div>";
            }
        });
    }
    
    function renderRealProducts(container, products) {
        let productsHtml = "";
        products.forEach(product => {
            const title = product.producto || "Sin nombre";
            const description = product.descripcion || "Sin descripción";
            const price = product.precio || "0.00";
            const iva = product.iva || "0";
            const existencia = product.existencia || "0";
            const category = product.categoria ? product.categoria.categoria : null;
            
            // Obtener la primera imagen del array de imagenes
            let img = null;
            
            // DEBUG: Log completo de imagenes
            console.log("🖼️ DEBUG -", title);
            console.log("  → imagenes:", product.imagenes);
            console.log("  → img:", product.img);
            console.log("  → tipo:", typeof product.imagenes);
            console.log("  → es array:", Array.isArray(product.imagenes));
            console.log("  → length:", product.imagenes ? product.imagenes.length : "N/A");
            
            if (product.imagenes && Array.isArray(product.imagenes) && product.imagenes.length > 0) {
                const sortedImages = [...product.imagenes].sort((a, b) => (a.orden || 0) - (b.orden || 0));
                img = sortedImages[0].imagen;
                console.log("  ✅ Imagen extraída:", img);
            } else if (product.img) {
                img = product.img;
                console.log("  ✅ Usando img directo:", img);
            } else {
                console.log("  ❌ Sin imagen");
            }
            
            // Construir URL de la imagen
            let imageHtml = "";
            if (img) {
                const imageUrl = "https://servidor.adminnegocios.com/storage/productos/" + img;
                imageHtml = "<div class=\\"relative bg-white\\"><img src=\\"" + imageUrl + "\\" alt=\\"" + title + "\\" class=\\"w-full h-64 object-contain\\" loading=\\"lazy\\" onerror=\\"this.onerror=null; this.src=\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22400%22 height=%22300%22/%3E%3C/svg%3E\'\\"><div class=\\"absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold\\">NUEVO</div><button class=\\"absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100\\"><svg class=\\"w-5 h-5 text-yellow-500\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z\\"></path></svg></button></div>";
            } else {
                imageHtml = "<div class=\\"relative\\"><div class=\\"w-full h-64 bg-gray-200 flex items-center justify-center\\"><svg class=\\"w-16 h-16 text-gray-400\\" fill=\\"none\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\\"></path></svg></div><div class=\\"absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold\\">NUEVO</div><button class=\\"absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100\\"><svg class=\\"w-5 h-5 text-yellow-500\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z\\"></path></svg></button></div>";
            }
            
            // HTML de categoría
            let categoryHtml = "";
            if (category) {
                categoryHtml = "<span class=\\"inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full\\">" + category + "</span>";
            }
            
            productsHtml += "<div class=\\"bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow overflow-hidden\\">" + imageHtml + "<div class=\\"p-4\\"><h3 class=\\"text-lg font-semibold mb-2 text-gray-900\\">" + title + "</h3>" + categoryHtml + "<p class=\\"text-sm text-gray-600 mb-3 line-clamp-2\\">" + description + "</p><div class=\\"flex items-center justify-between mb-2\\"><span class=\\"text-xl font-bold text-green-600\\">$" + price + "</span><span class=\\"text-sm text-gray-500\\">Stock: " + existencia + "</span></div><button class=\\"w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 add-to-cart\\" data-id=\\"" + (product.id || "") + "\\" data-name=\\"" + title + "\\" data-price=\\"" + price + "\\" data-descripcion=\\"" + description + "\\" data-existencia=\\"" + existencia + "\\" data-iva=\\"" + iva + "\\">Agregar al Carrito</button></div></div>";
        });
        
        container.innerHTML = productsHtml;
        
        // Recargar event listeners
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function() {
                const productData = {
                    id: this.getAttribute("data-id"),
                    name: this.getAttribute("data-name"),
                    price: parseFloat(this.getAttribute("data-price")),
                    descripcion: this.getAttribute("data-descripcion"),
                    existencia: this.getAttribute("data-existencia"),
                    iva: this.getAttribute("data-iva")
                };
                addToCart(productData);
            });
        });
    }
    
    // Cargar productos después de un delay
    setTimeout(() => {
        loadRealProducts();
    }, 500);
    
    // La funcionalidad de búsqueda y filtros la maneja el componente products-script de Laravel
});
</script>
';
    }

    private function getGlobalCSS()
    {
        return '
.container { max-width: 1200px; margin: 0 auto; }
.transition-colors { transition: color 0.2s, background-color 0.2s; }
.transition-shadow { transition: box-shadow 0.2s; }
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
';
    }
}
