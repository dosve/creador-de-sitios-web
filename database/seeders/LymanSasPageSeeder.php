<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class LymanSasPageSeeder extends Seeder
{
    /**
     * Crear sitio web completo de LYMAN SAS con diseño moderno, minimalista y colores suaves.
     * Siempre lista los usuarios disponibles para elegir el propietario (crear o actualizar).
     */
    public function run(): void
    {
        $this->command->info('🚀 Creando sitio web completo de LYMAN SAS');
        $this->command->newLine();

        $existingWebsite = Website::where('slug', 'lyman-sas')->first();

        if ($existingWebsite) {
            $this->command->warn('⚠️  Ya existe un sitio con el slug "lyman-sas"');
            if (!$this->command->confirm('¿Deseas actualizarlo?', true)) {
                $this->command->info('❌ Operación cancelada.');
                return;
            }
            $userId = $this->chooseOwnerUserId($existingWebsite);
            if ($userId === null) {
                $this->command->info('❌ Operación cancelada.');
                return;
            }
            $existingWebsite->update(['user_id' => $userId]);
            $website = $existingWebsite->fresh();
        } else {
            $userId = $this->chooseOwnerUserId(null);
            if ($userId === null) {
                $this->command->info('❌ Operación cancelada.');
                return;
            }
            $website = $this->createLymanWebsite($userId);
        }

        $this->command->newLine();
        $this->command->info('📄 Creando páginas completas del sitio...');

        $website->pages()->update(['is_home' => false]);

        $this->createHomePage($website);
        $this->createServicesPage($website);
        $this->createAboutPage($website);
        $this->createContactPage($website);

        $this->command->newLine();
        $this->command->info('✅ Sitio web de LYMAN SAS creado exitosamente!');
        $this->command->info("   🌐 Slug: {$website->slug}");
        $this->command->info("   📝 Páginas: Inicio (home), Servicios, Nosotros, Contacto");
        $this->command->info("   👤 Propietario: {$website->user->name} (ID: {$website->user_id})");
    }

    /**
     * Lista usuarios disponibles y devuelve el ID del propietario elegido.
     * Si $existingWebsite existe, permite Enter para mantener el actual.
     */
    private function chooseOwnerUserId(?Website $existingWebsite): ?int
    {
        $users = \App\Models\User::where('is_active', true)->orderBy('name')->get();

        if ($users->isEmpty()) {
            $this->command->error('❌ No hay usuarios disponibles. Crea un usuario primero (UserSeeder o registro).');
            return null;
        }

        $this->command->info('📋 Usuarios disponibles:');
        foreach ($users as $index => $user) {
            $marker = ($existingWebsite && (int) $existingWebsite->user_id === (int) $user->id) ? ' ← actual' : '';
            $this->command->line(sprintf(
                '  %d. %s (ID: %d, Email: %s)%s',
                $index + 1,
                $user->name,
                $user->id,
                $user->email,
                $marker
            ));
        }

        $this->command->newLine();
        $default = $existingWebsite ? (string) $existingWebsite->user_id : '1';
        $prompt = $existingWebsite
            ? '¿Propietario del sitio? (número, ID, o Enter para mantener actual)'
            : '¿Qué usuario será el propietario del sitio? (número de lista o ID)';
        $userChoice = trim((string) $this->command->ask($prompt, $default));

        if ($userChoice === '') {
            return $existingWebsite ? (int) $existingWebsite->user_id : null;
        }

        if (!is_numeric($userChoice)) {
            $this->command->error('❌ Indica un número de lista (1, 2, …) o el ID del usuario.');
            return null;
        }

        $num = (int) $userChoice;
        $byIndex = $num >= 1 && $num <= $users->count() ? $users->get($num - 1)?->id : null;
        $byId = $users->firstWhere('id', $num)?->id;

        $userId = $byIndex ?? $byId;
        if (!$userId) {
            $this->command->error('❌ Usuario no encontrado.');
            return null;
        }

        return (int) $userId;
    }

    private function createLymanWebsite($userId)
    {
        $website = Website::updateOrCreate(
            ['slug' => 'lyman-sas'],
            [
                'user_id' => $userId,
                'name' => 'LYMAN SAS',
                'description' => 'Servicios logísticos y operativos especializados para la ejecución integral de proyectos',
                'domain' => null,
                'subdomain' => 'lyman-sas',
                'is_published' => true,
                'template_id' => null,
                'settings' => [
                    'company_name' => 'INVERSIONES LYMAN E.U.',
                    'phone' => '320 457 56 82',
                    'email' => 'info@lyman.com.co',
                    'website' => 'www.lyman.com.co',
                    'enable_store' => false, // Deshabilitar tienda virtual para este sitio
                ],
                'seo_settings' => [
                    'meta_title' => 'LYMAN SAS - Servicios Logísticos y Operativos',
                    'meta_description' => 'LYMAN SAS ofrece servicios logísticos y operativos especializados para la ejecución integral de proyectos. Cumplimiento, control y resultados verificables.',
                    'meta_keywords' => 'servicios logísticos, operaciones de campo, organización de eventos, importaciones internacionales, Colombia',
                ],
            ]
        );

        $this->command->info("✓ Sitio web creado: {$website->name} (ID: {$website->id})");

        return $website;
    }

    private function createHomePage($website)
    {
        $website->pages()->updateOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'Inicio',
                'meta_description' => 'LYMAN SAS - Servicios logísticos y operativos especializados',
                'is_published' => true,
                'is_home' => true,
                'enable_store' => false,
                'sort_order' => 1,
                'html_content' => $this->getHomePageHTML(),
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null,
            ]
        );
        $this->command->info('  ✓ Página Inicio creada');
    }

    private function createServicesPage($website)
    {
        $website->pages()->updateOrCreate(
            ['slug' => 'servicios'],
            [
                'title' => 'Servicios',
                'meta_description' => 'Servicios logísticos y operativos de LYMAN SAS',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 2,
                'html_content' => $this->getServicesPageHTML(),
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null,
            ]
        );
        $this->command->info('  ✓ Página Servicios creada');
    }

    private function createAboutPage($website)
    {
        $website->pages()->updateOrCreate(
            ['slug' => 'nosotros'],
            [
                'title' => 'Nosotros',
                'meta_description' => 'Conoce más sobre LYMAN SAS y nuestro equipo',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 3,
                'html_content' => $this->getAboutPageHTML(),
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null,
            ]
        );
        $this->command->info('  ✓ Página Nosotros creada');
    }

    private function createContactPage($website)
    {
        $website->pages()->updateOrCreate(
            ['slug' => 'contacto'],
            [
                'title' => 'Contacto',
                'meta_description' => 'Contáctenos - LYMAN SAS',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => 4,
                'html_content' => $this->getContactPageHTML(),
                'css_content' => $this->getCSS(),
                'grapesjs_data' => null,
            ]
        );
        $this->command->info('  ✓ Página Contacto creada');
    }

    private function getHomePageHTML()
    {
        return '
<!-- Hero: background-image + contenedores para título, párrafo y botones -->
<div class="background-image-section relative min-h-[700px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col items-center justify-center w-full gap-8 p-20 text-center container-flex">
        <div class="flex flex-col items-center w-full gap-6 container-flex">
            <h2 class="mb-6 font-extrabold text-white heading-component text-7xl">LYMAN SAS</h2>
            <p class="max-w-4xl mb-8 text-2xl leading-relaxed text-white paragraph-component">
                Servicios logísticos y operativos especializados para la ejecución integral de proyectos
            </p>
            <div class="flex flex-row items-center justify-center gap-4 container-flex">
                <a href="/lyman-sas/servicios" class="inline-block px-8 py-4 text-lg font-semibold text-white transition-colors rounded-lg shadow-lg button-component bg-emerald-600 hover:bg-emerald-700">Ver Servicios</a>
                <a href="/lyman-sas/contacto" class="inline-block px-8 py-4 text-lg font-semibold transition-colors bg-white border-2 rounded-lg shadow-lg button-component text-emerald-600 border-emerald-600 hover:bg-emerald-50">Contáctenos</a>
            </div>
        </div>
    </div>
</div>

<!-- Quiénes Somos: contenedor sección → dos contenedores (texto + imagen) -->
<div class="flex flex-col items-center gap-12 p-16 mx-auto bg-white container-flex md:flex-row max-w-7xl">
    <div class="flex flex-col w-full gap-6 container-flex">
        <h2 class="text-5xl font-bold text-gray-900 heading-component">Quiénes Somos</h2>
        <p class="text-xl leading-relaxed text-gray-700 paragraph-component">
            INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
        </p>
        <a href="/lyman-sas/nosotros" class="inline-block px-6 py-3 font-semibold text-white transition-colors rounded-lg button-component bg-emerald-600 hover:bg-emerald-700 w-fit">Conocer Más</a>
    </div>
    <div class="flex flex-col w-full gap-0 container-flex">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=400&fit=crop" alt="Oficina LYMAN" class="image-component w-full h-[400px] object-cover rounded-2xl shadow-lg">
    </div>
</div>

<!-- Nuestros Servicios: contenedor sección → intro (título + párrafo) + contenedor fila de 3 cards -->
<div class="flex flex-col gap-12 p-16 container-flex bg-gray-50">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-5xl font-bold text-center text-gray-900 heading-component">Nuestros Servicios</h2>
        <p class="max-w-2xl text-lg text-center text-gray-600 paragraph-component">
            Soluciones integrales diseñadas para satisfacer sus necesidades operativas
        </p>
    </div>
    <div class="flex flex-col w-full gap-8 mx-auto container-flex md:flex-row max-w-7xl">
        <div class="flex flex-col w-full gap-6 p-10 text-center transition-all bg-white shadow-lg container-flex rounded-2xl hover:shadow-xl">
            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400&h=300&fit=crop" alt="Organización de Eventos" class="object-cover w-full h-48 mb-4 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Organización de Eventos</h3>
            <p class="mb-4 text-base leading-relaxed text-gray-600 paragraph-component">Planificación y ejecución completa de eventos y actividades</p>
            <a href="/lyman-sas/servicios" class="inline-block px-6 py-3 font-semibold text-white transition-colors rounded-lg button-component bg-emerald-600 hover:bg-emerald-700">Ver Detalles</a>
        </div>
        <div class="flex flex-col w-full gap-6 p-10 text-center transition-all bg-white shadow-lg container-flex rounded-2xl hover:shadow-xl">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=400&h=300&fit=crop" alt="Servicios Logísticos" class="object-cover w-full h-48 mb-4 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Servicios Logísticos</h3>
            <p class="mb-4 text-base leading-relaxed text-gray-600 paragraph-component">Gestión integral de recursos, transporte y personal</p>
            <a href="/lyman-sas/servicios" class="inline-block px-6 py-3 font-semibold text-white transition-colors rounded-lg button-component bg-emerald-600 hover:bg-emerald-700">Ver Detalles</a>
        </div>
        <div class="flex flex-col w-full gap-6 p-10 text-center transition-all bg-white shadow-lg container-flex rounded-2xl hover:shadow-xl">
            <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=300&fit=crop" alt="Operaciones de Campo" class="object-cover w-full h-48 mb-4 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Operaciones de Campo</h3>
            <p class="mb-4 text-base leading-relaxed text-gray-600 paragraph-component">Implementación y supervisión de proyectos</p>
            <a href="/lyman-sas/servicios" class="inline-block px-6 py-3 font-semibold text-white transition-colors rounded-lg button-component bg-emerald-600 hover:bg-emerald-700">Ver Detalles</a>
        </div>
    </div>
</div>

<!-- Por qué elegirnos: contenedor sección → intro + contenedor fila de 3 stats -->
<div class="flex flex-col gap-12 p-16 bg-white container-flex">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-5xl font-bold text-center text-gray-900 heading-component">Por Qué Elegirnos</h2>
        <p class="max-w-3xl mb-8 text-lg text-center text-gray-600 paragraph-component">Nuestros diferenciadores nos convierten en el socio ideal para sus proyectos</p>
    </div>
    <div class="flex flex-col w-full max-w-6xl gap-8 mx-auto container-flex md:flex-row">
        <div class="flex flex-col w-full gap-4 p-8 text-center container-flex bg-emerald-50 rounded-xl">
            <h3 class="mb-2 text-3xl font-bold heading-component text-emerald-600">100%</h3>
            <h4 class="text-xl font-semibold text-gray-900 heading-component">Cumplimiento</h4>
            <p class="text-base text-gray-600 paragraph-component">Adherencia total a cronogramas</p>
        </div>
        <div class="flex flex-col w-full gap-4 p-8 text-center container-flex bg-emerald-50 rounded-xl">
            <h3 class="mb-2 text-3xl font-bold heading-component text-emerald-600">15+</h3>
            <h4 class="text-xl font-semibold text-gray-900 heading-component">Años</h4>
            <p class="text-base text-gray-600 paragraph-component">De experiencia comprobada</p>
        </div>
        <div class="flex flex-col w-full gap-4 p-8 text-center container-flex bg-emerald-50 rounded-xl">
            <h3 class="mb-2 text-3xl font-bold heading-component text-emerald-600">24/7</h3>
            <h4 class="text-xl font-semibold text-gray-900 heading-component">Disponibilidad</h4>
            <p class="text-base text-gray-600 paragraph-component">Soporte continuo</p>
        </div>
    </div>
</div>
';
    }

    private function getServicesPageHTML()
    {
        return '
<!-- Hero Servicios: background-image + contenedores -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col items-center w-full gap-8 p-20 text-center container-flex">
        <h2 class="mb-6 text-6xl font-bold text-white heading-component">Nuestros Servicios</h2>
        <p class="max-w-3xl text-xl leading-relaxed text-white paragraph-component">Soluciones integrales en tres áreas principales diseñadas para satisfacer sus necesidades operativas</p>
    </div>
</div>

<!-- Organización de Eventos: contenedor fila → imagen + contenedor (título, párrafo, lista) -->
<div class="flex flex-col items-center gap-12 p-16 mx-auto bg-white container-flex md:flex-row max-w-7xl">
    <div class="flex flex-col w-full gap-0 container-flex">
        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=500&fit=crop" alt="Organización de Eventos" class="image-component w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="flex flex-col w-full gap-6 container-flex">
        <h2 class="text-4xl font-bold text-gray-900 heading-component">Organización de Eventos</h2>
        <p class="text-lg leading-relaxed text-gray-700 paragraph-component">Planificación y ejecución completa de eventos, jornadas y actividades con atención a cada detalle.</p>
        <div class="flex flex-col gap-4 container-flex">
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Planeación estratégica personalizada</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Coordinación logística integral</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Supervisión continua en sitio</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Documentación audiovisual completa</p>
            </div>
        </div>
    </div>
</div>

<!-- Servicios Logísticos -->
<div class="flex flex-col items-center gap-12 p-16 mx-auto container-flex md:flex-row bg-gray-50 max-w-7xl">
    <div class="flex flex-col w-full gap-6 container-flex">
        <h2 class="text-4xl font-bold text-gray-900 heading-component">Servicios Logísticos</h2>
        <p class="text-lg leading-relaxed text-gray-700 paragraph-component">Gestión integral de recursos y operaciones para garantizar eficiencia en cada proyecto.</p>
        <div class="flex flex-col gap-4 container-flex">
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Personal especializado</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Transporte y movilización</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Infraestructura y montajes</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Alimentación y catering</p>
            </div>
        </div>
    </div>
    <div class="flex flex-col w-full gap-0 container-flex">
        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&h=500&fit=crop" alt="Servicios Logísticos" class="image-component w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
</div>

<!-- Operaciones de Campo -->
<div class="flex flex-col items-center gap-12 p-16 mx-auto bg-white container-flex md:flex-row max-w-7xl">
    <div class="flex flex-col w-full gap-0 container-flex">
        <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=600&h=500&fit=crop" alt="Operaciones de Campo" class="image-component w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="flex flex-col w-full gap-6 container-flex">
        <h2 class="text-4xl font-bold text-gray-900 heading-component">Operaciones de Campo</h2>
        <p class="text-lg leading-relaxed text-gray-700 paragraph-component">Implementación y supervisión de proyectos en terreno con control total y resultados verificables.</p>
        <div class="flex flex-col gap-4 container-flex">
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Supervisión continua</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Personal calificado</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Control de calidad riguroso</p>
            </div>
            <div class="flex flex-row items-start gap-3 container-flex">
                <span class="text-2xl">✓</span>
                <p class="text-base text-gray-600 paragraph-component">Gestión de riesgos</p>
            </div>
        </div>
    </div>
</div>
';
    }

    private function getAboutPageHTML()
    {
        return '
<!-- Hero Nosotros: background-image + contenedores -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col items-center w-full gap-8 p-20 text-center container-flex">
        <h2 class="mb-6 text-6xl font-bold text-white heading-component">Quiénes Somos</h2>
        <p class="max-w-2xl text-xl text-white paragraph-component">Conoce nuestra empresa y lo que nos hace diferentes</p>
    </div>
</div>

<!-- Nuestra Historia: contenedor fila → imagen + contenedor (título, párrafos) -->
<div class="flex flex-col items-center gap-12 p-16 mx-auto bg-white container-flex md:flex-row max-w-7xl">
    <div class="flex flex-col w-full gap-0 container-flex">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=500&fit=crop" alt="Nuestra Empresa" class="image-component w-full h-[500px] object-cover rounded-2xl shadow-xl">
    </div>
    <div class="flex flex-col w-full gap-6 container-flex">
        <h2 class="text-4xl font-bold text-gray-900 heading-component">Nuestra Historia</h2>
        <p class="text-lg leading-relaxed text-gray-700 paragraph-component">
            INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. 
            Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
        </p>
        <p class="text-lg leading-relaxed text-gray-700 paragraph-component">
            Con años de experiencia en el mercado, hemos consolidado nuestra posición como líderes en la gestión 
            y coordinación de proyectos complejos que requieren precisión y profesionalismo.
        </p>
    </div>
</div>

<!-- Nuestros Valores: contenedor sección → título + contenedor fila de 3 cards -->
<div class="flex flex-col gap-12 p-16 container-flex bg-gray-50">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-5xl font-bold text-center text-gray-900 heading-component">Nuestros Valores</h2>
    </div>
    <div class="flex flex-col w-full gap-8 mx-auto container-flex md:flex-row max-w-7xl">
        <div class="flex flex-col w-full gap-6 p-10 text-center bg-white shadow-lg container-flex rounded-2xl">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop" alt="Experiencia" class="object-cover w-full h-48 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Experiencia Comprobada</h3>
            <p class="text-base text-gray-600 paragraph-component">
                Años de trayectoria exitosa en servicios logísticos y operativos
            </p>
        </div>
        
        <div class="flex flex-col w-full gap-6 p-10 text-center bg-white shadow-lg container-flex rounded-2xl">
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop" alt="Cumplimiento" class="object-cover w-full h-48 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Cumplimiento Total</h3>
            <p class="text-base text-gray-600 paragraph-component">
                100% adherencia a cronogramas y especificaciones técnicas
            </p>
        </div>
        
        <div class="flex flex-col w-full gap-6 p-10 text-center bg-white shadow-lg container-flex rounded-2xl">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop" alt="Control" class="object-cover w-full h-48 rounded-lg image-component">
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Control Riguroso</h3>
            <p class="text-base text-gray-600 paragraph-component">
                Sistemas de seguimiento y documentación completa
            </p>
        </div>
    </div>
</div>

<!-- Cómo Lo Hacemos: contenedor sección → intro (título + párrafo) + contenedor pasos -->
<div class="flex flex-col max-w-6xl gap-12 p-16 mx-auto bg-white container-flex">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-5xl font-bold text-center text-gray-900 heading-component">Cómo Lo Hacemos</h2>
        <p class="max-w-3xl text-lg text-center text-gray-600 paragraph-component">Nuestra metodología garantiza resultados exitosos en cada proyecto</p>
    </div>
    <div class="flex flex-col gap-6 container-flex">
        <div class="flex flex-row items-start gap-6 p-6 container-flex bg-gray-50 rounded-xl">
            <div class="flex flex-col items-center justify-center flex-shrink-0 w-16 h-16 gap-0 text-white rounded-full container-flex bg-emerald-600">
                <span class="text-2xl font-bold">1</span>
            </div>
            <div class="flex flex-col gap-2 container-flex">
                <h3 class="text-xl font-bold text-gray-900 heading-component">Planeación</h3>
                <p class="text-base text-gray-600 paragraph-component">Análisis de necesidades y diseño de solución personalizada</p>
            </div>
        </div>
        
        <div class="flex flex-row items-start gap-6 p-6 container-flex bg-gray-50 rounded-xl">
            <div class="flex flex-col items-center justify-center flex-shrink-0 w-16 h-16 gap-0 text-white rounded-full container-flex bg-emerald-600">
                <span class="text-2xl font-bold">2</span>
            </div>
            <div class="flex flex-col gap-2 container-flex">
                <h3 class="text-xl font-bold text-gray-900 heading-component">Preparación</h3>
                <p class="text-base text-gray-600 paragraph-component">Coordinación de recursos, personal y logística</p>
            </div>
        </div>
        
        <div class="flex flex-row items-start gap-6 p-6 container-flex bg-gray-50 rounded-xl">
            <div class="flex flex-col items-center justify-center flex-shrink-0 w-16 h-16 gap-0 text-white rounded-full container-flex bg-emerald-600">
                <span class="text-2xl font-bold">3</span>
            </div>
            <div class="flex flex-col gap-2 container-flex">
                <h3 class="text-xl font-bold text-gray-900 heading-component">Ejecución</h3>
                <p class="text-base text-gray-600 paragraph-component">Implementación en campo con supervisión continua</p>
            </div>
        </div>
        
        <div class="flex flex-row items-start gap-6 p-6 container-flex bg-gray-50 rounded-xl">
            <div class="flex flex-col items-center justify-center flex-shrink-0 w-16 h-16 gap-0 text-white rounded-full container-flex bg-emerald-600">
                <span class="text-2xl font-bold">4</span>
            </div>
            <div class="flex flex-col gap-2 container-flex">
                <h3 class="text-xl font-bold text-gray-900 heading-component">Control</h3>
                <p class="text-base text-gray-600 paragraph-component">Monitoreo en tiempo real y ajustes inmediatos</p>
            </div>
        </div>
        
        <div class="flex flex-row items-start gap-6 p-6 container-flex bg-gray-50 rounded-xl">
            <div class="flex flex-col items-center justify-center flex-shrink-0 w-16 h-16 gap-0 text-white rounded-full container-flex bg-emerald-600">
                <span class="text-2xl font-bold">5</span>
            </div>
            <div class="flex flex-col gap-2 container-flex">
                <h3 class="text-xl font-bold text-gray-900 heading-component">Cierre</h3>
                <p class="text-base text-gray-600 paragraph-component">Documentación completa y entrega de resultados</p>
            </div>
        </div>
    </div>
</div>
';
    }

    private function getContactPageHTML()
    {
        return '
<!-- Hero Contacto: background-image + contenedores -->
<div class="background-image-section relative min-h-[400px] flex items-center justify-center bg-cover bg-center bg-no-repeat" data-gjs-type="background-image" style="background-image: url(\'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&h=1080&fit=crop\');">
    <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
    <div class="relative z-10 flex flex-col items-center w-full gap-8 p-20 text-center container-flex">
        <h2 class="mb-6 text-6xl font-bold text-white heading-component">Contáctenos</h2>
        <p class="max-w-2xl text-xl text-white paragraph-component">Estamos listos para hacer realidad sus proyectos. Hablemos hoy.</p>
    </div>
</div>

<!-- Información de Contacto: contenedor sección → título + contenedor fila de 3 cards -->
<div class="flex flex-col gap-12 p-16 mx-auto bg-white container-flex max-w-7xl">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-4xl font-bold text-center text-gray-900 heading-component">Información de Contacto</h2>
    </div>
    <div class="flex flex-col w-full gap-8 container-flex md:flex-row">
        <div class="flex flex-col w-full gap-6 p-10 text-center shadow-lg container-flex bg-gradient-to-br from-emerald-50 to-green-100 rounded-2xl">
            <div class="flex flex-col items-center justify-center w-20 h-20 gap-0 mx-auto text-white rounded-full container-flex bg-emerald-600">
                <span class="text-3xl">📞</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Teléfono</h3>
            <p class="text-xl font-semibold text-gray-900 paragraph-component">
                320 457 56 82
            </p>
            <p class="text-sm text-gray-600 paragraph-component">
                Lunes a Viernes: 8:00 AM - 6:00 PM
            </p>
        </div>
        
        <div class="flex flex-col w-full gap-6 p-10 text-center shadow-lg container-flex bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl">
            <div class="flex flex-col items-center justify-center w-20 h-20 gap-0 mx-auto text-white bg-blue-600 rounded-full container-flex">
                <span class="text-3xl">✉️</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Email</h3>
            <p class="text-xl font-semibold text-gray-900 paragraph-component">
                info@lyman.com.co
            </p>
            <p class="text-sm text-gray-600 paragraph-component">
                Respuesta en 24 horas
            </p>
        </div>
        
        <div class="flex flex-col w-full gap-6 p-10 text-center shadow-lg container-flex bg-gradient-to-br from-purple-50 to-pink-100 rounded-2xl">
            <div class="flex flex-col items-center justify-center w-20 h-20 gap-0 mx-auto text-white bg-purple-600 rounded-full container-flex">
                <span class="text-3xl">🌐</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 heading-component">Sitio Web</h3>
            <p class="text-xl font-semibold text-gray-900 paragraph-component">
                www.lyman.com.co
            </p>
            <a href="https://www.lyman.com.co" target="_blank" class="inline-block px-6 py-2 font-semibold text-white transition-colors bg-purple-600 rounded-lg button-component hover:bg-purple-700">
                Visitar Sitio
            </a>
        </div>
    </div>
</div>

<!-- Mapa de Ubicación: contenedor sección → título + contenedor mapa + párrafo -->
<div class="flex flex-col gap-8 p-16 container-flex bg-gray-50">
    <div class="flex flex-col items-center w-full gap-4 container-flex">
        <h2 class="text-4xl font-bold text-center text-gray-900 heading-component">Nuestra Ubicación</h2>
    </div>
    <div class="flex flex-col w-full gap-0 mx-auto overflow-hidden shadow-xl container-flex max-w-7xl rounded-2xl">
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
    <p class="max-w-2xl mx-auto text-lg text-center text-gray-600 paragraph-component">
        Bogotá, Colombia - Cobertura nacional en servicios logísticos y operativos
    </p>
</div>

<!-- Call to Action Final: contenedor con título, párrafo y botón -->
<div class="flex flex-col items-center gap-8 p-20 text-center container-flex bg-emerald-600">
    <h2 class="mb-4 text-5xl font-bold text-white heading-component">¿Listo para Comenzar?</h2>
    <p class="max-w-2xl mb-6 text-xl text-white paragraph-component">Contáctenos hoy y descubra cómo podemos ayudarle a alcanzar sus objetivos</p>
    <a href="tel:3204575682" class="inline-block px-10 py-4 text-xl font-bold transition-colors bg-white rounded-lg shadow-xl button-component text-emerald-600 hover:bg-gray-100">Llamar Ahora</a>
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
