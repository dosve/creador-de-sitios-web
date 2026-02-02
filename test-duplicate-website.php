<?php

/**
 * Script de testing rápido para la funcionalidad de duplicar sitios web
 * 
 * Uso: php artisan tinker < test-duplicate-website.php
 * O dentro de tinker: include('test-duplicate-website.php');
 */

use App\Models\Website;
use App\Models\User;
use App\Services\DuplicateWebsiteService;

echo "=== Testing Duplicar Sitio Web ===\n\n";

// 1. Obtener un sitio web existente
$website = Website::first();

if (!$website) {
    echo "❌ No hay sitios web en la base de datos. Crea uno primero.\n";
    exit;
}

echo "📌 Sitio original encontrado:\n";
echo "   - ID: {$website->id}\n";
echo "   - Nombre: {$website->name}\n";
echo "   - Slug: {$website->slug}\n";
echo "   - Páginas: {$website->pages()->count()}\n";
echo "   - Posts: {$website->blogPosts()->count()}\n";
echo "   - Menús: {$website->menus()->count()}\n";
echo "   - Categorías: {$website->categories()->count()}\n";
echo "   - Etiquetas: {$website->tags()->count()}\n\n";

// 2. Duplicar el sitio
echo "🔄 Duplicando sitio...\n";

try {
    $duplicateService = app(DuplicateWebsiteService::class);
    
    $newWebsite = $duplicateService->duplicate(
        $website,
        $website->name . ' (Copia Test)',
        null // Auto-generar slug
    );
    
    echo "✅ Sitio duplicado exitosamente!\n\n";
    
    // 3. Verificar la copia
    echo "📋 Sitio nuevo creado:\n";
    echo "   - ID: {$newWebsite->id}\n";
    echo "   - Nombre: {$newWebsite->name}\n";
    echo "   - Slug: {$newWebsite->slug}\n";
    echo "   - Publicado: " . ($newWebsite->is_published ? 'Sí' : 'No') . "\n";
    echo "   - Páginas: {$newWebsite->pages()->count()}\n";
    echo "   - Posts: {$newWebsite->blogPosts()->count()}\n";
    echo "   - Menús: {$newWebsite->menus()->count()}\n";
    echo "   - Categorías: {$newWebsite->categories()->count()}\n";
    echo "   - Etiquetas: {$newWebsite->tags()->count()}\n\n";
    
    // 4. Comparación
    echo "🔍 Comparación:\n";
    
    if ($newWebsite->pages()->count() === $website->pages()->count()) {
        echo "   ✅ Páginas: " . $newWebsite->pages()->count() . " = " . $website->pages()->count() . "\n";
    } else {
        echo "   ❌ Páginas: " . $newWebsite->pages()->count() . " ≠ " . $website->pages()->count() . "\n";
    }
    
    if ($newWebsite->blogPosts()->count() === $website->blogPosts()->count()) {
        echo "   ✅ Posts: " . $newWebsite->blogPosts()->count() . " = " . $website->blogPosts()->count() . "\n";
    } else {
        echo "   ❌ Posts: " . $newWebsite->blogPosts()->count() . " ≠ " . $website->blogPosts()->count() . "\n";
    }
    
    if ($newWebsite->menus()->count() === $website->menus()->count()) {
        echo "   ✅ Menús: " . $newWebsite->menus()->count() . " = " . $website->menus()->count() . "\n";
    } else {
        echo "   ❌ Menús: " . $newWebsite->menus()->count() . " ≠ " . $website->menus()->count() . "\n";
    }
    
    echo "\n✨ Test completado correctamente!\n";
    
} catch (\Exception $e) {
    echo "❌ Error durante la duplicación:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "\n📄 Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Fin del test ===\n";
