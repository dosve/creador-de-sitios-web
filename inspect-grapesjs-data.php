<?php
// Script para inspeccionar los datos del proyecto guardados
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'prueba')->first();

if ($page && $page->grapesjs_data) {
    $data = json_decode($page->grapesjs_data, true);
    
    echo "=== GRAPESJS PROJECT DATA ===\n\n";
    
    if (isset($data['pages'][0]['frames'][0]['component'])) {
        $wrapper = $data['pages'][0]['frames'][0]['component'];
        
        echo "Wrapper component:\n";
        echo "  Type: " . $wrapper['type'] . "\n";
        echo "  Has components: " . (isset($wrapper['components']) ? 'YES (' . count($wrapper['components']) . ')' : 'NO') . "\n\n";
        
        // Buscar contenedores
        $findContainer = function($comp, $level = 0) use (&$findContainer) {
            if (isset($comp['type']) && $comp['type'] === 'container') {
                echo str_repeat("  ", $level) . "✓ Container:\n";
                echo str_repeat("  ", $level) . "  Class: " . ($comp['attributes']['class'] ?? 'NONE') . "\n";
                
                // Propiedades custom
                foreach (['container-align', 'container-justify', 'container-direction', 'container-direction-tablet', 'container-direction-mobile'] as $prop) {
                    if (isset($comp[$prop])) {
                        echo str_repeat("  ", $level) . "  $prop: " . $comp[$prop] . "\n";
                    }
                }
                
                if (isset($comp['components'])) {
                    echo str_repeat("  ", $level) . "  Children: " . count($comp['components']) . "\n";
                }
                echo "\n";
            }
            
            if (isset($comp['components']) && is_array($comp['components'])) {
                foreach ($comp['components'] as $child) {
                    $findContainer($child, $level + 1);
                }
            }
        };
        
        if (isset($wrapper['components'])) {
            foreach ($wrapper['components'] as $comp) {
                $findContainer($comp, 0);
            }
        }
        
    } else {
        echo "No component found\n";
    }
} else {
    echo "Page not found or no grapesjs_data\n";
}
?>


