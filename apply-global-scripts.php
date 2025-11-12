<?php
/**
 * Script para aplicar el componente global de scripts a todas las plantillas
 * 
 * Este script agrega automáticamente <x-global-scripts :website="$website" />
 * antes del cierre de </body> en todas las plantillas de templates/
 */

$templatesDir = __DIR__ . '/resources/views/templates/';
$globalScript = "\n  <!-- Scripts globales para funcionalidad dinámica -->\n  <x-global-scripts :website=\"\$website\" />\n";

// Obtener todas las plantillas
$templates = glob($templatesDir . '*/template.blade.php');

echo "🔧 Aplicando scripts globales a todas las plantillas...\n\n";

foreach ($templates as $template) {
    $templateName = basename(dirname($template));
    echo "📄 Procesando: $templateName\n";
    
    // Leer el contenido del archivo
    $content = file_get_contents($template);
    
    // Verificar si ya tiene el componente global
    if (strpos($content, '<x-global-scripts') !== false) {
        echo "   ✅ Ya tiene scripts globales\n";
        continue;
    }
    
    // Verificar si tiene </body>
    if (strpos($content, '</body>') !== false) {
        // Reemplazar </body> con scripts + </body>
        $newContent = str_replace('</body>', $globalScript . '</body>', $content);
        echo "   🔧 Agregando scripts antes de </body>\n";
    } else {
        // Agregar al final del archivo
        $newContent = $content . $globalScript;
        echo "   🔧 Agregando scripts al final del archivo\n";
    }
    
    // Escribir el archivo modificado
    file_put_contents($template, $newContent);
    echo "   ✅ Scripts agregados correctamente\n";
}

echo "\n🎉 ¡Proceso completado! Todas las plantillas ahora incluyen scripts globales.\n";
echo "\n📋 Plantillas procesadas:\n";
foreach ($templates as $template) {
    $templateName = basename(dirname($template));
    echo "   - $templateName\n";
}
