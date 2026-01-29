<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Website;
use Illuminate\Database\Seeder;

class LymanSasBlogSeeder extends Seeder
{
    /**
     * Añade el bloque Listado de Posts a la página Blog y crea posts de prueba para Lyman.
     */
    public function run(): void
    {
        $website = Website::where('slug', 'lyman-sas')->first();

        if (!$website) {
            $this->command->error('No se encontró el sitio lyman-sas. Ejecuta antes LymanSasMenuSeeder.');
            return;
        }

        $this->command->info('📝 Configurando blog en página Blog y creando posts de prueba');

        // 1. Actualizar página Blog: añadir bloque Listado de Posts con data-website-id
        $blogPage = $website->pages()->where('slug', 'blog')->first();
        if (!$blogPage) {
            $this->command->error('No existe la página Blog. Ejecuta antes LymanSasMenuSeeder.');
            return;
        }

        $blockHtml = $this->getBlockHtml($website->id);
        $blogPage->update(['html_content' => $blockHtml]);
        $this->command->info('  ✓ Bloque "Listado de Posts" añadido a la página Blog');

        // 2. Categoría opcional para posts de prueba
        $category = $website->categories()->firstOrCreate(
            ['name' => 'Noticias'],
            ['slug' => 'noticias', 'description' => 'Artículos y novedades']
        );

        // 3. Posts de prueba (evitar duplicados por slug)
        $posts = [
            [
                'title' => 'Bienvenidos al blog de LYMAN SAS',
                'slug' => 'bienvenidos-blog-lyman-sas',
                'excerpt' => 'Estrenamos este espacio para compartir novedades, proyectos y reflexiones sobre logística y operaciones.',
                'content' => '<p>En LYMAN SAS hemos puesto en marcha este blog para estar más cerca de ustedes. Aquí publicaremos novedades sobre nuestros servicios, proyectos en los que participamos y artículos sobre logística, operaciones de campo y cumplimiento.</p><p>Gracias por acompañarnos. Esperamos que este contenido les sea útil.</p>',
            ],
            [
                'title' => 'Servicios logísticos: qué ofrecemos',
                'slug' => 'servicios-logisticos-lyman',
                'excerpt' => 'Repaso de los servicios logísticos y operativos que ofrece LYMAN SAS a empresas y organizaciones.',
                'content' => '<p>LYMAN SAS ofrece servicios logísticos y operativos especializados para la ejecución integral de proyectos. Trabajamos en organización de eventos, operaciones de campo, importaciones internacionales y otras actividades que requieren cumplimiento, control y resultados verificables.</p><p>Si necesitas apoyo en logística o en terreno, podemos ayudarte.</p>',
            ],
            [
                'title' => 'Claves para una operación de campo exitosa',
                'slug' => 'claves-operacion-campo-exitosa',
                'excerpt' => 'Algunas prácticas que aplicamos en LYMAN para que las operaciones en terreno cumplan objetivos y plazos.',
                'content' => '<p>Una operación de campo exitosa depende de una buena planificación, equipos entrenados y canales de comunicación claros. En LYMAN SAS priorizamos la coordinación con el cliente, el seguimiento en tiempo real y el registro de evidencias para poder medir y mejorar.</p><p>En este artículo compartimos algunas claves que nos han funcionado en proyectos recientes.</p>',
            ],
            [
                'title' => 'Contacto y próximos pasos',
                'slug' => 'contacto-proximos-pasos',
                'excerpt' => 'Cómo contactarnos y qué pasos seguir si quieres trabajar con LYMAN SAS en logística u operaciones.',
                'content' => '<p>Si estás interesado en nuestros servicios de logística o operaciones, puedes escribirnos o llamarnos. Revisamos cada consulta y te proponemos una primera reunión para alinear expectativas y plazos.</p><p>Estamos listos para acompañarte en tu próximo proyecto.</p>',
            ],
        ];

        foreach ($posts as $data) {
            $post = $website->blogPosts()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'category_id' => $category->id,
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
            $this->command->info("  ✓ Post: {$post->title}");
        }

        $this->command->info('✅ Blog configurado y posts de prueba creados. Revisa /lyman-sas/blog o la página Blog.');
    }

    private function getBlockHtml(int $websiteId): string
    {
        $id = (string) $websiteId;
        return <<<HTML
<section class="py-16 bg-gray-50 blog-list" data-dynamic-blog="true">
  <div class="container px-4 mx-auto">
    <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Últimos Artículos</h2>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="blog-posts-container" data-website-id="{$id}">
      <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div class="p-6">
          <div class="flex items-center text-sm text-gray-500 mb-2">
            <span>15 Enero, 2024</span>
            <span class="mx-2">•</span>
            <span>5 min lectura</span>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Cargando…</h3>
          <p class="text-gray-600 mb-4">Los posts se cargarán dinámicamente.</p>
          <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
              <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
              <span class="text-sm text-gray-600">Autor</span>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>
HTML;
    }
}
