<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\Website;

class CreateStorePage extends Command
{
    protected $signature = 'create:store-page';
    protected $description = 'Crear página de tienda para el sitio web seleccionado';

    public function handle()
    {
        // Obtener el sitio web seleccionado (el primero disponible)
        $website = Website::first();
        
        if (!$website) {
            $this->error('No hay sitios web disponibles');
            return;
        }
        
        $this->info('Creando página de tienda para: ' . $website->name);
        
        // Verificar si ya existe una página con slug "tienda"
        $existingPage = $website->pages()->where('slug', 'tienda')->first();
        
        if ($existingPage) {
            $this->info('La página de tienda ya existe: ' . $existingPage->title);
            return;
        }
        
        // Crear la página de tienda
        $page = $website->pages()->create([
            'title' => 'Tienda',
            'slug' => 'tienda',
            'html_content' => '<div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-16">
                <div class="max-w-4xl mx-auto px-4 text-center">
                    <h1 class="text-4xl font-bold mb-4">Nuestra Tienda</h1>
                    <p class="text-xl mb-8">Descubre nuestros productos increíbles</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                        <div class="bg-white bg-opacity-20 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Producto 1</h3>
                            <p class="mb-4">Descripción del producto</p>
                            <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold">Ver Producto</button>
                        </div>
                        <div class="bg-white bg-opacity-20 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Producto 2</h3>
                            <p class="mb-4">Descripción del producto</p>
                            <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold">Ver Producto</button>
                        </div>
                        <div class="bg-white bg-opacity-20 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Producto 3</h3>
                            <p class="mb-4">Descripción del producto</p>
                            <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold">Ver Producto</button>
                        </div>
                    </div>
                </div>
            </div>',
            'meta_description' => 'Descubre nuestros productos increíbles en nuestra tienda online',
            'is_published' => true,
            'is_home' => false,
            'sort_order' => 2,
        ]);
        
        $this->info('Página de tienda creada exitosamente con ID: ' . $page->id);
        
        // También crear una página de contacto si no existe
        $contactPage = $website->pages()->where('slug', 'contacto')->first();
        
        if (!$contactPage) {
            $contactPage = $website->pages()->create([
                'title' => 'Contacto',
                'slug' => 'contacto',
                'html_content' => '<div class="bg-gray-50 py-16">
                    <div class="max-w-4xl mx-auto px-4">
                        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Contáctanos</h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Información de Contacto</h2>
                                <p class="text-gray-600 mb-4"><strong>Email:</strong> contacto@misitio.com</p>
                                <p class="text-gray-600 mb-4"><strong>Teléfono:</strong> +1 (555) 123-4567</p>
                                <p class="text-gray-600 mb-4"><strong>Dirección:</strong> Ciudad, País</p>
                            </div>
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Envíanos un Mensaje</h2>
                                <form class="space-y-4">
                                    <input type="text" placeholder="Nombre" class="w-full p-3 border border-gray-300 rounded-lg">
                                    <input type="email" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-lg">
                                    <textarea placeholder="Mensaje" rows="4" class="w-full p-3 border border-gray-300 rounded-lg"></textarea>
                                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold">Enviar Mensaje</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>',
                'meta_description' => 'Ponte en contacto con nosotros para cualquier consulta',
                'is_published' => true,
                'is_home' => false,
                'sort_order' => 3,
            ]);
            
            $this->info('Página de contacto creada exitosamente con ID: ' . $contactPage->id);
        }
        
        $this->info('Páginas creadas exitosamente. Ahora puedes navegar a /tienda y /contacto');
    }
}