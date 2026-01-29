<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class LymanSasSimpleSeeder extends Seeder
{
    public function run(): void
    {
        $website = Website::where('slug', 'lyman-sas')->first();
        
        if (!$website) {
            $this->command->error('No se encontró el sitio lyman-sas');
            return;
        }
        
        // Desmarcar otras páginas como home
        $website->pages()->update(['is_home' => false]);
        
        // Crear o actualizar página
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'inicio'],
            [
            'title' => 'Inicio - LYMAN SAS',
            'slug' => 'inicio',
            'meta_description' => 'LYMAN SAS - Servicios logísticos y operativos',
            'is_published' => true,
            'is_home' => true,
            'enable_store' => false,
            'sort_order' => 1,
            'html_content' => $this->getHTML(),
            'css_content' => $this->getCSS(),
            'grapesjs_data' => null
            ]
        );
        
        $this->command->info("✓ Página creada: {$page->title}");
    }
    
    private function getHTML()
    {
        return '
<div class="container-flex flex flex-col gap-8 items-center text-center p-20 bg-gradient-to-br from-emerald-50 to-green-100 min-h-[600px] justify-center">
    <h1 class="heading-component text-7xl font-extrabold text-gray-900 mb-6">LYMAN SAS</h1>
    <p class="paragraph-component text-2xl leading-relaxed text-gray-700 max-w-4xl">
        Servicios logísticos y operativos especializados para la ejecución integral de proyectos
    </p>
</div>

<div class="container-flex flex flex-col gap-8 items-center text-center p-16 bg-white">
    <h2 class="heading-component text-5xl font-bold text-gray-900">Quiénes Somos</h2>
    <p class="paragraph-component text-xl leading-relaxed text-gray-700 max-w-3xl">
        INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. 
        Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
    </p>
</div>

<div class="container-flex flex flex-col gap-12 p-16 bg-gray-50">
    <h2 class="heading-component text-5xl font-bold text-gray-900 text-center mb-4">Nuestros Servicios</h2>
    <p class="paragraph-component text-lg text-gray-600 text-center max-w-2xl mx-auto mb-8">
        Soluciones integrales diseñadas para satisfacer sus necesidades operativas
    </p>
    
    <div class="container-flex flex flex-col md:flex-row gap-8 max-w-7xl mx-auto w-full">
        <div class="container-flex flex flex-col gap-4 p-10 bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all text-center w-full">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Organización de Eventos</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600">
                Planificación y ejecución completa de eventos y actividades
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-4 p-10 bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all text-center w-full">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Servicios Logísticos</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600">
                Gestión integral de recursos, transporte y personal
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-4 p-10 bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all text-center w-full">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Operaciones de Campo</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600">
                Implementación y supervisión de proyectos en terreno
            </p>
        </div>
    </div>
</div>

<div class="container-flex flex flex-col gap-8 items-center text-center p-16 bg-white">
    <h2 class="heading-component text-5xl font-bold text-gray-900">Contáctenos</h2>
    <p class="paragraph-component text-xl leading-relaxed text-gray-700 max-w-2xl mb-4">
        Estamos listos para hacer realidad sus proyectos. Contáctenos hoy mismo.
    </p>
    <p class="paragraph-component text-lg text-gray-600">
        Teléfono: 320 457 56 82 | Email: info@lyman.com.co | Web: www.lyman.com.co
    </p>
</div>
';
    }
    
    private function getCSS()
    {
        return '
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: #2d3748;
}
';
    }
}
