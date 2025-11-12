<?php
/**
 * Script para arreglar el renderizado de contenido en todas las plantillas
 * 
 * Este script modifica todas las plantillas para que rendericen el contenido
 * específico de cada página en lugar de contenido hardcodeado
 */

$templatesDir = __DIR__ . '/resources/views/templates/';

echo "🔧 Arreglando renderizado de contenido en todas las plantillas...\n\n";

// Obtener todas las plantillas
$templates = glob($templatesDir . '*/template.blade.php');

foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "📄 Procesando: $templateName\n";
    
    // Leer el contenido del template
    $content = file_get_contents($templateFile);
    
    // Verificar si ya tiene el renderizado de contenido de página
    if (strpos($content, '$page->html_content') !== false) {
        echo "   ✅ Ya renderiza contenido de página\n";
        continue;
    }
    
    // Buscar el tag <main> y reemplazar su contenido
    if (preg_match('/<main[^>]*>(.*?)<\/main>/s', $content, $matches)) {
        $mainContent = $matches[1];
        
        // Verificar si el contenido es hardcodeado (no tiene variables de página)
        if (strpos($mainContent, '$page') === false && strpos($mainContent, '$website') === false) {
            echo "   🔧 Reemplazando contenido hardcodeado...\n";
            
            // Crear el nuevo contenido que renderiza la página
            $newMainContent = '
        <div class="container px-4 mx-auto">
            @if($page && $page->html_content)
                {!! $page->html_content !!}
            @else
                <div class="text-center">
                    <h1 class="mb-6 text-4xl font-bold text-gray-900">{{ $page->title ?? "Página" }}</h1>
                    <p class="max-w-2xl mx-auto mb-8 text-lg text-gray-600">
                        {{ $page->meta_description ?? "Contenido de la página" }}
                    </p>
                </div>
            @endif
        </div>';
            
            // Reemplazar el contenido del main
            $newContent = str_replace($mainContent, $newMainContent, $content);
            
            // Escribir el archivo modificado
            file_put_contents($templateFile, $newContent);
            echo "   ✅ Contenido de página agregado\n";
        } else {
            echo "   ✅ Ya tiene variables de página\n";
        }
    } else {
        echo "   ⚠️  No se encontró tag <main>\n";
    }
}

echo "\n🎉 ¡Proceso completado! Todas las plantillas ahora renderizan contenido específico de página.\n";
echo "\n📋 Plantillas procesadas:\n";
foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "   - $templateName\n";
}
