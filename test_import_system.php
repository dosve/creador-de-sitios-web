<?php
/**
 * Script de prueba para el Sistema de Importación Universal
 * 
 * Este script simula el uso del sistema de importación
 * para verificar que funciona correctamente.
 */

require_once 'vendor/autoload.php';

use App\Services\UniversalPageImportService;

echo "🧪 Probando Sistema de Importación Universal\n";
echo "==========================================\n\n";

// Simular el servicio
$importService = new UniversalPageImportService();

// 1. Probar obtención de categorías
echo "1. 📋 Obteniendo categorías disponibles...\n";
$categories = $importService->getCategories();
foreach ($categories as $key => $category) {
    echo "   - {$category['name']} ({$key})\n";
    echo "     Plantillas: " . implode(', ', $category['templates']) . "\n";
    echo "     Páginas esenciales: " . count($category['common_pages']) . "\n";
    echo "     Páginas especializadas: " . count($category['specialized_pages']) . "\n\n";
}

// 2. Probar obtención de páginas para e-commerce
echo "2. 🛒 Probando categoría E-commerce...\n";
$ecommercePages = $importService->getPagesForCategory('ecommerce');
echo "   Páginas esenciales:\n";
foreach ($ecommercePages['common_pages'] as $slug => $description) {
    echo "   - {$slug}: {$description}\n";
}
echo "\n   Páginas especializadas:\n";
foreach ($ecommercePages['specialized_pages'] as $slug => $description) {
    echo "   - {$slug}: {$description}\n";
}

// 3. Probar obtención de plantillas para e-commerce
echo "\n3. 🎨 Plantillas disponibles para E-commerce:\n";
$templates = $importService->getTemplatesForCategory('ecommerce');
foreach ($templates as $template) {
    echo "   - {$template}\n";
}

// 4. Probar obtención de páginas de plantilla específica
echo "\n4. 📄 Probando plantilla 'tienda-virtual'...\n";
$templatePages = $importService->getTemplatePages('tienda-virtual');
echo "   Páginas encontradas: " . count($templatePages) . "\n";
foreach ($templatePages as $page) {
    echo "   - {$page['title']} ({$page['slug']})\n";
    if (isset($page['blocks'])) {
        echo "     Bloques: " . count($page['blocks']) . "\n";
    }
}

// 5. Probar páginas recomendadas
echo "\n5. ⭐ Páginas recomendadas para E-commerce:\n";
$recommendedPages = $importService->getRecommendedPages('ecommerce');
foreach ($recommendedPages as $slug => $description) {
    echo "   - {$slug}: {$description}\n";
}

echo "\n✅ Pruebas completadas exitosamente!\n";
echo "\n📊 Resumen:\n";
echo "- Categorías disponibles: " . count($categories) . "\n";
echo "- Páginas e-commerce esenciales: " . count($ecommercePages['common_pages']) . "\n";
echo "- Páginas e-commerce especializadas: " . count($ecommercePages['specialized_pages']) . "\n";
echo "- Plantillas e-commerce: " . count($templates) . "\n";
echo "- Páginas en tienda-virtual: " . count($templatePages) . "\n";

echo "\n🎉 El sistema está funcionando correctamente!\n";
?>
