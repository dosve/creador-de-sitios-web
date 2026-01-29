<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Website;

class LymanSasPageSeeder extends Seeder
{
    /**
     * Crear sitio web completo de LYMAN SAS con diseño moderno, minimalista y colores suaves
     */
    public function run(): void
    {
        $this->command->info('🚀 Creando sitio web completo de LYMAN SAS');
        $this->command->newLine();

        // Verificar si ya existe el sitio
        $existingWebsite = Website::where('slug', 'lyman-sas')->first();

        if ($existingWebsite) {
            $this->command->warn('⚠️  Ya existe un sitio con el slug "lyman-sas"');
            if (!$this->command->confirm('¿Deseas actualizarlo?', true)) {
                $this->command->info('❌ Operación cancelada.');
                return;
            }
            $website = $existingWebsite;
        } else {
            // Obtener usuarios disponibles para asignar el sitio
            $users = \App\Models\User::all();

            if ($users->isEmpty()) {
                $this->command->error('❌ No hay usuarios disponibles. Crea un usuario primero.');
                return;
            }

            // Mostrar usuarios disponibles
            $this->command->info('📋 Usuarios disponibles:');
            foreach ($users as $index => $user) {
                $this->command->line(sprintf(
                    '  %d. %s (ID: %d, Email: %s)',
                    $index + 1,
                    $user->name,
                    $user->id,
                    $user->email
                ));
            }

            $this->command->newLine();
            $userChoice = $this->command->ask('¿Qué usuario será el propietario del sitio? (número o ID)', '1');

            $userId = null;
            if (is_numeric($userChoice)) {
                $index = (int)$userChoice - 1;
                $selectedUser = $users->get($index);
                $userId = $selectedUser ? $selectedUser->id : null;
            } else {
                $selectedUser = $users->firstWhere('id', $userChoice);
                $userId = $selectedUser ? $selectedUser->id : null;
            }

            if (!$userId) {
                $this->command->error('❌ Usuario no encontrado.');
                return;
            }

            // Crear el sitio web
            $website = $this->createLymanWebsite($userId);
        }

        $this->command->newLine();
        $this->command->info('📄 Creando página principal del sitio...');

        // Crear la página principal (home)
        $this->createLymanHomePage($website);

        $this->command->newLine();
        $this->command->info('✅ Sitio web de LYMAN SAS creado exitosamente!');
        $this->command->info("   🌐 Slug: {$website->slug}");
        $this->command->info("   📝 Página principal: Inicio (home)");
        $this->command->info("   👤 Propietario: {$website->user->name} (ID: {$website->user_id})");
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

    private function createLymanHomePage($website)
    {
        // Primero, desmarcar cualquier otra página como home
        $website->pages()->update(['is_home' => false]);

        // Crear o actualizar la página principal
        $page = $website->pages()->updateOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'Inicio - LYMAN SAS',
                'meta_description' => 'LYMAN SAS ofrece servicios logísticos y operativos especializados para la ejecución integral de proyectos. Cumplimiento, control y resultados verificables.',
                'is_published' => true,
                'is_home' => true, // Esta es la página principal
                'enable_store' => false,
                'sort_order' => 1,
                'html_content' => $this->getLymanPageHTML(),
                'css_content' => $this->getLymanPageCSS(),
                'grapesjs_data' => null, // GrapesJS parseará el HTML automáticamente
            ]
        );

        $this->command->info("✓ Página principal creada: {$page->title} (ID: {$page->id}, slug: {$page->slug})");
    }

    private function getLymanPageHTML()
    {
        return '
    <!-- Hero Section -->
    <div class="container-flex flex flex-col gap-8 items-center justify-center text-center p-16 bg-gradient-to-br from-green-50 to-emerald-100 min-h-[500px]">
        <h1 class="heading-component text-6xl font-extrabold text-gray-900 mb-4">LYMAN SAS</h1>
        <p class="paragraph-component text-2xl leading-relaxed text-gray-700 max-w-4xl">
            Servicios logísticos y operativos especializados para la ejecución integral de proyectos. 
            Nos destacamos por nuestra capacidad de gestión, coordinación y supervisión en cada fase operativa.
        </p>
    </div>

    <!-- Quiénes Somos -->
    <div class="container-flex flex flex-col gap-6 items-center text-center p-16 bg-white">
        <h2 class="heading-component text-5xl font-bold text-gray-900 mb-4">Quiénes Somos</h2>
        <p class="paragraph-component text-xl leading-relaxed text-gray-700 max-w-3xl">
            INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. 
            Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.
        </p>
    </div>

    <!-- Nuestros Servicios -->
    <div class="container-flex flex flex-col gap-8 items-center text-center p-16 bg-gray-50">
        <h2 class="heading-component text-5xl font-bold text-gray-900 mb-4">Nuestros Servicios</h2>
        <p class="paragraph-component text-lg leading-relaxed text-gray-600 max-w-2xl mb-8">
            Soluciones integrales en tres áreas principales, diseñadas para satisfacer las necesidades operativas.
        </p>
        
        <!-- Grid de Servicios -->
        <div class="container-flex flex flex-col md:flex-row gap-6 w-full max-w-7xl">
            <!-- Servicio 1 -->
            <div class="container-flex flex flex-col gap-4 p-8 bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow text-center">
                <h3 class="heading-component text-2xl font-bold text-gray-900">Organización de Eventos</h3>
                <p class="paragraph-component text-base leading-relaxed text-gray-600">
                    Planificación y ejecución completa de eventos y actividades
                </p>
            </div>
            
            <!-- Servicio 2 -->
            <div class="container-flex flex flex-col gap-4 p-8 bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow text-center">
                <h3 class="heading-component text-2xl font-bold text-gray-900">Servicios Logísticos</h3>
                <p class="paragraph-component text-base leading-relaxed text-gray-600">
                    Gestión integral de recursos, transporte, personal e infraestructura
                </p>
            </div>
            
            <!-- Servicio 3 -->
            <div class="container-flex flex flex-col gap-4 p-8 bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow text-center">
                <h3 class="heading-component text-2xl font-bold text-gray-900">Operaciones de Campo</h3>
                <p class="paragraph-component text-base leading-relaxed text-gray-600">
                    Implementación y supervisión de proyectos en terreno
                </p>
            </div>
        </div>
    </div>

    <!-- Organización de Eventos -->
    <section class="lyman-section lyman-detail">
        <div class="lyman-container">
            <div class="lyman-detail-content">
                <span class="lyman-section-label">Servicio Especializado</span>
                <h2 class="lyman-section-title">Organización de Eventos</h2>
                <p class="paragraph-component lyman-detail-text text-lg" data-gjs-type="paragraph" data-gjs-editable="false">
                    Planificación y ejecución completa de eventos, jornadas y actividades con atención a cada detalle.
                </p>
                <div class="lyman-features-grid">
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Planeación Estratégica</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Diseño personalizado según objetivos del evento</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M12 1v6m0 6v6M23 12h-6M7 12H1"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Coordinación Logística</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Gestión de recursos, personal y proveedores</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Ejecución en Sitio</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Supervisión continua y atención a detalles</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Documentación</h3>
                        <p class="paragraph-component lyman-feature-desc" data-gjs-type="paragraph" data-gjs-editable="false">Registro audiovisual e informes completos</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios Logísticos -->
    <section class="lyman-section lyman-detail lyman-alt">
        <div class="lyman-container">
            <div class="lyman-detail-content">
                <span class="lyman-section-label">Servicio Especializado</span>
                <h2 class="lyman-section-title">Servicios Logísticos</h2>
                <p class="paragraph-component lyman-detail-text text-lg" data-gjs-type="paragraph" data-gjs-editable="false">
                    Gestión integral de recursos y operaciones para garantizar eficiencia en cada proyecto.
                </p>
                <div class="lyman-services-grid-2">
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Personal Especializado</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Coordinadores, operadores y personal calificado</p>
                    </div>
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Transporte</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Soluciones de movilización terrestre con cobertura nacional</p>
                    </div>
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <line x1="3" y1="9" x2="21" y2="9"/>
                                <line x1="9" y1="21" x2="9" y2="9"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Infraestructura</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Tarimas, carpas, mobiliario y montajes</p>
                    </div>
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                <line x1="3" y1="6" x2="21" y2="6"/>
                                <path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Alimentación</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Catering, refrigerios e hidratación</p>
                    </div>
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Dotaciones</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Uniformes, identificación y EPP</p>
                    </div>
                    <div class="lyman-service-mini">
                        <div class="lyman-service-mini-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 12 22 12 11 5"/>
                            </svg>
                        </div>
                        <h3 class="lyman-service-mini-title">Apoyo Técnico</h3>
                        <p class="paragraph-component lyman-service-mini-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Sonido, iluminación y equipos audiovisuales</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Operaciones de Campo -->
    <section class="lyman-section lyman-detail">
        <div class="lyman-container">
            <div class="lyman-detail-content">
                <span class="lyman-section-label">Servicio Especializado</span>
                <h2 class="lyman-section-title">Operaciones de Campo</h2>
                <p class="paragraph-component lyman-detail-text" data-gjs-type="paragraph" data-gjs-editable="false">
                    Implementación y supervisión de proyectos en terreno con control total y resultados verificables.
                </p>
                <div class="lyman-features-grid">
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                <line x1="8" y1="21" x2="16" y2="21"/>
                                <line x1="12" y1="17" x2="12" y2="21"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Supervisión Continua</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Monitoreo en tiempo real de todas las actividades</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Personal Calificado</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Equipos especializados para cada tipo de operación</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Control de Calidad</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Verificación constante de estándares y cumplimiento</p>
                    </div>
                    <div class="lyman-feature-card">
                        <div class="lyman-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M10.29 3.86L1 12l9.29 8.14a1 1 0 0 0 1.42 0l9.29-8.14L12 3.86a1 1 0 0 0-1.42 0z"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <line x1="12" y1="2" x2="12" y2="22"/>
                            </svg>
                        </div>
                        <h3 class="lyman-feature-title">Gestión de Riesgos</h3>
                        <p class="paragraph-component lyman-feature-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Protocolos de seguridad y respuesta inmediata</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Importaciones Internacionales -->
    <section class="lyman-section lyman-detail lyman-alt">
        <div class="lyman-container">
            <div class="lyman-detail-content">
                <span class="lyman-section-label">Servicio Especializado</span>
                <h2 class="lyman-section-title">Importaciones Internacionales</h2>
                <p class="paragraph-component lyman-detail-text text-lg" data-gjs-type="paragraph" data-gjs-editable="false">
                    En LYMAN SAS, ofrecemos un servicio integral de importación desde los mercados globales más importantes, 
                    como China, Alemania y Estados Unidos. Facilitamos cada etapa del proceso para asegurar que sus productos 
                    lleguen de manera eficiente y segura.
                </p>
                <div class="lyman-imports-grid">
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <line x1="3" y1="9" x2="21" y2="9"/>
                                <line x1="9" y1="21" x2="9" y2="9"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Importación China</h3>
                        <p class="paragraph-component lyman-import-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Acceso a manufactura avanzada y tecnología de punta.</p>
                    </div>
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M12 1v6m0 6v6M23 12h-6M7 12H1"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Importación Alemania</h3>
                        <p class="paragraph-component lyman-import-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Maquinaria y equipos de precisión con alta ingeniería.</p>
                    </div>
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Importación USA</h3>
                        <p class="paragraph-component lyman-import-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Productos tecnológicos y especializados de vanguardia.</p>
                    </div>
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Gestión Aduanera</h3>
                        <p class="paragraph-component lyman-import-desc" data-gjs-type="paragraph" data-gjs-editable="false">Asesoría y manejo de toda la documentación aduanera.</p>
                    </div>
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Control de Calidad</h3>
                        <p class="paragraph-component lyman-import-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Verificación y supervisión rigurosa de sus productos.</p>
                    </div>
                    <div class="lyman-import-card">
                        <div class="lyman-import-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <h3 class="lyman-import-title">Logística Puerta a Puerta</h3>
                        <p class="paragraph-component lyman-import-desc text-sm" data-gjs-type="paragraph" data-gjs-editable="false">Soluciones de transporte desde origen hasta su destino final.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Lo Hacemos -->
    <section class="lyman-section lyman-process">
        <div class="lyman-container">
            <div class="lyman-section-header">
                <span class="lyman-section-label">Nuestra Metodología</span>
                <h2 class="lyman-section-title">Cómo Lo Hacemos</h2>
                <p class="paragraph-component lyman-section-subtitle text-xl" data-gjs-type="paragraph" data-gjs-editable="false">
                    Nuestra metodología garantiza resultados exitosos en cada proyecto.
                </p>
            </div>
            <div class="lyman-process-steps">
                <div class="lyman-process-step">
                    <div class="lyman-step-number">1</div>
                    <div class="lyman-step-content">
                        <h3 class="lyman-step-title">Planeación</h3>
                        <p class="paragraph-component lyman-step-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Análisis de necesidades y diseño de solución personalizada</p>
                    </div>
                </div>
                <div class="lyman-process-step">
                    <div class="lyman-step-number">2</div>
                    <div class="lyman-step-content">
                        <h3 class="lyman-step-title">Preparación</h3>
                        <p class="paragraph-component lyman-step-desc" data-gjs-type="paragraph" data-gjs-editable="false">Coordinación de recursos, personal y logística</p>
                    </div>
                </div>
                <div class="lyman-process-step">
                    <div class="lyman-step-number">3</div>
                    <div class="lyman-step-content">
                        <h3 class="lyman-step-title">Ejecución</h3>
                        <p class="paragraph-component lyman-step-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Implementación en campo con supervisión continua</p>
                    </div>
                </div>
                <div class="lyman-process-step">
                    <div class="lyman-step-number">4</div>
                    <div class="lyman-step-content">
                        <h3 class="lyman-step-title">Control</h3>
                        <p class="paragraph-component lyman-step-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Monitoreo en tiempo real y ajustes inmediatos</p>
                    </div>
                </div>
                <div class="lyman-process-step">
                    <div class="lyman-step-number">5</div>
                    <div class="lyman-step-content">
                        <h3 class="lyman-step-title">Cierre</h3>
                        <p class="paragraph-component lyman-step-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Documentación completa y entrega de resultados</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Por Qué Elegirnos -->
    <section class="lyman-section lyman-why">
        <div class="lyman-container">
            <div class="lyman-section-header">
                <span class="lyman-section-label">Nuestros Valores</span>
                <h2 class="lyman-section-title">Por Qué Elegirnos</h2>
                <p class="paragraph-component lyman-section-subtitle text-xl" data-gjs-type="paragraph" data-gjs-editable="false">
                    Nuestros diferenciadores nos convierten en el socio ideal para sus proyectos.
                </p>
            </div>
            <div class="lyman-why-grid">
                <div class="lyman-why-card">
                    <div class="lyman-why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3 class="lyman-why-title">Experiencia Comprobada</h3>
                    <p class="paragraph-component lyman-why-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Años de trayectoria en servicios logísticos</p>
                </div>
                <div class="lyman-why-card">
                    <div class="lyman-why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3 class="lyman-why-title">Cumplimiento Total</h3>
                    <p class="paragraph-component lyman-why-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">100% adherencia a cronogramas y especificaciones técnicas</p>
                </div>
                <div class="lyman-why-card">
                    <div class="lyman-why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <h3 class="lyman-why-title">Control Riguroso</h3>
                    <p class="paragraph-component lyman-why-desc text-base" data-gjs-type="paragraph" data-gjs-editable="false">Sistemas de seguimiento y documentación completa</p>
                </div>
                <div class="lyman-why-card">
                    <div class="lyman-why-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="lyman-why-title">Equipo Especializado</h3>
                    <p class="paragraph-component lyman-why-desc" data-gjs-type="paragraph" data-gjs-editable="false">Personal calificado y capacitado para cada proyecto</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contáctenos -->
    <section class="lyman-section lyman-contact">
        <div class="lyman-container">
            <div class="lyman-contact-content">
                <span class="lyman-section-label">Estamos Listos</span>
                <h2 class="lyman-section-title">Contáctenos</h2>
                <p class="paragraph-component lyman-contact-text text-xl" data-gjs-type="paragraph" data-gjs-editable="false">
                    Estamos listos para hacer realidad sus proyectos. Contáctenos hoy mismo para empezar.
                </p>
                <div class="lyman-contact-info">
                    <a href="tel:3204575682" class="lyman-contact-item">
                        <div class="lyman-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="lyman-contact-label">Teléfono</div>
                            <div class="lyman-contact-value">320 457 56 82</div>
                        </div>
                    </a>
                    <a href="mailto:info@lyman.com.co" class="lyman-contact-item">
                        <div class="lyman-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="lyman-contact-label">Email</div>
                            <div class="lyman-contact-value">info@lyman.com.co</div>
                        </div>
                    </a>
                    <a href="https://www.lyman.com.co" target="_blank" class="lyman-contact-item">
                        <div class="lyman-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="lyman-contact-label">Sitio Web</div>
                            <div class="lyman-contact-value">www.lyman.com.co</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>';
    }

    private function getLymanPageCSS()
    {
        return '
/* LYMAN SAS - Diseño Moderno y Minimalista */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;
    line-height: 1.7;
    color: #2d3748;
    background-color: #ffffff;
    font-size: 16px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Container */
.lyman-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Sections */
.lyman-section {
    padding: 6rem 0;
}

.lyman-section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.lyman-section-label {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #4CAF50;
    margin-bottom: 1rem;
    padding: 0.5rem 1.25rem;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 50px;
}

.lyman-section-title {
    font-size: 3rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.lyman-section-subtitle {
    color: #718096;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Hero Section */
.lyman-hero {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    padding: 8rem 0;
    text-align: center;
}

.lyman-hero-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 2rem;
}

.lyman-hero-badge {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #4CAF50;
    margin-bottom: 2rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.lyman-hero-title {
    font-size: 4.5rem;
    font-weight: 800;
    color: #1a202c;
    margin-bottom: 2rem;
    letter-spacing: -0.03em;
    line-height: 1.1;
}

.lyman-hero-description {
    color: #4a5568;
    line-height: 1.8;
    max-width: 800px;
    margin: 0 auto;
}

.lyman-hero-description strong {
    color: #304739;
    font-weight: 600;
}

/* About Section */
.lyman-about {
    background: #ffffff;
}

.lyman-about-text {
    font-size: 1.25rem;
    color: #4a5568;
    line-height: 1.8;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

/* Services Section */
.lyman-services {
    background: #f9fafb;
}

.lyman-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.lyman-service-card {
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.lyman-service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    border-color: #4CAF50;
}

.lyman-service-card-icon {
    width: 56px;
    height: 56px;
    margin-bottom: 1.5rem;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 12px;
}

.lyman-service-card-icon svg {
    width: 28px;
    height: 28px;
}

.lyman-service-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.75rem;
    letter-spacing: -0.01em;
}

.lyman-service-card-desc {
    color: #718096;
    line-height: 1.6;
}

/* Detail Sections */
.lyman-detail {
    background: #ffffff;
}

.lyman-detail.lyman-alt {
    background: #f9fafb;
}

.lyman-detail-content {
    max-width: 1000px;
    margin: 0 auto;
}

.lyman-detail-text {
    color: #4a5568;
    line-height: 1.8;
    margin-bottom: 3rem;
    text-align: center;
}

/* Features Grid */
.lyman-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.lyman-feature-card {
    background: #ffffff;
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.lyman-feature-card:hover {
    border-color: #4CAF50;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
}

.lyman-feature-icon {
    width: 48px;
    height: 48px;
    margin-bottom: 1rem;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 10px;
}

.lyman-feature-icon svg {
    width: 24px;
    height: 24px;
}

.lyman-feature-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.lyman-feature-desc {
    color: #718096;
    line-height: 1.6;
}

/* Services Grid 2 */
.lyman-services-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.lyman-service-mini {
    background: #ffffff;
    padding: 1.75rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.lyman-service-mini:hover {
    border-color: #4CAF50;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
}

.lyman-service-mini-icon {
    width: 40px;
    height: 40px;
    margin-bottom: 1rem;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 8px;
}

.lyman-service-mini-icon svg {
    width: 20px;
    height: 20px;
}

.lyman-service-mini-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.lyman-service-mini-desc {
    font-size: 0.9375rem;
    color: #718096;
    line-height: 1.6;
}

/* Imports Grid */
.lyman-imports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.lyman-import-card {
    background: #ffffff;
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.lyman-import-card:hover {
    border-color: #4CAF50;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
}

.lyman-import-icon {
    width: 48px;
    height: 48px;
    margin-bottom: 1rem;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 10px;
}

.lyman-import-icon svg {
    width: 24px;
    height: 24px;
}

.lyman-import-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.lyman-import-desc {
    color: #718096;
    line-height: 1.6;
}

/* Process Section */
.lyman-process {
    background: #ffffff;
}

.lyman-process-steps {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

.lyman-process-step {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    position: relative;
}

.lyman-process-step:not(:last-child)::after {
    content: "";
    position: absolute;
    left: 28px;
    top: 64px;
    width: 2px;
    height: calc(100% + 1rem);
    background: linear-gradient(to bottom, #4CAF50, rgba(76, 175, 80, 0.2));
}

.lyman-step-number {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    position: relative;
    z-index: 1;
}

.lyman-step-content {
    flex: 1;
    padding-top: 0.5rem;
}

.lyman-step-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
    letter-spacing: -0.01em;
}

.lyman-step-desc {
    color: #718096;
    line-height: 1.6;
}

/* Why Section */
.lyman-why {
    background: #f9fafb;
}

.lyman-why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.lyman-why-card {
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
    text-align: center;
}

.lyman-why-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    border-color: #4CAF50;
}

.lyman-why-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.5rem;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 16px;
}

.lyman-why-icon svg {
    width: 32px;
    height: 32px;
}

.lyman-why-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.75rem;
}

.lyman-why-desc {
    color: #718096;
    line-height: 1.6;
}

/* Contact Section */
.lyman-contact {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

.lyman-contact-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.lyman-contact-content .lyman-section-label {
    margin-bottom: 1.5rem;
}

.lyman-contact-content .lyman-section-title {
    margin-bottom: 1.5rem;
}

.lyman-contact-text {
    color: #4a5568;
    line-height: 1.8;
    margin-bottom: 3rem;
    margin-top: 1rem;
}

.lyman-contact-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.lyman-contact-item {
    background: #ffffff;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
    min-width: 0;
    overflow: hidden;
}

.lyman-contact-item > div:last-child {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.lyman-contact-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    border-color: #4CAF50;
}

.lyman-contact-icon {
    width: 56px;
    height: 56px;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 12px;
    flex-shrink: 0;
}

.lyman-contact-icon svg {
    width: 28px;
    height: 28px;
}

.lyman-contact-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.lyman-contact-value {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1a202c;
    word-break: keep-all;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive Design */
@media (max-width: 968px) {
    .lyman-hero-title {
        font-size: 3rem;
    }
    
    .lyman-section-title {
        font-size: 2.25rem;
    }
    
    .lyman-hero {
        padding: 5rem 0;
    }
    
    .lyman-section {
        padding: 4rem 0;
    }
    
    .lyman-services-grid,
    .lyman-why-grid {
        grid-template-columns: 1fr;
    }
    
    .lyman-features-grid,
    .lyman-services-grid-2,
    .lyman-imports-grid {
        grid-template-columns: 1fr;
    }
    
    .lyman-contact-info {
        grid-template-columns: 1fr;
    }
    
    .lyman-process-step {
        gap: 1.5rem;
    }
    
    .lyman-step-number {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    
    .lyman-process-step:not(:last-child)::after {
        left: 24px;
        top: 56px;
    }
}

@media (max-width: 640px) {
    .lyman-container {
        padding: 0 1.5rem;
    }
    
    .lyman-hero-title {
        font-size: 2.5rem;
    }
    
    .lyman-section-title {
        font-size: 2rem;
    }
    
    
    .lyman-service-card,
    .lyman-why-card {
        padding: 2rem;
    }
}';
    }
    
    private function getGrapesJSData()
    {
        // Estructura moderna con todos los componentes del editor
        $components = [
            // 1. Hero Section
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-8 p-12 lyman-hero text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h1',
                        'attributes' => [
                            'class' => 'heading-component text-6xl font-extrabold text-gray-900 mb-6',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'LYMAN SAS'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-2xl leading-relaxed text-gray-700 max-w-4xl mx-auto',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Servicios logísticos y operativos especializados para la ejecución integral de proyectos. Nos destacamos por nuestra capacidad de gestión, coordinación y supervisión en cada fase operativa.'
                    ]
                ]
            ],
            
            // 2. Quiénes Somos
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-6 p-12 bg-gray-50 text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h2',
                        'attributes' => [
                            'class' => 'heading-component text-4xl font-bold text-gray-900 mb-6',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Quiénes Somos'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-xl leading-relaxed text-gray-700 max-w-3xl mx-auto',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'INVERSIONES LYMAN E.U. es una empresa especializada en servicios logísticos y operativos. Nos dedicamos a la ejecución integral de proyectos con enfoque en cumplimiento, control y resultados verificables.'
                    ]
                ]
            ],
            
            // 3. Nuestros Servicios - Título
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-6 p-12 text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h2',
                        'attributes' => [
                            'class' => 'heading-component text-4xl font-bold text-gray-900 mb-4',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Nuestros Servicios'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-lg leading-relaxed text-gray-600 max-w-2xl mx-auto mb-8',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Soluciones integrales en tres áreas principales, diseñadas para satisfacer las necesidades operativas.'
                    ]
                ]
            ],
            
            // 3.1 Grid de Servicios - Fila con 3 contenedores
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col md:flex-row gap-6 p-6 max-w-7xl mx-auto',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    // Servicio 1
                    [
                        'type' => 'container',
                        'name' => 'Contenedor',
                        'tagName' => 'div',
                        'attributes' => [
                            'class' => 'container-flex flex flex-col gap-4 p-8 bg-white rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow',
                            'data-gjs-name' => 'Contenedor',
                            'data-gjs-editable' => 'false'
                        ],
                        'components' => [
                            [
                                'type' => 'heading',
                                'name' => 'Título',
                                'tagName' => 'h3',
                                'attributes' => [
                                    'class' => 'heading-component text-2xl font-bold text-gray-900 mb-3',
                                    'data-gjs-name' => 'Título',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Organización de Eventos'
                            ],
                            [
                                'type' => 'paragraph',
                                'name' => 'Párrafo',
                                'tagName' => 'p',
                                'attributes' => [
                                    'class' => 'paragraph-component text-base leading-relaxed text-gray-600',
                                    'data-gjs-name' => 'Párrafo',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Planificación y ejecución completa de eventos y actividades'
                            ]
                        ]
                    ],
                    // Servicio 2
                    [
                        'type' => 'container',
                        'name' => 'Contenedor',
                        'tagName' => 'div',
                        'attributes' => [
                            'class' => 'container-flex flex flex-col gap-4 p-8 bg-white rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow',
                            'data-gjs-name' => 'Contenedor',
                            'data-gjs-editable' => 'false'
                        ],
                        'components' => [
                            [
                                'type' => 'heading',
                                'name' => 'Título',
                                'tagName' => 'h3',
                                'attributes' => [
                                    'class' => 'heading-component text-2xl font-bold text-gray-900 mb-3',
                                    'data-gjs-name' => 'Título',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Servicios Logísticos'
                            ],
                            [
                                'type' => 'paragraph',
                                'name' => 'Párrafo',
                                'tagName' => 'p',
                                'attributes' => [
                                    'class' => 'paragraph-component text-base leading-relaxed text-gray-600',
                                    'data-gjs-name' => 'Párrafo',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Gestión integral de recursos, transporte, personal e infraestructura'
                            ]
                        ]
                    ],
                    // Servicio 3
                    [
                        'type' => 'container',
                        'name' => 'Contenedor',
                        'tagName' => 'div',
                        'attributes' => [
                            'class' => 'container-flex flex flex-col gap-4 p-8 bg-white rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow',
                            'data-gjs-name' => 'Contenedor',
                            'data-gjs-editable' => 'false'
                        ],
                        'components' => [
                            [
                                'type' => 'heading',
                                'name' => 'Título',
                                'tagName' => 'h3',
                                'attributes' => [
                                    'class' => 'heading-component text-2xl font-bold text-gray-900 mb-3',
                                    'data-gjs-name' => 'Título',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Operaciones de Campo'
                            ],
                            [
                                'type' => 'paragraph',
                                'name' => 'Párrafo',
                                'tagName' => 'p',
                                'attributes' => [
                                    'class' => 'paragraph-component text-base leading-relaxed text-gray-600',
                                    'data-gjs-name' => 'Párrafo',
                                    'data-gjs-editable' => 'false'
                                ],
                                'content' => 'Implementación y supervisión de proyectos en terreno'
                            ]
                        ]
                    ]
                ]
            ],
            
            // 4. Cómo lo Hacemos
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-6 p-12 bg-gray-50 text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h2',
                        'attributes' => [
                            'class' => 'heading-component text-4xl font-bold text-gray-900 mb-6',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Cómo Lo Hacemos'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-lg leading-relaxed text-gray-600 max-w-2xl mx-auto',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Nuestra metodología garantiza resultados exitosos en cada proyecto.'
                    ]
                ]
            ],
            
            // 5. Por Qué Elegirnos
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-6 p-12 text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h2',
                        'attributes' => [
                            'class' => 'heading-component text-4xl font-bold text-gray-900 mb-6',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Por Qué Elegirnos'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-lg leading-relaxed text-gray-600 max-w-2xl mx-auto',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Nuestros diferenciadores nos convierten en el socio ideal para sus proyectos.'
                    ]
                ]
            ],
            
            // 6. Contacto
            [
                'type' => 'container',
                'name' => 'Contenedor',
                'tagName' => 'div',
                'attributes' => [
                    'class' => 'container-flex flex flex-col gap-6 p-12 bg-gray-50 text-center',
                    'data-gjs-name' => 'Contenedor',
                    'data-gjs-editable' => 'false'
                ],
                'components' => [
                    [
                        'type' => 'heading',
                        'name' => 'Título',
                        'tagName' => 'h2',
                        'attributes' => [
                            'class' => 'heading-component text-4xl font-bold text-gray-900 mb-6',
                            'data-gjs-name' => 'Título',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Contáctenos'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-xl leading-relaxed text-gray-700 max-w-2xl mx-auto',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Estamos listos para hacer realidad sus proyectos. Contáctenos hoy mismo para empezar.'
                    ],
                    [
                        'type' => 'paragraph',
                        'name' => 'Párrafo',
                        'tagName' => 'p',
                        'attributes' => [
                            'class' => 'paragraph-component text-lg leading-relaxed text-gray-600',
                            'data-gjs-name' => 'Párrafo',
                            'data-gjs-editable' => 'false'
                        ],
                        'content' => 'Teléfono: 320 457 56 82 | Email: info@lyman.com.co'
                    ]
                ]
            ]
        ];
        
        return json_encode([
            'components' => $components,
            'styles' => [],
            'css' => $this->getLymanPageCSS()
        ]);
    }
}
