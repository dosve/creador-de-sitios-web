<?php
/**
 * Script para verificar si el contenido de las páginas tiene código Blade sin procesar
 * 
 * Este script muestra específicamente si hay código Blade (@if, {{ }}, @include) en el html_content
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Verificando contenido Blade en páginas...\n\n";

// Buscar páginas con template_id dosve-empresa
$website = \App\Models\Website::where('template_id', 'dosve-empresa')->first();

if (!$website) {
    echo "❌ No se encontró un sitio web con template_id 'dosve-empresa'\n";
    echo "Buscando cualquier página de inicio...\n\n";
    
    $homePage = \App\Models\Page::where('is_home', true)->first();
    if (!$homePage) {
        echo "❌ No hay páginas de inicio en la base de datos.\n";
        exit;
    }
} else {
    echo "✅ Sitio web encontrado: {$website->name} (ID: {$website->id})\n";
    $homePage = $website->pages()->where('is_home', true)->first();
    
    if (!$homePage) {
        echo "⚠️  No hay página de inicio para este sitio.\n";
        $homePage = $website->pages()->first();
    }
}

if (!$homePage) {
    echo "❌ No se encontró ninguna página.\n";
    exit;
}

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📄 Página: {$homePage->title} (ID: {$homePage->id})\n";
echo "   Slug: {$homePage->slug}\n";
echo "   Website ID: {$homePage->website_id}\n";
echo "   Es página de inicio: " . ($homePage->is_home ? 'Sí' : 'No') . "\n";
echo "   Publicada: " . ($homePage->is_published ? 'Sí' : 'No') . "\n";

$content = $homePage->html_content ?? '';
$contentLength = strlen($content);
echo "   Longitud del contenido: {$contentLength} caracteres\n\n";

if ($contentLength === 0) {
    echo "   ⚠️  CONTENIDO VACÍO\n";
    exit;
}

// Verificar código Blade sin procesar
$bladePatterns = [
    '@if\s*\(' => '@if',
    '@else' => '@else',
    '@endif' => '@endif',
    '@include\s*\(' => '@include',
    '@foreach\s*\(' => '@foreach',
    '@endforeach' => '@endforeach',
    '\{\{\s*\$' => '{{ $variable }}',
    '\{\{\s*asset\(' => '{{ asset() }}',
    '\{\{\s*[^}]+\s*\}\}' => '{{ expresión }}',
];

$foundBlade = [];
foreach ($bladePatterns as $pattern => $name) {
    if (preg_match('/' . $pattern . '/', $content)) {
        $foundBlade[] = $name;
    }
}

if (count($foundBlade) > 0) {
    echo "   ❌ CÓDIGO BLADE SIN PROCESAR DETECTADO:\n";
    echo "      Patrones encontrados: " . implode(', ', $foundBlade) . "\n\n";
    
    // Mostrar ejemplos del código Blade encontrado
    echo "   📋 Ejemplos de código Blade encontrado:\n";
    $lines = explode("\n", $content);
    $lineNumber = 0;
    $examplesShown = 0;
    
    foreach ($lines as $line) {
        $lineNumber++;
        if (preg_match('/@(if|else|endif|include|foreach|endforeach)/', $line) || 
            preg_match('/\{\{.*\}\}/', $line)) {
            echo "      Línea {$lineNumber}: " . trim(substr($line, 0, 100)) . "\n";
            $examplesShown++;
            if ($examplesShown >= 10) {
                echo "      ... (mostrando solo los primeros 10 ejemplos)\n";
                break;
            }
        }
    }
} else {
    echo "   ✅ NO SE DETECTÓ CÓDIGO BLADE SIN PROCESAR\n";
    echo "      El contenido parece estar procesado (HTML puro)\n\n";
    
    // Mostrar una vista previa del contenido
    $preview = strip_tags($content);
    $preview = substr($preview, 0, 300);
    echo "   📋 Vista previa del contenido (primeros 300 caracteres sin HTML):\n";
    echo "      " . $preview . "...\n";
}

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 RESUMEN:\n";
echo "   - Longitud total: {$contentLength} caracteres\n";
echo "   - Contiene código Blade: " . (count($foundBlade) > 0 ? 'SÍ ❌' : 'NO ✅') . "\n";
echo "   - Patrones Blade encontrados: " . count($foundBlade) . "\n";

// Guardar muestra del contenido en un archivo para comparar
$sampleFile = __DIR__ . '/page-content-sample-local.txt';
file_put_contents($sampleFile, "=== CONTENIDO COMPLETO DE LA PÁGINA ===\n\n");
file_put_contents($sampleFile, $content, FILE_APPEND);
echo "\n   💾 Muestra completa guardada en: page-content-sample-local.txt\n";
echo "      (Úsalo para comparar con producción)\n";

echo "\n✅ Verificación completada\n";

