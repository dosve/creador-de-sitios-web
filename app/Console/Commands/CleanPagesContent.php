<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;

class CleanPagesContent extends Command
{
    protected $signature = 'pages:clean-content';
    protected $description = 'Limpiar contenido HTML completo de las páginas';

    public function handle()
    {
        $this->info('🧹 Limpiando contenido de páginas...');
        
        $pages = Page::all();
        $cleaned = 0;
        
        foreach ($pages as $page) {
            $this->line("📄 Procesando: {$page->title}");
            
            $content = $page->html_content;
            
            // Verificar si contiene HTML completo
            if (strpos($content, '<!DOCTYPE html>') !== false || strpos($content, '<html lang="es">') !== false) {
                $this->info("   🔧 Limpiando contenido HTML completo...");
                
                // Crear contenido simple
                $page->html_content = "<h1>{$page->title}</h1><p>Contenido de la página {$page->title}</p>";
                $page->save();
                
                $cleaned++;
                $this->info("   ✅ Contenido limpiado");
            } else {
                $this->line("   ✅ Contenido ya está limpio");
            }
        }
        
        $this->info("\n🎉 ¡Proceso completado!");
        $this->info("📋 Páginas limpiadas: {$cleaned}");
    }
}
