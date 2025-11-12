<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;

class FixPageQuotes extends Command
{
    protected $signature = 'pages:fix-quotes {--page-id= : ID específico de página}';
    protected $description = 'Convierte comillas simples a dobles en html_content de las páginas';

    public function handle()
    {
        $pageId = $this->option('page-id');
        
        if ($pageId) {
            $pages = Page::where('id', $pageId)->get();
        } else {
            $pages = Page::whereNotNull('html_content')->get();
        }

        if ($pages->isEmpty()) {
            $this->error('No se encontraron páginas para procesar.');
            return 0;
        }

        $this->info("Procesando {$pages->count()} página(s)...\n");
        
        $fixed = 0;
        
        foreach ($pages as $page) {
            $original = $page->html_content;
            
            // Verificar si tiene comillas simples en atributos HTML
            if (strpos($original, "class='") !== false || strpos($original, "href='") !== false) {
                // Convertir comillas simples a dobles en atributos HTML
                $fixed_content = preg_replace_callback(
                    "/(\w+)='([^']*)'/",
                    function($matches) {
                        return $matches[1] . '="' . $matches[2] . '"';
                    },
                    $original
                );
                
                $page->html_content = $fixed_content;
                $page->save();
                
                $fixed++;
                $this->info("✅ Página fijada: {$page->title} (ID: {$page->id})");
            } else {
                $this->line("⏭️  Página OK: {$page->title} (ID: {$page->id})");
            }
        }
        
        $this->info("\n🎉 Proceso completado!");
        $this->info("📊 Páginas procesadas: {$pages->count()}");
        $this->info("✅ Páginas corregidas: {$fixed}");
        
        return 0;
    }
}

