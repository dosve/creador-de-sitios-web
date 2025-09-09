<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Negocio Moderno',
                'description' => 'Plantilla profesional para empresas y negocios modernos',
                'category' => 'business',
                'preview_images' => ['/images/templates/business-modern.jpg'],
                'html_content' => $this->getBusinessTemplate(),
                'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
                'blocks' => ['hero', 'features', 'testimonials', 'contact'],
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Portafolio Creativo',
                'description' => 'Perfecta para mostrar tu trabajo y proyectos',
                'category' => 'portfolio',
                'preview_images' => ['/images/templates/portfolio-creative.jpg'],
                'html_content' => $this->getPortfolioTemplate(),
                'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
                'blocks' => ['hero', 'gallery', 'about', 'contact'],
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Blog Personal',
                'description' => 'Ideal para blogs personales y contenido',
                'category' => 'blog',
                'preview_images' => ['/images/templates/blog-personal.jpg'],
                'html_content' => $this->getBlogTemplate(),
                'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
                'blocks' => ['header', 'posts', 'sidebar', 'footer'],
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Landing Page Premium',
                'description' => 'Plantilla premium para landing pages de alta conversión',
                'category' => 'landing',
                'preview_images' => ['/images/templates/landing-premium.jpg'],
                'html_content' => $this->getLandingTemplate(),
                'css_content' => '.container { max-width: 1200px; margin: 0 auto; }',
                'blocks' => ['hero', 'features', 'pricing', 'testimonials', 'cta'],
                'is_premium' => true,
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            \App\Models\Template::create($template);
        }
    }

    private function getBusinessTemplate()
    {
        return '<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Tu Empresa Aquí</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Ofrecemos soluciones profesionales para hacer crecer tu negocio</p>
                <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Contactar Ahora</button>
            </div>
        </section>
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Nuestros Servicios</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Servicio 1</h3>
                        <p class="text-gray-600">Descripción del servicio que ofreces</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Servicio 2</h3>
                        <p class="text-gray-600">Descripción del servicio que ofreces</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Servicio 3</h3>
                        <p class="text-gray-600">Descripción del servicio que ofreces</p>
                    </div>
                </div>
            </div>
        </section>';
    }

    private function getPortfolioTemplate()
    {
        return '<section class="bg-gray-900 text-white py-20">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Mi Portafolio</h1>
                <p class="text-xl mb-8">Diseñador y Desarrollador Creativo</p>
            </div>
        </section>
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Mis Proyectos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                        <div class="h-48 bg-gray-300"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">Proyecto 1</h3>
                            <p class="text-gray-600">Descripción del proyecto</p>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                        <div class="h-48 bg-gray-300"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">Proyecto 2</h3>
                            <p class="text-gray-600">Descripción del proyecto</p>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                        <div class="h-48 bg-gray-300"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">Proyecto 3</h3>
                            <p class="text-gray-600">Descripción del proyecto</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

    private function getBlogTemplate()
    {
        return '<header class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4 py-6">
                <h1 class="text-3xl font-bold text-gray-900">Mi Blog</h1>
                <p class="text-gray-600 mt-2">Compartiendo ideas y experiencias</p>
            </div>
        </header>
        <main class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Título del Artículo</h2>
                        <p class="text-gray-600 mb-4">Fecha de publicación</p>
                        <p class="text-gray-700 mb-4">Resumen del artículo...</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más</a>
                    </article>
                </div>
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-semibold mb-4">Categorías</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600">Tecnología</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600">Diseño</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600">Desarrollo</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </main>';
    }

    private function getLandingTemplate()
    {
        return '<section class="bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 text-white py-24">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-6xl font-bold mb-6">Transforma tu Negocio</h1>
                <p class="text-xl mb-8 max-w-3xl mx-auto">La solución definitiva para hacer crecer tu empresa con tecnología de vanguardia</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Comenzar Gratis</button>
                    <button class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">Ver Demo</button>
                </div>
            </div>
        </section>';
    }
}
