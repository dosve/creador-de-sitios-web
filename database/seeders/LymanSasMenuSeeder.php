<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Website;

class LymanSasMenuSeeder extends Seeder
{
    public function run(): void
    {
        $website = Website::where('slug', 'lyman-sas')->first();
        
        if (!$website) {
            $this->command->error('No se encontró el sitio lyman-sas');
            return;
        }
        
        $this->command->info('🔗 Creando menú de navegación para LYMAN SAS');
        
        // Crear página "Blog" si no existe (enlace a /sitio/blog; la ruta muestra el listado de posts)
        $maxOrder = (int) $website->pages()->max('sort_order');
        $blogPage = $website->pages()->firstOrCreate(
            ['slug' => 'blog'],
            [
                'title' => 'Blog',
                'meta_description' => 'Artículos y noticias',
                'is_published' => true,
                'is_home' => false,
                'enable_store' => false,
                'sort_order' => $maxOrder + 1,
                'html_content' => '<!-- Página Blog: el listado se muestra en /' . $website->slug . '/blog -->',
                'css_content' => null,
            ]
        );
        if ($blogPage->wasRecentlyCreated) {
            $this->command->info('  ✓ Página "Blog" creada');
        }
        
        // Crear o actualizar menú principal
        $menu = $website->menus()->updateOrCreate(
            ['location' => 'header'],
            [
                'name' => 'Menú Principal',
                'location' => 'header',
                'is_active' => true,
                'description' => 'Menú de navegación principal del sitio'
            ]
        );
        
        // Eliminar items antiguos
        $menu->allItems()->delete();
        
        // Obtener las páginas creadas (incluye Blog)
        $pages = $website->pages()->orderBy('sort_order')->get();
        
        $order = 1;
        foreach ($pages as $page) {
            $menu->items()->create([
                'page_id' => $page->id,
                'title' => $page->title === 'Inicio' ? 'Inicio' : $page->title,
                'url' => null, // Se genera automáticamente desde page_id
                'target' => '_self',
                'order' => $order,
                'is_active' => true,
                'parent_id' => null
            ]);
            
            $this->command->info("  ✓ Item: {$page->title}");
            $order++;
        }
        
        $totalItems = $order - 1;
        $this->command->info("✓ Menú creado con {$totalItems} items");
    }
}
