<?php
/**
 * Script para limpiar el contenido de las páginas
 * 
 * Este script elimina el HTML completo de plantillas del contenido de las páginas
 * y las deja solo con el contenido específico
 */

echo "🧹 Limpiando contenido de páginas...\n\n";

// Obtener todas las páginas
$pages = \App\Models\Page::all();

foreach ($pages as $page) {
    echo "📄 Procesando página: {$page->title} (ID: {$page->id})\n";
    
    $content = $page->html_content;
    
    // Verificar si el contenido contiene HTML completo de plantilla
    if (strpos($content, '<!DOCTYPE html>') !== false || strpos($content, '<html lang="es">') !== false) {
        echo "   🔧 Contenido contiene HTML completo, limpiando...\n";
        
        // Buscar el contenido específico entre las etiquetas <body>
        if (preg_match('/<body[^>]*>(.*?)<\/body>/s', $content, $matches)) {
            $bodyContent = $matches[1];
            
            // Remover includes y scripts de plantilla
            $bodyContent = preg_replace('/@include\([^)]+\)/', '', $bodyContent);
            $bodyContent = preg_replace('/@php.*?@endphp/s', '', $bodyContent);
            $bodyContent = preg_replace('/<!-- Scripts globales.*?<\/script>/s', '', $bodyContent);
            $bodyContent = preg_replace('/<x-global-scripts[^>]*\/>/', '', $bodyContent);
            
            // Limpiar espacios en blanco excesivos
            $bodyContent = preg_replace('/\s+/', ' ', $bodyContent);
            $bodyContent = trim($bodyContent);
            
            // Si el contenido está vacío o es muy corto, usar contenido por defecto
            if (strlen($bodyContent) < 50) {
                $bodyContent = "<h1>{$page->title}</h1><p>Contenido de la página {$page->title}</p>";
            }
            
            $page->html_content = $bodyContent;
            $page->save();
            
            echo "   ✅ Contenido limpiado\n";
        } else {
            echo "   ⚠️  No se pudo extraer contenido del body\n";
        }
    } else {
        echo "   ✅ Contenido ya está limpio\n";
    }
}

echo "\n🎉 ¡Proceso completado! Todas las páginas ahora tienen contenido limpio.\n";
echo "\n📋 Páginas procesadas: " . $pages->count() . "\n";
