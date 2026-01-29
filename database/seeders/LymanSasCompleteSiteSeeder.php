<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class LymanSasCompleteSiteSeeder extends Seeder
{
    public function run(): void
    {
        $website = Website::where('slug', 'lyman-sas')->first();
        
        if (!$website) {
            $this->command->error('No se encontró el sitio lyman-sas');
            return;
        }
        
        $this->command->info('🚀 Creando páginas completas para LYMAN SAS');
        
        // Desmarcar todas las páginas como home
        $website->pages()->update(['is_home' => false]);
        
        // 1. Página de Inicio
        $this->createHomePage($website);
        
        // 2. Página de Servicios
        $this->createServicesPage($website);
        
        // 3. Página Nosotros
        $this->createAboutPage($website);
        
        // 4. Página de Contacto
        $this->createContactPage($website);
        
        $this->command->info('✓ Sitio completo creado exitosamente');
    }
    
    private function createHomePage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'Inicio',
                'meta_description' => 'LYMAN SAS - Servicios logísticos y operativos especializados',
                'is_published' => true,
                'is_home' => true,
                'enable_store' => false,
                'sort_order' => 1,
                'html_content' => '
<!-- Hero Section con imagen de fondo -->
<div class="background-image-section relative min-h-[700px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col gap-8 items-center text-center p-20 w-full">
        <div class="flex flex-col gap-6 items-center">
            <h1 class="heading-component text-7xl font-extrabold text-white mb-6">LYMAN SAS</h1>
            <p class="paragraph-component text-2xl leading-relaxed text-white max-w-4xl mb-8">
                Servicios logísticos y operativos especializados para la ejecución integral de proyectos
            </p>
            <div class="container-flex flex flex-row gap-4 items-center justify-center">
                <a href="/lyman-sas/servicios" class="button-component inline-block px-8 py-4 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold text-lg transition-colors shadow-lg">
                    Ver Servicios
                </a>
                <a href="/lyman-sas/contacto" class="button-component inline-block px-8 py-4 text-emerald-600 bg-white border-2 border-emerald-600 rounded-lg hover:bg-emerald-50 font-semibold text-lg transition-colors shadow-lg">
                    Contáctenos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quiénes Somos con imagen -->
<div class="container-flex flex flex-col md:flex-row gap-12 p-16 bg-white items-center max-w-7xl mx-auto">
    <div class="container-flex flex flex-col gap-6 w-full">
        <h2 class="heading-component text-5xl font-bold text-gray-900">Quiénes Somos</h2>
        <p class="paragraph-component text-xl leading-relaxed text-gray-700">
            INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. 
            Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
        </p>
        <a href="/lyman-sas/nosotros" class="button-component inline-block px-6 py-3 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold transition-colors w-fit">
            Conocer Más
        </a>
    </div>
    <div class="container-flex flex flex-col gap-0 w-full">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=400&fit=crop" alt="Oficina LYMAN" class="w-full h-[400px] object-cover rounded-2xl shadow-lg">
    </div>
</div>

<!-- Nuestros Servicios -->
<div class="container-flex flex flex-col gap-12 p-16 bg-gray-50">
    <h2 class="heading-component text-5xl font-bold text-gray-900 text-center">Nuestros Servicios</h2>
    <p class="paragraph-component text-lg text-gray-600 text-center max-w-2xl mx-auto mb-4">
        Soluciones integrales diseñadas para satisfacer sus necesidades operativas
    </p>
    
    <div class="container-flex flex flex-col md:flex-row gap-8 max-w-7xl mx-auto w-full">
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all text-center w-full">
            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400&h=300&fit=crop" alt="Organización de Eventos" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Organización de Eventos</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600 mb-4">
                Planificación y ejecución completa de eventos y actividades
            </p>
            <a href="/lyman-sas/servicios" class="button-component inline-block px-6 py-3 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold transition-colors">
                Ver Detalles
            </a>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all text-center w-full">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=400&h=300&fit=crop" alt="Servicios Logísticos" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Servicios Logísticos</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600 mb-4">
                Gestión integral de recursos, transporte y personal
            </p>
            <a href="/lyman-sas/servicios" class="button-component inline-block px-6 py-3 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold transition-colors">
                Ver Detalles
            </a>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all text-center w-full">
            <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=300&fit=crop" alt="Operaciones de Campo" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Operaciones de Campo</h3>
            <p class="paragraph-component text-base leading-relaxed text-gray-600 mb-4">
                Implementación y supervisión de proyectos
            </p>
            <a href="/lyman-sas/servicios" class="button-component inline-block px-6 py-3 text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold transition-colors">
                Ver Detalles
            </a>
        </div>
    </div>
</div>

<!-- Por Qué Elegirnos -->
<div class="container-flex flex flex-col gap-12 p-16 bg-white">
    <h2 class="heading-component text-5xl font-bold text-gray-900 text-center">Por Qué Elegirnos</h2>
    <p class="paragraph-component text-lg text-gray-600 text-center max-w-3xl mx-auto mb-8">
        Nuestros diferenciadores nos convierten en el socio ideal para sus proyectos
    </p>
    
    <div class="container-flex flex flex-col md:flex-row gap-8 max-w-6xl mx-auto w-full">
        <div class="container-flex flex flex-col gap-4 p-8 bg-emerald-50 rounded-xl text-center w-full">
            <h3 class="heading-component text-3xl font-bold text-emerald-600 mb-2">100%</h3>
            <h4 class="heading-component text-xl font-semibold text-gray-900">Cumplimiento</h4>
            <p class="paragraph-component text-base text-gray-600">
                Adherencia total a cronogramas
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-4 p-8 bg-emerald-50 rounded-xl text-center w-full">
            <h3 class="heading-component text-3xl font-bold text-emerald-600 mb-2">15+</h3>
            <h4 class="heading-component text-xl font-semibold text-gray-900">Años</h4>
            <p class="paragraph-component text-base text-gray-600">
                De experiencia comprobada
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-4 p-8 bg-emerald-50 rounded-xl text-center w-full">
            <h3 class="heading-component text-3xl font-bold text-emerald-600 mb-2">24/7</h3>
            <h4 class="heading-component text-xl font-semibold text-gray-900">Disponibilidad</h4>
            <p class="paragraph-component text-base text-gray-600">
                Soporte continuo
            </p>
        </div>
    </div>
</div>
',
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null
            ]
        );
        
        $this->command->info("✓ Página Inicio creada");
    }
    
    private function createServicesPage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'servicios'],
            [
                'title' => 'Servicios',
                'meta_description' => 'Servicios logísticos y operativos de LYMAN SAS',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 2,
                'html_content' => '
<!-- Hero Servicios -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col gap-8 items-center text-center p-20 w-full">
        <h1 class="heading-component text-6xl font-bold text-white mb-6">Nuestros Servicios</h1>
        <p class="paragraph-component text-xl leading-relaxed text-white max-w-3xl">
            Soluciones integrales en tres áreas principales diseñadas para satisfacer sus necesidades operativas
        </p>
    </div>
</div>

<!-- Organización de Eventos -->
<div class="container-flex flex flex-col md:flex-row gap-12 p-16 bg-white items-center max-w-7xl mx-auto">
    <div class="container-flex flex flex-col gap-0 w-full">
        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=500&fit=crop" alt="Organización de Eventos" class="w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="container-flex flex flex-col gap-6 w-full">
        <h2 class="heading-component text-4xl font-bold text-gray-900">Organización de Eventos</h2>
        <p class="paragraph-component text-lg text-gray-700 leading-relaxed">
            Planificación y ejecución completa de eventos, jornadas y actividades con atención a cada detalle.
        </p>
        <div class="container-flex flex flex-col gap-4">
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Planeación estratégica personalizada</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Coordinación logística integral</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Supervisión continua en sitio</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Documentación audiovisual completa</p>
            </div>
        </div>
    </div>
</div>

<!-- Servicios Logísticos -->
<div class="container-flex flex flex-col md:flex-row gap-12 p-16 bg-gray-50 items-center max-w-7xl mx-auto">
    <div class="container-flex flex flex-col gap-6 w-full">
        <h2 class="heading-component text-4xl font-bold text-gray-900">Servicios Logísticos</h2>
        <p class="paragraph-component text-lg text-gray-700 leading-relaxed">
            Gestión integral de recursos y operaciones para garantizar eficiencia en cada proyecto.
        </p>
        <div class="container-flex flex flex-col gap-4">
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Personal especializado</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Transporte y movilización</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Infraestructura y montajes</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Alimentación y catering</p>
            </div>
        </div>
    </div>
    <div class="container-flex flex flex-col gap-0 w-full">
        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&h=500&fit=crop" alt="Servicios Logísticos" class="w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
</div>

<!-- Operaciones de Campo -->
<div class="container-flex flex flex-col md:flex-row gap-12 p-16 bg-white items-center max-w-7xl mx-auto">
    <div class="container-flex flex flex-col gap-0 w-full">
        <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=600&h=500&fit=crop" alt="Operaciones de Campo" class="w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="container-flex flex flex-col gap-6 w-full">
        <h2 class="heading-component text-4xl font-bold text-gray-900">Operaciones de Campo</h2>
        <p class="paragraph-component text-lg text-gray-700 leading-relaxed">
            Implementación y supervisión de proyectos en terreno con control total y resultados verificables.
        </p>
        <div class="container-flex flex flex-col gap-4">
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Supervisión continua</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Personal calificado</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Control de calidad riguroso</p>
            </div>
            <div class="container-flex flex flex-row gap-3 items-start">
                <span class="text-2xl">✓</span>
                <p class="paragraph-component text-base text-gray-600">Gestión de riesgos</p>
            </div>
        </div>
    </div>
</div>
',
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null
            ]
        );
        
        $this->command->info("✓ Página Servicios creada");
    }
    
    private function createAboutPage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'nosotros'],
            [
                'title' => 'Nosotros',
                'meta_description' => 'Conoce más sobre LYMAN SAS y nuestro equipo',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 3,
                'html_content' => '
<!-- Hero Nosotros -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col gap-8 items-center text-center p-20 w-full">
        <h1 class="heading-component text-6xl font-bold text-white mb-6">Quiénes Somos</h1>
        <p class="paragraph-component text-xl text-white max-w-2xl">
            Conoce nuestra empresa y lo que nos hace diferentes
        </p>
    </div>
</div>

<!-- Nuestra Historia con imagen -->
<div class="container-flex flex flex-col md:flex-row gap-12 p-16 bg-white items-center max-w-7xl mx-auto">
    <div class="container-flex flex flex-col gap-0 w-full">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=500&fit=crop" alt="Nuestra Empresa" class="w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="container-flex flex flex-col gap-6 w-full">
        <h2 class="heading-component text-4xl font-bold text-gray-900">Nuestra Historia</h2>
        <p class="paragraph-component text-lg text-gray-700 leading-relaxed">
            INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. 
            Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
        </p>
        <p class="paragraph-component text-lg text-gray-700 leading-relaxed">
            Con años de experiencia en el mercado, hemos consolidado nuestra posición como líderes en la gestión 
            y coordinación de proyectos complejos que requieren precisión y profesionalismo.
        </p>
    </div>
</div>

<!-- Nuestros Valores -->
<div class="container-flex flex flex-col gap-12 p-16 bg-gray-50">
    <h2 class="heading-component text-5xl font-bold text-gray-900 text-center mb-8">Nuestros Valores</h2>
    
    <div class="container-flex flex flex-col md:flex-row gap-8 max-w-7xl mx-auto w-full">
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg text-center w-full">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop" alt="Experiencia" class="w-full h-48 object-cover rounded-lg">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Experiencia Comprobada</h3>
            <p class="paragraph-component text-base text-gray-600">
                Años de trayectoria exitosa en servicios logísticos y operativos
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg text-center w-full">
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop" alt="Cumplimiento" class="w-full h-48 object-cover rounded-lg">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Cumplimiento Total</h3>
            <p class="paragraph-component text-base text-gray-600">
                100% adherencia a cronogramas y especificaciones técnicas
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-white rounded-2xl shadow-lg text-center w-full">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop" alt="Control" class="w-full h-48 object-cover rounded-lg">
            <h3 class="heading-component text-2xl font-bold text-gray-900">Control Riguroso</h3>
            <p class="paragraph-component text-base text-gray-600">
                Sistemas de seguimiento y documentación completa
            </p>
        </div>
    </div>
</div>

<!-- Cómo Lo Hacemos -->
<div class="container-flex flex flex-col gap-12 p-16 bg-white max-w-6xl mx-auto">
    <h2 class="heading-component text-5xl font-bold text-gray-900 text-center">Cómo Lo Hacemos</h2>
    <p class="paragraph-component text-lg text-gray-600 text-center max-w-3xl mx-auto">
        Nuestra metodología garantiza resultados exitosos en cada proyecto
    </p>
    
    <div class="container-flex flex flex-col gap-6">
        <div class="container-flex flex flex-row gap-6 items-start p-6 bg-gray-50 rounded-xl">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-16 h-16 flex-shrink-0">
                <span class="text-2xl font-bold">1</span>
            </div>
            <div class="container-flex flex flex-col gap-2">
                <h3 class="heading-component text-xl font-bold text-gray-900">Planeación</h3>
                <p class="paragraph-component text-base text-gray-600">Análisis de necesidades y diseño de solución personalizada</p>
            </div>
        </div>
        
        <div class="container-flex flex flex-row gap-6 items-start p-6 bg-gray-50 rounded-xl">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-16 h-16 flex-shrink-0">
                <span class="text-2xl font-bold">2</span>
            </div>
            <div class="container-flex flex flex-col gap-2">
                <h3 class="heading-component text-xl font-bold text-gray-900">Preparación</h3>
                <p class="paragraph-component text-base text-gray-600">Coordinación de recursos, personal y logística</p>
            </div>
        </div>
        
        <div class="container-flex flex flex-row gap-6 items-start p-6 bg-gray-50 rounded-xl">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-16 h-16 flex-shrink-0">
                <span class="text-2xl font-bold">3</span>
            </div>
            <div class="container-flex flex flex-col gap-2">
                <h3 class="heading-component text-xl font-bold text-gray-900">Ejecución</h3>
                <p class="paragraph-component text-base text-gray-600">Implementación en campo con supervisión continua</p>
            </div>
        </div>
        
        <div class="container-flex flex flex-row gap-6 items-start p-6 bg-gray-50 rounded-xl">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-16 h-16 flex-shrink-0">
                <span class="text-2xl font-bold">4</span>
            </div>
            <div class="container-flex flex flex-col gap-2">
                <h3 class="heading-component text-xl font-bold text-gray-900">Control</h3>
                <p class="paragraph-component text-base text-gray-600">Monitoreo en tiempo real y ajustes inmediatos</p>
            </div>
        </div>
        
        <div class="container-flex flex flex-row gap-6 items-start p-6 bg-gray-50 rounded-xl">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-16 h-16 flex-shrink-0">
                <span class="text-2xl font-bold">5</span>
            </div>
            <div class="container-flex flex flex-col gap-2">
                <h3 class="heading-component text-xl font-bold text-gray-900">Cierre</h3>
                <p class="paragraph-component text-base text-gray-600">Documentación completa y entrega de resultados</p>
            </div>
        </div>
    </div>
</div>
',
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null
            ]
        );
        
        $this->command->info("✓ Página Nosotros creada");
    }
    
    private function createContactPage($website)
    {
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'contacto'],
            [
                'title' => 'Contacto',
                'meta_description' => 'Contáctenos - LYMAN SAS',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 4,
                'html_content' => '
<!-- Hero Contacto -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col gap-8 items-center text-center p-20 w-full">
        <h1 class="heading-component text-6xl font-bold text-white mb-6">Contáctenos</h1>
        <p class="paragraph-component text-xl text-white max-w-2xl">
            Estamos listos para hacer realidad sus proyectos. Hablemos hoy.
        </p>
    </div>
</div>

<!-- Información de Contacto con imágenes -->
<div class="container-flex flex flex-col gap-12 p-16 bg-white max-w-7xl mx-auto">
    <h2 class="heading-component text-4xl font-bold text-gray-900 text-center mb-8">Información de Contacto</h2>
    
    <div class="container-flex flex flex-col md:flex-row gap-8 w-full">
        <div class="container-flex flex flex-col gap-6 p-10 bg-gradient-to-br from-emerald-50 to-green-100 rounded-2xl shadow-lg text-center w-full">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-emerald-600 text-white rounded-full w-20 h-20 mx-auto">
                <span class="text-3xl">📞</span>
            </div>
            <h3 class="heading-component text-2xl font-bold text-gray-900">Teléfono</h3>
            <p class="paragraph-component text-xl text-gray-900 font-semibold">
                320 457 56 82
            </p>
            <p class="paragraph-component text-sm text-gray-600">
                Lunes a Viernes: 8:00 AM - 6:00 PM
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl shadow-lg text-center w-full">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-blue-600 text-white rounded-full w-20 h-20 mx-auto">
                <span class="text-3xl">✉️</span>
            </div>
            <h3 class="heading-component text-2xl font-bold text-gray-900">Email</h3>
            <p class="paragraph-component text-xl text-gray-900 font-semibold">
                info@lyman.com.co
            </p>
            <p class="paragraph-component text-sm text-gray-600">
                Respuesta en 24 horas
            </p>
        </div>
        
        <div class="container-flex flex flex-col gap-6 p-10 bg-gradient-to-br from-purple-50 to-pink-100 rounded-2xl shadow-lg text-center w-full">
            <div class="container-flex flex flex-col gap-0 items-center justify-center bg-purple-600 text-white rounded-full w-20 h-20 mx-auto">
                <span class="text-3xl">🌐</span>
            </div>
            <h3 class="heading-component text-2xl font-bold text-gray-900">Sitio Web</h3>
            <p class="paragraph-component text-xl text-gray-900 font-semibold">
                www.lyman.com.co
            </p>
            <a href="https://www.lyman.com.co" target="_blank" class="button-component inline-block px-6 py-2 text-white bg-purple-600 rounded-lg hover:bg-purple-700 font-semibold transition-colors">
                Visitar Sitio
            </a>
        </div>
    </div>
</div>

<!-- Mapa de Ubicación -->
<div class="container-flex flex flex-col gap-8 p-16 bg-gray-50">
    <h2 class="heading-component text-4xl font-bold text-gray-900 text-center mb-8">Nuestra Ubicación</h2>
    <div class="container-flex flex flex-col gap-0 max-w-7xl mx-auto w-full rounded-2xl overflow-hidden shadow-xl">
        <iframe 
            src="https://www.google.com/maps?q=4.592788716801292,-74.09594164946103&output=embed&hl=es" 
            width="100%" 
            height="500" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            class="w-full h-[500px]">
        </iframe>
    </div>
    <p class="paragraph-component text-lg text-gray-600 text-center max-w-2xl mx-auto">
        Bogotá, Colombia - Cobertura nacional en servicios logísticos y operativos
    </p>
</div>

<!-- Call to Action Final -->
<div class="container-flex flex flex-col gap-8 items-center text-center p-20 bg-emerald-600">
    <h2 class="heading-component text-5xl font-bold text-white mb-4">¿Listo para Comenzar?</h2>
    <p class="paragraph-component text-xl text-white max-w-2xl mb-6">
        Contáctenos hoy y descubra cómo podemos ayudarle a alcanzar sus objetivos
    </p>
    <a href="tel:3204575682" class="button-component inline-block px-10 py-4 text-emerald-600 bg-white rounded-lg hover:bg-gray-100 font-bold text-xl transition-colors shadow-xl">
        Llamar Ahora
    </a>
</div>
',
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null
            ]
        );
        
        $this->command->info("✓ Página Contacto creada");
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

/* Asegurar que todos los containers ocupen el ancho completo cuando corresponda */
.container-flex {
    width: 100%;
}

/* Mejorar transiciones */
.transition-all {
    transition: all 0.3s ease-in-out;
}

.transition-colors {
    transition: color 0.2s, background-color 0.2s;
}

/* Asegurar que las imágenes sean responsive */
img {
    max-width: 100%;
    height: auto;
}

/* Links sin subrayado por defecto */
a {
    text-decoration: none;
}

a:hover {
    opacity: 0.8;
}
';
    }
}
