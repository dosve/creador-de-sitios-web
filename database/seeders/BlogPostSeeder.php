<?php

namespace Database\Seeders;

use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el primer sitio web
        $website = Website::first();
        
        if (!$website) {
            return;
        }

        // Crear categorías si no existen
        $categories = [
            ['name' => 'Tecnología', 'slug' => 'tecnologia', 'color' => '#3B82F6', 'description' => 'Artículos sobre tecnología'],
            ['name' => 'Diseño', 'slug' => 'diseno', 'color' => '#8B5CF6', 'description' => 'Artículos sobre diseño'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'color' => '#10B981', 'description' => 'Artículos sobre marketing'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate([
                'website_id' => $website->id,
                'slug' => $categoryData['slug']
            ], [
                'name' => $categoryData['name'],
                'color' => $categoryData['color'],
                'description' => $categoryData['description'],
                'is_active' => true
            ]);
        }

        // Crear etiquetas si no existen
        $tags = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'color' => '#EF4444'],
            ['name' => 'UI/UX', 'slug' => 'ui-ux', 'color' => '#F59E0B'],
            ['name' => 'SEO', 'slug' => 'seo', 'color' => '#06B6D4'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#84CC16'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#EC4899'],
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate([
                'website_id' => $website->id,
                'slug' => $tagData['slug']
            ], [
                'name' => $tagData['name'],
                'color' => $tagData['color']
            ]);
        }

        // Obtener categorías y tags creados
        $techCategory = Category::where('website_id', $website->id)->where('name', 'Tecnología')->first();
        $designCategory = Category::where('website_id', $website->id)->where('name', 'Diseño')->first();
        $marketingCategory = Category::where('website_id', $website->id)->where('name', 'Marketing')->first();

        $webTag = Tag::where('website_id', $website->id)->where('name', 'Web Development')->first();
        $uiTag = Tag::where('website_id', $website->id)->where('name', 'UI/UX')->first();
        $seoTag = Tag::where('website_id', $website->id)->where('name', 'SEO')->first();
        $reactTag = Tag::where('website_id', $website->id)->where('name', 'React')->first();
        $laravelTag = Tag::where('website_id', $website->id)->where('name', 'Laravel')->first();

        // Crear posts de blog
        $posts = [
            [
                'title' => 'Guía Completa de Desarrollo Web Moderno',
                'slug' => 'guia-desarrollo-web-moderno',
                'excerpt' => 'Aprende las mejores prácticas y tecnologías para crear sitios web modernos y escalables.',
                'content' => '<h2>Introducción al Desarrollo Web</h2><p>El desarrollo web moderno ha evolucionado significativamente en los últimos años. Hoy en día, los desarrolladores tienen acceso a una amplia gama de herramientas y tecnologías que facilitan la creación de aplicaciones web robustas y escalables.</p><h3>Tecnologías Principales</h3><ul><li><strong>HTML5:</strong> La base de toda página web</li><li><strong>CSS3:</strong> Para estilos avanzados y animaciones</li><li><strong>JavaScript ES6+:</strong> Para interactividad y lógica</li><li><strong>Frameworks:</strong> React, Vue, Angular</li></ul><p>Estas tecnologías trabajan juntas para crear experiencias de usuario excepcionales.</p>',
                'category_id' => $techCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Principios de Diseño UX/UI que Todo Desarrollador Debe Conocer',
                'slug' => 'principios-diseno-ux-ui',
                'excerpt' => 'Descubre los fundamentos del diseño de interfaces que mejoran la experiencia del usuario.',
                'content' => '<h2>¿Qué es UX/UI?</h2><p>El diseño UX (User Experience) y UI (User Interface) son disciplinas fundamentales en el desarrollo de productos digitales. Mientras que UI se enfoca en la apariencia visual, UX se centra en la experiencia del usuario.</p><h3>Principios Clave</h3><ol><li><strong>Simplicidad:</strong> Menos es más</li><li><strong>Consistencia:</strong> Mantener patrones uniformes</li><li><strong>Accesibilidad:</strong> Diseño para todos</li><li><strong>Feedback:</strong> Comunicar claramente las acciones</li></ol>',
                'category_id' => $designCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'SEO Avanzado para Desarrolladores',
                'slug' => 'seo-avanzado-desarrolladores',
                'excerpt' => 'Técnicas de optimización para motores de búsqueda que todo desarrollador web debe implementar.',
                'content' => '<h2>SEO Técnico</h2><p>El SEO técnico es una parte crucial del desarrollo web que a menudo se pasa por alto. Incluye optimizaciones que mejoran la capacidad de los motores de búsqueda para rastrear, indexar y entender tu sitio web.</p><h3>Elementos Clave</h3><ul><li><strong>Velocidad de carga:</strong> Optimiza imágenes y código</li><li><strong>Estructura HTML:</strong> Usa semántica correcta</li><li><strong>Meta tags:</strong> Title y description optimizados</li><li><strong>URLs amigables:</strong> Estructura clara y descriptiva</li></ul>',
                'category_id' => $marketingCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Introducción a React: Componentes y Estado',
                'slug' => 'introduccion-react-componentes-estado',
                'excerpt' => 'Aprende los conceptos fundamentales de React y cómo crear componentes reutilizables.',
                'content' => '<h2>¿Qué es React?</h2><p>React es una biblioteca de JavaScript para construir interfaces de usuario, especialmente para aplicaciones de una sola página. Fue desarrollado por Facebook y es ampliamente utilizado en la industria.</p><h3>Conceptos Fundamentales</h3><ul><li><strong>Componentes:</strong> Bloques de construcción reutilizables</li><li><strong>Estado:</strong> Datos que pueden cambiar</li><li><strong>Props:</strong> Datos que se pasan entre componentes</li><li><strong>JSX:</strong> Sintaxis que combina JavaScript y HTML</li></ul>',
                'category_id' => $techCategory->id,
                'is_published' => true,
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'Laravel: Framework PHP Moderno',
                'slug' => 'laravel-framework-php-moderno',
                'excerpt' => 'Descubre por qué Laravel es uno de los frameworks PHP más populares para desarrollo web.',
                'content' => '<h2>Introducción a Laravel</h2><p>Laravel es un framework de PHP elegante y expresivo que facilita el desarrollo de aplicaciones web robustas. Con su sintaxis limpia y potentes herramientas, Laravel ha revolucionado el desarrollo con PHP.</p><h3>Características Principales</h3><ul><li><strong>Eloquent ORM:</strong> Interacción elegante con la base de datos</li><li><strong>Artisan CLI:</strong> Herramientas de línea de comandos</li><li><strong>Blade Templates:</strong> Motor de plantillas intuitivo</li><li><strong>Middleware:</strong> Filtros para requests HTTP</li></ul>',
                'category_id' => $techCategory->id,
                'is_published' => true,
                'published_at' => now()->subHours(6),
            ],
        ];

        foreach ($posts as $postData) {
            $post = BlogPost::create(array_merge($postData, [
                'website_id' => $website->id,
            ]));

            // Asignar tags según la categoría
            if ($postData['category_id'] === $techCategory->id) {
                $post->tags()->attach([$webTag->id, $reactTag->id, $laravelTag->id]);
            } elseif ($postData['category_id'] === $designCategory->id) {
                $post->tags()->attach([$uiTag->id]);
            } elseif ($postData['category_id'] === $marketingCategory->id) {
                $post->tags()->attach([$seoTag->id]);
            }
        }

        $this->command->info('Posts de blog creados exitosamente!');
    }
}
