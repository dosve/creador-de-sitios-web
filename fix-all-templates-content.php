<?php
/**
 * Script para arreglar el renderizado de contenido en TODAS las plantillas
 * 
 * Este script busca contenido hardcodeado y lo reemplaza por renderizado dinámico
 */

$templatesDir = __DIR__ . '/resources/views/templates/';

echo "🔧 Arreglando renderizado de contenido en TODAS las plantillas...\n\n";

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
    
    // Buscar contenido hardcodeado (títulos, párrafos, etc. que no sean variables)
    $patterns = [
        // Buscar títulos hardcodeados
        '/<h[1-6][^>]*class="[^"]*"[^>]*>[^<{]+<\/h[1-6]>/',
        // Buscar párrafos hardcodeados
        '/<p[^>]*class="[^"]*"[^>]*>[^<{]+<\/p>/',
        // Buscar divs con contenido hardcodeado
        '/<div[^>]*class="[^"]*"[^>]*>[^<{]+<\/div>/'
    ];
    
    $hasHardcodedContent = false;
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            $hasHardcodedContent = true;
            break;
        }
    }
    
    if ($hasHardcodedContent) {
        echo "   🔧 Encontrado contenido hardcodeado, reemplazando...\n";
        
        // Crear el nuevo contenido que renderiza la página
        $newContent = '
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
        
        // Buscar la sección principal del contenido (después del header)
        if (preg_match('/(@include\([^)]+header[^)]*\))(.*?)(@include\([^)]+footer[^)]*\))/s', $content, $matches)) {
            $header = $matches[1];
            $mainContent = $matches[2];
            $footer = $matches[3];
            
            // Reemplazar el contenido principal
            $newMainContent = $header . $newContent . $footer;
            $finalContent = str_replace($matches[0], $newMainContent, $content);
            
            // Escribir el archivo modificado
            file_put_contents($templateFile, $finalContent);
            echo "   ✅ Contenido de página agregado\n";
        } else {
            echo "   ⚠️  No se pudo encontrar la estructura header-main-footer\n";
        }
    } else {
        echo "   ✅ No tiene contenido hardcodeado\n";
    }
}

echo "\n🎉 ¡Proceso completado! Todas las plantillas ahora renderizan contenido específico de página.\n";
echo "\n📋 Plantillas procesadas:\n";
foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "   - $templateName\n";
}
