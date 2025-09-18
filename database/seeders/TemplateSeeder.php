<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // [
            //     'name' => 'Negocio Moderno',
            //     'description' => 'Plantilla profesional para empresas y negocios modernos',
            //     'category' => 'business',
            //     'preview_images' => ['/images/templates/business-modern.jpg'],
            //     'html_content' => $this->getBusinessTemplate(),
            //     'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
            //     'blocks' => ['hero', 'features', 'testimonials', 'contact'],
            //     'is_premium' => false,
            //     'is_active' => true,
            // ],
            // [
            //     'name' => 'Portafolio Creativo',
            //     'description' => 'Perfecta para mostrar tu trabajo y proyectos',
            //     'category' => 'portfolio',
            //     'preview_images' => ['/images/templates/portfolio-creative.jpg'],
            //     'html_content' => $this->getPortfolioTemplate(),
            //     'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
            //     'blocks' => ['hero', 'gallery', 'about', 'contact'],
            //     'is_premium' => false,
            //     'is_active' => true,
            // ],
            // [
            //     'name' => 'Blog Personal',
            //     'description' => 'Ideal para blogs personales y contenido',
            //     'category' => 'blog',
            //     'preview_images' => ['/images/templates/blog-personal.jpg'],
            //     'html_content' => $this->getBlogTemplate(),
            //     'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
            //     'blocks' => ['header', 'posts', 'sidebar', 'footer'],
            //     'is_premium' => false,
            //     'is_active' => true,
            // ],
            // [
            //     'name' => 'Landing Page Premium',
            //     'description' => 'Plantilla premium para landing pages de alta conversión',
            //     'category' => 'landing',
            //     'preview_images' => ['/images/templates/landing-premium.jpg'],
            //     'html_content' => $this->getLandingTemplate(),
            //     'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
            //     'blocks' => ['hero', 'features', 'pricing', 'testimonials', 'cta'],
            //     'is_premium' => true,
            //     'is_active' => true,
            // ],
            [
                'name' => 'Tienda Virtual',
                'description' => 'Plantilla completa para tiendas online con catálogo de productos y carrito de compras',
                'category' => 'ecommerce',
                'preview_images' => ['/images/templates/tienda-virtual.jpg'],
                'html_content' => $this->getTiendaVirtualTemplate(),
                'css_content' => $this->getTiendaVirtualCSS(),
                'blocks' => ['header', 'hero', 'products', 'cart', 'footer'],
                'is_premium' => false,
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            \App\Models\Template::create($template);
        }
    }

    // private function getBusinessTemplate()
    // {
    //     return '<section class="py-20 text-white bg-gradient-to-r from-blue-600 to-purple-600">
    //         <div class="container px-4 mx-auto text-center">
    //             <h1 class="mb-6 text-5xl font-bold">Tu Empresa Aquí</h1>
    //             <p class="max-w-2xl mx-auto mb-8 text-xl">Ofrecemos soluciones profesionales para hacer crecer tu negocio</p>
    //             <button class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Contactar Ahora</button>
    //         </div>
    //     </section>
    //     <section class="py-16 bg-white">
    //         <div class="container px-4 mx-auto">
    //             <h2 class="mb-12 text-3xl font-bold text-center">Nuestros Servicios</h2>
    //             <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
    //                 <div class="p-6 text-center">
    //                     <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full">
    //                         <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    //                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
    //                         </svg>
    //                     </div>
    //                     <h3 class="mb-2 text-xl font-semibold">Servicio 1</h3>
    //                     <p class="text-gray-600">Descripción del servicio que ofreces</p>
    //                 </div>
    //                 <div class="p-6 text-center">
    //                     <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full">
    //                         <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    //                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    //                         </svg>
    //                     </div>
    //                     <h3 class="mb-2 text-xl font-semibold">Servicio 2</h3>
    //                     <p class="text-gray-600">Descripción del servicio que ofreces</p>
    //                 </div>
    //                 <div class="p-6 text-center">
    //                     <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full">
    //                         <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    //                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
    //                         </svg>
    //                     </div>
    //                     <h3 class="mb-2 text-xl font-semibold">Servicio 3</h3>
    //                     <p class="text-gray-600">Descripción del servicio que ofreces</p>
    //                 </div>
    //             </div>
    //         </div>
    //     </section>';
    // }

    // private function getPortfolioTemplate()
    // {
    //     return '<section class="py-20 text-white bg-gray-900">
    //         <div class="container px-4 mx-auto text-center">
    //             <h1 class="mb-6 text-5xl font-bold">Mi Portafolio</h1>
    //             <p class="mb-8 text-xl">Diseñador y Desarrollador Creativo</p>
    //         </div>
    //     </section>
    //     <section class="py-16 bg-white">
    //         <div class="container px-4 mx-auto">
    //             <h2 class="mb-12 text-3xl font-bold text-center">Mis Proyectos</h2>
    //             <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
    //                 <div class="overflow-hidden bg-gray-100 rounded-lg">
    //                     <div class="h-48 bg-gray-300"></div>
    //                     <div class="p-6">
    //                         <h3 class="mb-2 text-xl font-semibold">Proyecto 1</h3>
    //                         <p class="text-gray-600">Descripción del proyecto</p>
    //                     </div>
    //                 </div>
    //                 <div class="overflow-hidden bg-gray-100 rounded-lg">
    //                     <div class="h-48 bg-gray-300"></div>
    //                     <div class="p-6">
    //                         <h3 class="mb-2 text-xl font-semibold">Proyecto 2</h3>
    //                         <p class="text-gray-600">Descripción del proyecto</p>
    //                     </div>
    //                 </div>
    //                 <div class="overflow-hidden bg-gray-100 rounded-lg">
    //                     <div class="h-48 bg-gray-300"></div>
    //                     <div class="p-6">
    //                         <h3 class="mb-2 text-xl font-semibold">Proyecto 3</h3>
    //                         <p class="text-gray-600">Descripción del proyecto</p>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>
    //     </section>';
    // }

    // private function getBlogTemplate()
    // {
    //     return '<header class="bg-white border-b shadow-sm">
    //         <div class="container px-4 py-6 mx-auto">
    //             <h1 class="text-3xl font-bold text-gray-900">Mi Blog</h1>
    //             <p class="mt-2 text-gray-600">Compartiendo ideas y experiencias</p>
    //         </div>
    //     </header>
    //     <main class="container px-4 py-8 mx-auto">
    //         <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    //             <div class="lg:col-span-2">
    //                 <article class="p-6 mb-6 bg-white border rounded-lg shadow-sm">
    //                     <h2 class="mb-4 text-2xl font-bold text-gray-900">Título del Artículo</h2>
    //                     <p class="mb-4 text-gray-600">Fecha de publicación</p>
    //                     <p class="mb-4 text-gray-700">Resumen del artículo...</p>
    //                     <a href="#" class="font-medium text-blue-600 hover:text-blue-800">Leer más</a>
    //                 </article>
    //             </div>
    //             <aside class="lg:col-span-1">
    //                 <div class="p-6 bg-white border rounded-lg shadow-sm">
    //                     <h3 class="mb-4 text-lg font-semibold">Categorías</h3>
    //                     <ul class="space-y-2">
    //                         <li><a href="#" class="text-gray-600 hover:text-blue-600">Tecnología</a></li>
    //                         <li><a href="#" class="text-gray-600 hover:text-blue-600">Diseño</a></li>
    //                         <li><a href="#" class="text-gray-600 hover:text-blue-600">Desarrollo</a></li>
    //                     </ul>
    //                 </div>
    //             </aside>
    //         </div>
    //     </main>';
    // }

    // private function getLandingTemplate()
    // {
    //     return '<section class="py-24 text-white bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700">
    //         <div class="container px-4 mx-auto text-center">
    //             <h1 class="mb-6 text-6xl font-bold">Transforma tu Negocio</h1>
    //             <p class="max-w-3xl mx-auto mb-8 text-xl">La solución definitiva para hacer crecer tu empresa con tecnología de vanguardia</p>
    //             <div class="flex flex-col justify-center gap-4 sm:flex-row">
    //                 <button class="px-8 py-4 font-semibold text-purple-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Comenzar Gratis</button>
    //                 <button class="px-8 py-4 font-semibold text-white transition-colors border-2 border-white rounded-lg hover:bg-white hover:text-purple-600">Ver Demo</button>
    //             </div>
    //         </div>
    //     </section>';
    // }

    private function getTiendaVirtualTemplate()
    {
        return '<header class="bg-white border-b shadow-sm">
            <div class="container px-4 py-4 mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-gray-900">Mi Tienda</h1>
                        <nav class="hidden space-x-6 md:flex">
                            <a href="#" class="text-gray-600 hover:text-gray-900">Inicio</a>
                            <a href="#" class="text-gray-600 hover:text-gray-900">Productos</a>
                            <a href="#" class="text-gray-600 hover:text-gray-900">Categorías</a>
                            <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
                        </nav>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="cart-button" class="relative p-2 text-gray-800 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="#374151" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/>
                                <path d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/>
                            </svg>
                            <span id="cart-counter" class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-1 -right-1">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="container px-4 mx-auto text-center">
                <h2 class="mb-4 text-4xl font-bold">Bienvenido a Nuestra Tienda</h2>
                <p class="mb-8 text-xl">Descubre productos increíbles a precios increíbles</p>
                <button class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Ver Productos</button>
            </div>
        </section>

        <section class="py-16 bg-gray-50 products-list" data-products-source="api" data-dynamic-products="true">
            <div class="container px-4 mx-auto">
                <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Nuestros Productos</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="products-container">
                    <!-- Los productos se cargarán dinámicamente aquí -->
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 1</h3>
                        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">$99.99</span>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 1" data-price="99.99">
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 2</h3>
                        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">$149.99</span>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 2" data-price="149.99">
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 3</h3>
                        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">$199.99</span>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 3" data-price="199.99">
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-12 text-white bg-gray-900">
            <div class="container px-4 mx-auto">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div>
                        <h5 class="mb-4 text-xl font-semibold">Mi Tienda</h5>
                        <p class="text-gray-400">Tu tienda online de confianza</p>
                    </div>
                    <div>
                        <h5 class="mb-4 text-xl font-semibold">Enlaces</h5>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Productos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="mb-4 text-xl font-semibold">Contacto</h5>
                        <p class="text-gray-400">Email: info@mitienda.com</p>
                        <p class="text-gray-400">Teléfono: +1 234 567 890</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Sidebar del Carrito -->
        <div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-96">
            <div class="flex flex-col h-full">
                <!-- Header del carrito -->
                <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Carrito de Compras</h3>
                    <button id="close-cart" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Contenido del carrito -->
                <div class="flex-1 p-4 overflow-y-auto">
                    <div id="cart-items" class="space-y-4">
                        <!-- Los productos se agregarán aquí dinámicamente -->
                        <div class="py-8 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24"><path fill="#000000" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/><path fill="#000000" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/></svg>
                            <p>Tu carrito está vacío</p>
                        </div>
                    </div>
                </div>
                
                <!-- Footer del carrito -->
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
        
        <!-- Overlay del carrito -->
        <div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50"></div>
        
        <!-- JavaScript del carrito -->
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cartButton = document.getElementById("cart-button");
            const cartSidebar = document.getElementById("cart-sidebar");
            const cartOverlay = document.getElementById("cart-overlay");
            const closeCartBtn = document.getElementById("close-cart");
            const cartItems = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");
            const checkoutBtn = document.getElementById("checkout-btn");
            const addToCartButtons = document.querySelectorAll(".add-to-cart");
            const cartCounter = document.getElementById("cart-counter");
            
            let cart = [];
            
            // Abrir carrito
            function openCart() {
                cartSidebar.classList.remove("translate-x-full");
                cartOverlay.classList.remove("hidden");
                document.body.style.overflow = "hidden";
            }
            
            // Cerrar carrito
            function closeCart() {
                cartSidebar.classList.add("translate-x-full");
                cartOverlay.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
            
            // Actualizar contador del carrito
            function updateCartCounter() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCounter.textContent = totalItems;
            }
            
            // Actualizar total del carrito
            function updateCartTotal() {
                const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                cartTotal.textContent = `$${total.toFixed(2)}`;
                checkoutBtn.disabled = cart.length === 0;
            }
            
            // Renderizar items del carrito
            function renderCartItems() {
                if (cart.length === 0) {
                    cartItems.innerHTML = `
                        <div class="py-8 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            <p>Tu carrito está vacío</p>
                        </div>
                    `;
                    return;
                }
                
                cartItems.innerHTML = cart.map((item, index) => `
                    <div class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded">
                            <span class="text-xs text-gray-500">IMG</span>
                        </div>
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
            
            // Agregar al carrito
            function addToCart(name, price) {
                const existingItem = cart.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ name, price, quantity: 1 });
                }
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            }
            
            // Actualizar cantidad
            window.updateQuantity = function(index, change) {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            };
            
            // Remover del carrito
            window.removeFromCart = function(index) {
                cart.splice(index, 1);
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            };
            
            // Event listeners
            cartButton.addEventListener("click", openCart);
            closeCartBtn.addEventListener("click", closeCart);
            cartOverlay.addEventListener("click", closeCart);
            
            // Agregar productos al carrito
            addToCartButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    const name = this.getAttribute("data-name");
                    const price = parseFloat(this.getAttribute("data-price"));
                    addToCart(name, price);
                });
            });
            
            // Función para recargar los event listeners cuando se carguen productos dinámicamente
            window.reloadCartListeners = function() {
                const newAddToCartButtons = document.querySelectorAll(".add-to-cart");
                newAddToCartButtons.forEach((button) => {
                    button.addEventListener("click", function() {
                        const name = this.getAttribute("data-name");
                        const price = parseFloat(this.getAttribute("data-price"));
                        addToCart(name, price);
                    });
                });
            };
            
            // Inicializar
            updateCartCounter();
            updateCartTotal();
            renderCartItems();
        });
        
        // Script para cargar productos reales dinamicamente
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Cargando productos dinamicamente...");
            
            function loadRealProducts() {
                let productsContainers = document.querySelectorAll("#products-container");
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll("[data-dynamic-products=true] .grid");
                }
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll(".products-list .grid");
                }
                
                if (productsContainers.length === 0) {
                    console.log("No se encontraron contenedores de productos");
                    return;
                }
                
                productsContainers.forEach((container, index) => {
                    // Mostrar loading
                    container.innerHTML = "<div class=\\"flex items-center justify-center py-12 col-span-full\\"><div class=\\"text-center\\"><div class=\\"w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin\\"></div><p class=\\"text-gray-600\\">Cargando productos...</p></div></div>";

                    // Hacer peticion real a la API del servidor externo
                    const apiKey = window.websiteApiKey || "sk_sOuK4MEGf1ITPV2wT0pcreZ5ceJ2jbTzl8VU0dsr";
                    const apiBaseUrl = window.websiteApiUrl || "http://172.18.128.1:8001";
                    
                    if (apiKey && apiBaseUrl) {
                        console.log("Haciendo peticion al servidor externo:", apiBaseUrl);
                        
                        fetch(apiBaseUrl + "/api/api-key/products?paginate=6&estado=1", {
                            method: "GET",
                            headers: {
                                "X-API-Key": apiKey,
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => {
                            console.log("Respuesta del servidor externo:", response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log("Datos recibidos del servidor externo:", data);
                            console.log(data && data.data && Array.isArray(data.data) && data.data.length > 0)
                            if (data && data.data && Array.isArray(data.data) && data.data.length > 0) {
                                console.log("Renderizando productos reales del servidor externo");
                                renderRealProducts(container, data.data);
                            } else {
                                console.log("No hay productos en el servidor externo, mostrando ejemplos");
                            }
                        })
                        .catch(error => {
                            console.error("Error al conectar con el servidor externo:", error);
                            console.log("Mostrando productos de ejemplo como fallback");
                        });
                    } else {
                        console.log("No hay configuracion de API, mostrando productos de ejemplo");
                    }
                });
            }
            
            function renderRealProducts(container, products) {
                console.log("Renderizando productos reales:", products.length);
                
                let productsHtml = "";
                products.forEach(product => {
                    const title = product.producto || "Producto sin nombre";
                    const description = product.descripcion || "Sin descripcion";
                    const price = product.precio || "0.00";
                    const image = product.img || null;
                    const category = product.categoria ? product.categoria.categoria : null;
                    
                    let imageHtml = "<div class=\\"flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg\\"><svg class=\\"w-12 h-12 text-gray-400\\" fill=\\"none\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\\"></path></svg></div>";

                    if (false) {
                        imageHtml = "<div class=\\"mb-4 aspect-w-16 aspect-h-9\\"><img src=\\"" + image + "\\" alt=\\"" + title + "\\" class=\\"object-cover w-full h-48 rounded-lg\\"></div>";
                    } else {
                        imageHtml = "<div class=\\"flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg\\"><svg class=\\"w-12 h-12 text-gray-400\\" fill=\\"none\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\\"></path></svg></div>";
                    }
                    
                    let categoryHtml = "";
                    if (category) {
                        categoryHtml = "<span class=\\"inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full\\">" + category + "</span>";
                    }
                    
                    productsHtml += "<div class=\\"p-6 bg-white border border-gray-200 rounded-lg shadow-sm\\">" + imageHtml + "<h3 class=\\"mb-2 text-lg font-semibold text-gray-900\\">" + title + "</h3>" + categoryHtml + "<p class=\\"mb-4 text-sm text-gray-600 line-clamp-2\\">" + description + "</p><div class=\\"flex items-center justify-between\\"><span class=\\"text-lg font-bold text-green-600\\">$" + price + "</span><button class=\\"px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart\\" data-name=\\"" + title + "\\" data-price=\\"" + price + "\\">Agregar al Carrito</button></div></div>";
                });

                container.innerHTML = productsHtml;
                
                // Recargar los event listeners del carrito
                if (typeof window.reloadCartListeners === "function") {
                    window.reloadCartListeners();
                }
            }
            
            // Cargar productos despues de un breve delay
            setTimeout(function() {
                loadRealProducts();
            }, 500);
        });
        </script>';
    }

    private function getTiendaVirtualCSS()
    {
        return '.container { max-width: 1200px; margin: 0 auto; }
        .transition-colors { transition: color 0.2s, background-color 0.2s; }
        .transition-shadow { transition: box-shadow 0.2s; }
        .hover\\:shadow-md:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .hover\\:bg-gray-100:hover { background-color: #f3f4f6; }
        .hover\\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\\:text-gray-900:hover { color: #111827; }
        .hover\\:text-white:hover { color: #ffffff; }';
    }
}
