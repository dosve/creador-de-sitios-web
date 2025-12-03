<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class MashStylePagesSeeder extends Seeder
{
    /**
     * Crear páginas estilo MASH para el sitio web
     */
    public function run(): void
    {
        // Obtener el primer website disponible o crear uno de prueba
        $website = Website::first();
        
        if (!$website) {
            $this->command->error('No hay sitios web disponibles. Crea un website primero.');
            return;
        }
        
        $this->command->info('Creando páginas estilo MASH para: ' . $website->name);
        
        // Limpiar páginas existentes si es necesario (opcional, comentado por seguridad)
        // $website->pages()->delete();
        
        // 1. Página de Inicio
        $this->createHomePage($website);
        
        // 2. Página de Tienda
        $this->createShopPage($website);
        
        // 3. Página Quiénes Somos
        $this->createAboutPage($website);
        
        $this->command->info('✅ Páginas creadas exitosamente!');
        $this->command->info('📄 Visita: /inicio, /tienda, /quienes-somos');
    }
    
    private function createHomePage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'Inicio',
                'meta_description' => 'Bienvenido a nuestra tienda online - Gorras y productos de calidad',
                'is_published' => true,
                'is_home' => true,
                'enable_store' => true,
                'sort_order' => 1,
                'html_content' => $this->getHomePageContent(),
                'css_content' => $this->getGlobalStyles(),
            ]
        );
        
        $this->command->info('✓ Página de Inicio creada (ID: ' . $page->id . ')');
    }
    
    private function createShopPage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'tienda'],
            [
                'title' => 'Tienda',
                'meta_description' => 'Descubre nuestro catálogo completo de productos',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => true,
                'sort_order' => 2,
                'html_content' => $this->getShopPageContent(),
                'css_content' => $this->getGlobalStyles(),
            ]
        );
        
        $this->command->info('✓ Página de Tienda creada (ID: ' . $page->id . ')');
    }
    
    private function createAboutPage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'quienes-somos'],
            [
                'title' => 'Quiénes Somos',
                'meta_description' => 'Conoce nuestra historia y compromiso con la calidad',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 3,
                'html_content' => $this->getAboutPageContent(),
                'css_content' => $this->getGlobalStyles(),
            ]
        );
        
        $this->command->info('✓ Página Quiénes Somos creada (ID: ' . $page->id . ')');
    }
    
    private function getHomePageContent()
    {
        return '
<!-- HEADER / NAVBAR -->
<header class="bg-red-600 text-white">
    <div class="container mx-auto px-4">
        <!-- Top bar con redes sociales y logo -->
        <div class="flex items-center justify-between py-4 border-b border-red-700">
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </a>
                <a href="#" class="hover:text-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="#" class="hover:text-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                </a>
            </div>
            
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold tracking-wide" style="font-family: \'Comic Sans MS\', cursive;">MASH</h1>
                <p class="text-xs">🚚 ENVÍOS A TODO COLOMBIA</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="hover:text-red-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </button>
                <button class="hover:text-red-200 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
                </button>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="py-4">
            <div class="relative">
                <input type="text" placeholder="¿Qué estás buscando?" class="w-full px-4 py-3 pr-12 text-white bg-red-700 rounded-lg placeholder-red-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
            <p class="text-center mt-2 text-sm">🔥 Compras superiores a 165.000 tendrán envío gratis 🔥</p>
        </div>
    </div>
</header>

<!-- Navigation Menu -->
<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-6 py-3">
            <button class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold flex items-center space-x-2 hover:bg-yellow-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span>CATEGORÍAS</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <a href="/inicio" class="hover:text-yellow-400 transition-colors">INICIO</a>
            <a href="/quienes-somos" class="hover:text-yellow-400 transition-colors">QUIÉNES SOMOS</a>
            <a href="/tienda" class="hover:text-yellow-400 transition-colors">TIENDA</a>
            <a href="#" class="hover:text-yellow-400 transition-colors">CONTÁCTANOS</a>
        </div>
    </div>
</nav>

<!-- Hero Banner -->
<section class="relative bg-gray-100">
    <div class="container mx-auto px-4 py-16">
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
        <div class="flex items-center justify-between overflow-x-auto space-x-4">
            <button class="bg-gray-200 rounded-full p-2 hover:bg-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            
            <div class="flex space-x-6">
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-2xl">ADIDAS</span>
                </div>
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-xl">GOORIN<br>BROS</span>
                </div>
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-lg">BASS PRO<br>SHOPS</span>
                </div>
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-2xl">🦌</span>
                </div>
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-xl">NEW ERA</span>
                </div>
                <div class="w-32 h-32 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-2xl">🐊</span>
                </div>
            </div>
            
            <button class="bg-gray-200 rounded-full p-2 hover:bg-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>
</section>

<!-- Campaigns Section -->
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

<!-- Featured Products -->
<section class="py-16 bg-white products-list" data-products-source="api" data-dynamic-products="true">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">PRODUCTOS DESTACADOS</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="products-container">
            <!-- Los productos se cargarán dinámicamente aquí -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                <div class="relative">
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">NUEVO</div>
                    <button class="absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Gorra Ejemplo</h3>
                    <p class="text-sm text-gray-600 mb-3">Producto de ejemplo</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-green-600">$55.000</span>
                        <span class="text-sm text-gray-500">x Unidad</span>
                    </div>
                    <p class="text-sm text-blue-600 mt-1">1 Unidad</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MASH</h3>
                <p class="text-gray-400">Tu tienda online de confianza para gorras y accesorios de calidad.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">ENLACES</h4>
                <ul class="space-y-2">
                    <li><a href="/inicio" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                    <li><a href="/tienda" class="text-gray-400 hover:text-white transition-colors">Tienda</a></li>
                    <li><a href="/quienes-somos" class="text-gray-400 hover:text-white transition-colors">Quiénes Somos</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">CONTACTO</h4>
                <div class="space-y-2 text-gray-400">
                    <p>Mash, Acacías (Meta) - Colombia</p>
                    <p>Email: info@mash.com</p>
                    <p>WhatsApp: +57 XXX XXX XXXX</p>
                </div>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-green-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                    <a href="#" class="hover:text-pink-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="hover:text-gray-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-400 text-sm">Copyright © 2024 - Prohibida la reproducción total o parcial de nuestro contenido</p>
            <p class="text-gray-500 text-sm mt-2">Tecnología - PARZE</p>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/573XXXXXXXXX" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors z-50">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>
';
    }
    
    private function getShopPageContent()
    {
        return '
<!-- HEADER / NAVBAR (Igual que en la página de inicio) -->
<header class="bg-red-600 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4 border-b border-red-700">
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </a>
            </div>
            
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold tracking-wide" style="font-family: \'Comic Sans MS\', cursive;">MASH</h1>
                <p class="text-xs">🚚 ENVÍOS A TODO COLOMBIA</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="hover:text-red-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </button>
                <button class="hover:text-red-200 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
                </button>
            </div>
        </div>
        
        <div class="py-4">
            <div class="relative">
                <input type="text" placeholder="¿Qué estás buscando?" class="w-full px-4 py-3 pr-12 text-white bg-red-700 rounded-lg placeholder-red-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-6 py-3">
            <button class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold flex items-center space-x-2 hover:bg-yellow-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span>CATEGORÍAS</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <a href="/inicio" class="hover:text-yellow-400 transition-colors">INICIO</a>
            <a href="/quienes-somos" class="hover:text-yellow-400 transition-colors">QUIÉNES SOMOS</a>
            <a href="/tienda" class="hover:text-yellow-400 transition-colors">TIENDA</a>
            <a href="#" class="hover:text-yellow-400 transition-colors">CONTÁCTANOS</a>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Nuestra Tienda</h1>
        <p class="text-xl">Descubre todos nuestros productos</p>
    </div>
</section>

<!-- Shop Content with Filters -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow sticky top-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Filtrar Productos</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-medium mb-3">Rango de Precio</h4>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="number" placeholder="Min" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                    <span>-</span>
                                    <input type="number" placeholder="Max" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-3">Categoría</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Gorras Urbanas</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Gorras Deportivas</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Gorras Agropecuarias</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Accesorios</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-3">Marca</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Goorin Bros</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>New Era</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Adidas</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span>Bass Pro Shops</span>
                                </label>
                            </div>
                        </div>
                        
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-600">Mostrando <span class="font-semibold">48 productos</span></p>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Ordenar por: Destacados</option>
                        <option>Precio: Menor a Mayor</option>
                        <option>Precio: Mayor a Menor</option>
                        <option>Más recientes</option>
                    </select>
                </div>
                
                <!-- Products List (Dynamic) -->
                <div class="products-list" data-products-source="api" data-dynamic-products="true">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="products-container">
                        <!-- Los productos se cargarán dinámicamente aquí -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                            <div class="relative">
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <button class="absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-900">Producto de Ejemplo</h3>
                                <p class="text-sm text-gray-600 mb-3">Los productos reales se cargarán desde la API</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-green-600">$55.000</span>
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Load More Button -->
                <div class="text-center mt-12">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                        <span>VER MÁS PRODUCTOS</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer (igual que en inicio) -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MASH</h3>
                <p class="text-gray-400">Tu tienda online de confianza para gorras y accesorios de calidad.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">ENLACES</h4>
                <ul class="space-y-2">
                    <li><a href="/inicio" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                    <li><a href="/tienda" class="text-gray-400 hover:text-white transition-colors">Tienda</a></li>
                    <li><a href="/quienes-somos" class="text-gray-400 hover:text-white transition-colors">Quiénes Somos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">CONTACTO</h4>
                <div class="space-y-2 text-gray-400">
                    <p>Mash, Acacías (Meta) - Colombia</p>
                    <p>Email: info@mash.com</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-400 text-sm">Copyright © 2024 - MASH. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/573XXXXXXXXX" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors z-50">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>
';
    }
    
    private function getAboutPageContent()
    {
        return '
<!-- HEADER / NAVBAR (Igual que antes) -->
<header class="bg-red-600 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4 border-b border-red-700">
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </a>
            </div>
            
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold tracking-wide" style="font-family: \'Comic Sans MS\', cursive;">MASH</h1>
                <p class="text-xs">🚚 ENVÍOS A TODO COLOMBIA</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="hover:text-red-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </button>
                <button class="hover:text-red-200 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-6 py-3">
            <button class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold flex items-center space-x-2 hover:bg-yellow-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span>CATEGORÍAS</span>
            </button>
            <a href="/inicio" class="hover:text-yellow-400 transition-colors">INICIO</a>
            <a href="/quienes-somos" class="hover:text-yellow-400 transition-colors">QUIÉNES SOMOS</a>
            <a href="/tienda" class="hover:text-yellow-400 transition-colors">TIENDA</a>
            <a href="#" class="hover:text-yellow-400 transition-colors">CONTÁCTANOS</a>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="bg-gradient-to-r from-red-600 to-red-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Quiénes Somos</h1>
        <p class="text-xl">Nuestra historia y compromiso con la calidad</p>
    </div>
</section>

<!-- About Content -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-900">Nuestra Historia</h2>
            <div class="bg-gray-100 rounded-lg p-8">
                <p class="text-lg text-gray-700 mb-4">
                    Desde 2010, MASH se ha consolidado como la tienda líder en gorras y accesorios de alta calidad en Colombia. 
                    Comenzamos como un pequeño emprendimiento con la visión de ofrecer productos únicos y auténticos para todos 
                    aquellos que buscan expresar su estilo personal.
                </p>
                <p class="text-lg text-gray-700 mb-4">
                    Con el paso de los años, hemos crecido gracias a la confianza de nuestros clientes, quienes nos han permitido 
                    expandir nuestro catálogo con las mejores marcas internacionales como Goorin Bros, New Era, Adidas, Bass Pro Shops 
                    y muchas más.
                </p>
                <p class="text-lg text-gray-700">
                    Hoy en día, MASH cuenta con presencia en todo el territorio colombiano, ofreciendo envíos seguros y rápidos, 
                    además de un servicio al cliente excepcional que nos distingue en el mercado.
                </p>
            </div>
        </div>
        
        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-blue-50 rounded-lg p-8">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Nuestra Misión</h3>
                <p class="text-gray-700">
                    Ofrecer la mejor experiencia de compra online de gorras y accesorios, brindando productos de calidad 
                    excepcional, autenticidad garantizada y un servicio al cliente que supere las expectativas.
                </p>
            </div>
            
            <div class="bg-red-50 rounded-lg p-8">
                <div class="text-red-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Nuestra Visión</h3>
                <p class="text-gray-700">
                    Ser la tienda número uno de gorras y accesorios en Colombia, reconocida por nuestra variedad, 
                    autenticidad y compromiso con la satisfacción del cliente, expandiendo nuestra presencia a nivel 
                    latinoamericano.
                </p>
            </div>
        </div>
        
        <!-- Values -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900">Nuestros Valores</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-gray-900">Calidad</h4>
                    <p class="text-gray-600 text-sm">Productos 100% auténticos y de las mejores marcas</p>
                </div>
                
                <div class="text-center p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-gray-900">Confianza</h4>
                    <p class="text-gray-600 text-sm">Transparencia en cada transacción</p>
                </div>
                
                <div class="text-center p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-gray-900">Servicio</h4>
                    <p class="text-gray-600 text-sm">Atención excepcional antes, durante y después de tu compra</p>
                </div>
                
                <div class="text-center p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-lg mb-2 text-gray-900">Innovación</h4>
                    <p class="text-gray-600 text-sm">Siempre a la vanguardia de las tendencias</p>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg p-12 text-white text-center">
            <h2 class="text-3xl font-bold mb-8">MASH en Números</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-5xl font-bold mb-2">14+</div>
                    <div class="text-lg">Años de Experiencia</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">50K+</div>
                    <div class="text-lg">Clientes Satisfechos</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">20+</div>
                    <div class="text-lg">Marcas Disponibles</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <div class="text-lg">Productos Auténticos</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">¿Listo para encontrar tu estilo?</h2>
        <p class="text-xl text-gray-600 mb-8">Explora nuestro catálogo y descubre las mejores gorras</p>
        <div class="flex justify-center space-x-4">
            <a href="/tienda" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                <span>Ver Tienda</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
            <a href="#" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-3 rounded-lg font-semibold border border-gray-300 transition-colors">
                Contáctanos
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MASH</h3>
                <p class="text-gray-400">Tu tienda online de confianza para gorras y accesorios de calidad.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">ENLACES</h4>
                <ul class="space-y-2">
                    <li><a href="/inicio" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                    <li><a href="/tienda" class="text-gray-400 hover:text-white transition-colors">Tienda</a></li>
                    <li><a href="/quienes-somos" class="text-gray-400 hover:text-white transition-colors">Quiénes Somos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">CONTACTO</h4>
                <div class="space-y-2 text-gray-400">
                    <p>Mash, Acacías (Meta) - Colombia</p>
                    <p>Email: info@mash.com</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-400 text-sm">Copyright © 2024 - MASH. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/573XXXXXXXXX" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors z-50">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>
';
    }
    
    private function getGlobalStyles()
    {
        return '
/* Estilos globales para las páginas MASH */
.container {
    max-width: 1200px;
    margin: 0 auto;
}

.transition-colors {
    transition: color 0.2s, background-color 0.2s;
}

.transition-shadow {
    transition: box-shadow 0.2s;
}

/* Ajustes para productos dinámicos */
.products-list[data-dynamic-products="true"] #products-container {
    min-height: 400px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
';
    }
}

