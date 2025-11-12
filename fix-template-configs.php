<?php
/**
 * Script para arreglar config.json de todas las plantillas
 * 
 * Este script corrige las referencias a archivos de template que no existen
 * y los reemplaza por template.blade.php que sí existe en todas las plantillas
 */

$templatesDir = __DIR__ . '/resources/views/templates/';

echo "🔧 Arreglando config.json de todas las plantillas...\n\n";

// Obtener todas las plantillas
$templates = glob($templatesDir . '*/config.json');

foreach ($templates as $configFile) {
    $templateName = basename(dirname($configFile));
    echo "📄 Procesando: $templateName\n";
    
    // Leer el config.json
    $config = json_decode(file_get_contents($configFile), true);
    
    if (!$config) {
        echo "   ❌ Error leyendo config.json\n";
        continue;
    }
    
    // Verificar si tiene sección templates
    if (!isset($config['templates'])) {
        echo "   ⚠️  No tiene sección templates, agregando...\n";
        $config['templates'] = [
            'home' => 'template.blade.php',
            'page' => 'template.blade.php',
            'blog' => 'template.blade.php'
        ];
    } else {
        echo "   🔧 Verificando archivos de template...\n";
        
        // Verificar qué archivos existen
        $templateDir = dirname($configFile);
        $existingFiles = glob($templateDir . '/template*.blade.php');
        $existingFiles = array_map('basename', $existingFiles);
        
        echo "   📁 Archivos existentes: " . implode(', ', $existingFiles) . "\n";
        
        // Corregir referencias a archivos que no existen
        $fixed = false;
        foreach ($config['templates'] as $type => $file) {
            if (!in_array($file, $existingFiles)) {
                echo "   🔧 Corrigiendo $type: $file -> template.blade.php\n";
                $config['templates'][$type] = 'template.blade.php';
                $fixed = true;
            }
        }
        
        if (!$fixed) {
            echo "   ✅ No necesita corrección\n";
        }
    }
    
    // Escribir el config.json corregido
    $newConfig = json_encode($config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    file_put_contents($configFile, $newConfig);
    echo "   ✅ Config.json actualizado\n";
}

echo "\n🎉 ¡Proceso completado! Todas las plantillas ahora tienen config.json corregido.\n";
echo "\n📋 Plantillas procesadas:\n";
foreach ($templates as $configFile) {
    $templateName = basename(dirname($configFile));
    echo "   - $templateName\n";
}
