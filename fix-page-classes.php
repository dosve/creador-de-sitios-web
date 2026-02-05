<?php

/**
 * Script para actualizar las clases de los contenedores en la página "prueba"
 * Agrega md:flex-row a los contenedores para que sean responsive
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Buscar la página "prueba" del website "eme10"
$page = DB::table('pages')
    ->where('slug', 'prueba')
    ->where('website_id', 2)
    ->first();

if (!$page) {
    echo "❌ No se encontró la página 'prueba'\n";
    exit(1);
}

echo "✅ Página encontrada: {$page->title} (ID: {$page->id})\n";

// El contenido HTML está en html_content y grapesjs_data
$htmlContent = $page->html_content;
$grapesData = $page->grapesjs_data;

$originalHtml = $htmlContent;
$originalGrapes = $grapesData;

// Patrón: Buscar class="...container-flex...flex flex-col..." SIN md:flex-row
// y agregar md:flex-row después de flex-col
$pattern = '/(class="[^"]*container-flex[^"]*flex\s+flex-col)(\s+(?!md:flex-row))/';
$replacement = '$1 md:flex-row$2';

$htmlContent = preg_replace($pattern, $replacement, $htmlContent);
$grapesData = preg_replace($pattern, $replacement, $grapesData);

echo "\n🔍 Analizando contenedores...\n";

// Contar cuántos cambios se hicieron
preg_match_all('/container-flex/', $originalHtml, $matches);
$totalContainers = count($matches[0]);

preg_match_all('/md:flex-row/', $originalHtml, $matchesBefore);
$beforeCount = count($matchesBefore[0]);

preg_match_all('/md:flex-row/', $htmlContent, $matchesAfter);
$afterCount = count($matchesAfter[0]);

echo "  📦 Total de contenedores: {$totalContainers}\n";
echo "  📱 Con md:flex-row ANTES: {$beforeCount}\n";
echo "  ✅ Con md:flex-row DESPUÉS: {$afterCount}\n";
echo "  🔧 Contenedores actualizados: " . ($afterCount - $beforeCount) . "\n";

if ($htmlContent !== $originalHtml || $grapesData !== $originalGrapes) {
    // Actualizar la página en la base de datos
    $updates = [];
    if ($htmlContent !== $originalHtml) {
        $updates['html_content'] = $htmlContent;
    }
    if ($grapesData !== $originalGrapes) {
        $updates['grapesjs_data'] = $grapesData;
    }
    
    DB::table('pages')
        ->where('id', $page->id)
        ->update($updates);
    
    echo "\n✅✅✅ Página actualizada exitosamente\n";
    echo "🌐 Recarga la página en el editor para ver los cambios\n";
} else {
    echo "\n✅ No se necesitaron cambios (las clases ya estaban correctas)\n";
}

echo "\n📋 EJEMPLO DE CLASE ACTUALIZADA:\n";
echo "  ANTES: container-flex flex flex-col gap-4\n";
echo "  DESPUÉS: container-flex flex flex-col md:flex-row gap-4\n";
