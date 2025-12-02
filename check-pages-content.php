<?php
/**
 * Script para verificar el contenido de las páginas
 * 
 * Este script muestra el estado del contenido de todas las páginas
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Verificando contenido de páginas...\n\n";

// Obtener todas las páginas
$pages = \App\Models\Page::all();

if ($pages->count() === 0) {
    echo "❌ No hay páginas en la base de datos.\n";
    exit;
}

echo "📋 Total de páginas: " . $pages->count() . "\n\n";

foreach ($pages as $page) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📄 Página: {$page->title} (ID: {$page->id})\n";
    echo "   Slug: {$page->slug}\n";
    echo "   Website ID: {$page->website_id}\n";
    echo "   Es página de inicio: " . ($page->is_home ? 'Sí' : 'No') . "\n";
    echo "   Publicada: " . ($page->is_published ? 'Sí' : 'No') . "\n";
    
    $contentLength = strlen($page->html_content ?? '');
    echo "   Longitud del contenido: {$contentLength} caracteres\n";
    
    if ($contentLength === 0) {
        echo "   ⚠️  CONTENIDO VACÍO\n";
    } else if ($contentLength < 50) {
        echo "   ⚠️  CONTENIDO MUY CORTO (posiblemente limpiado)\n";
        echo "   Contenido: " . substr($page->html_content, 0, 100) . "...\n";
    } else {
        echo "   ✅ Contenido presente\n";
        // Mostrar los primeros 200 caracteres
        $preview = strip_tags($page->html_content);
        $preview = substr($preview, 0, 200);
        echo "   Vista previa: " . $preview . "...\n";
    }
    
    // Verificar si contiene HTML completo de plantilla
    if (strpos($page->html_content ?? '', '<!DOCTYPE html>') !== false) {
        echo "   ⚠️  Contiene HTML completo de plantilla\n";
    }
    
    echo "\n";
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Verificación completada\n";

