<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Website;
use App\Models\SharedComponent;

class SharedComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            // Header por defecto
            SharedComponent::create([
                'website_id' => $website->id,
                'name' => 'Header Principal',
                'type' => 'header',
                'description' => 'Encabezado principal del sitio web',
                'html_content' => '<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">' . $website->name . '</h1>
        <nav class="space-x-4">
            <a href="/" class="hover:text-blue-200">Inicio</a>
            <a href="/sobre" class="hover:text-blue-200">Sobre</a>
            <a href="/contacto" class="hover:text-blue-200">Contacto</a>
        </nav>
    </div>
</header>',
                'css_content' => 'header { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }',
                'is_active' => true,
                'sort_order' => 1,
            ]);

            // Footer por defecto
            SharedComponent::create([
                'website_id' => $website->id,
                'name' => 'Footer Principal',
                'type' => 'footer',
                'description' => 'Pie de página principal del sitio web',
                'html_content' => '<footer class="bg-gray-800 text-white p-6">
    <div class="container mx-auto text-center">
        <p>&copy; 2025 ' . $website->name . '. Todos los derechos reservados.</p>
        <div class="mt-4 space-x-4">
            <a href="/privacidad" class="hover:text-gray-300">Privacidad</a>
            <a href="/terminos" class="hover:text-gray-300">Términos</a>
            <a href="/contacto" class="hover:text-gray-300">Contacto</a>
        </div>
    </div>
</footer>',
                'css_content' => 'footer { margin-top: auto; }',
                'is_active' => true,
                'sort_order' => 1,
            ]);

            // Menú de navegación
            SharedComponent::create([
                'website_id' => $website->id,
                'name' => 'Menú Principal',
                'type' => 'menu',
                'description' => 'Menú de navegación principal',
                'html_content' => '<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <ul class="flex space-x-6 py-4">
            <li><a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Inicio</a></li>
            <li><a href="/servicios" class="text-gray-700 hover:text-blue-600 font-medium">Servicios</a></li>
            <li><a href="/productos" class="text-gray-700 hover:text-blue-600 font-medium">Productos</a></li>
            <li><a href="/blog" class="text-gray-700 hover:text-blue-600 font-medium">Blog</a></li>
            <li><a href="/contacto" class="text-gray-700 hover:text-blue-600 font-medium">Contacto</a></li>
        </ul>
    </div>
</nav>',
                'css_content' => 'nav ul li a { transition: color 0.3s ease; }',
                'is_active' => true,
                'sort_order' => 1,
            ]);

            // Bloque de llamada a la acción
            SharedComponent::create([
                'website_id' => $website->id,
                'name' => 'CTA Principal',
                'type' => 'block',
                'description' => 'Bloque de llamada a la acción reutilizable',
                'html_content' => '<div class="bg-blue-600 text-white p-8 rounded-lg text-center">
    <h2 class="text-3xl font-bold mb-4">¿Listo para comenzar?</h2>
    <p class="text-xl mb-6">Descubre cómo podemos ayudarte a alcanzar tus objetivos.</p>
    <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
        Comenzar Ahora
    </button>
</div>',
                'css_content' => '.bg-blue-600 button { transition: background-color 0.3s ease; }',
                'is_active' => true,
                'sort_order' => 1,
            ]);

            // Bloque de características
            SharedComponent::create([
                'website_id' => $website->id,
                'name' => 'Características',
                'type' => 'block',
                'description' => 'Bloque para mostrar características o servicios',
                'html_content' => '<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
    <div class="text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Rápido</h3>
        <p class="text-gray-600">Procesamiento rápido y eficiente</p>
    </div>
    <div class="text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Confiable</h3>
        <p class="text-gray-600">Solución confiable y segura</p>
    </div>
    <div class="text-center">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Fácil</h3>
        <p class="text-gray-600">Fácil de usar y configurar</p>
    </div>
</div>',
                'css_content' => '.grid > div { transition: transform 0.3s ease; } .grid > div:hover { transform: translateY(-5px); }',
                'is_active' => true,
                'sort_order' => 2,
            ]);
        }
    }
}