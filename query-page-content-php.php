<?php
/**
 * Script PHP para consultar el contenido de la página desde la base de datos
 * Úsalo en producción para obtener el mismo formato que en local
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Consultando contenido de la página desde la BD...\n\n";

// Buscar sitio web con template dosve-empresa
$website = \App\Models\Website::where('template_id', 'dosve-empresa')->first();

if (!$website) {
    echo "❌ No se encontró un sitio web con template_id 'dosve-empresa'\n";
    echo "Buscando cualquier página de inicio...\n\n";
    $homePage = \App\Models\Page::where('is_home', true)->first();
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
echo "📊 INFORMACIÓN DE LA PÁGINA:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "ID: {$homePage->id}\n";
echo "Título: {$homePage->title}\n";
echo "Slug: {$homePage->slug}\n";
echo "Website ID: {$homePage->website_id}\n";
echo "Website: {$website->name}\n";
echo "Template ID: {$website->template_id}\n";
echo "Es página de inicio: " . ($homePage->is_home ? 'Sí' : 'No') . "\n";
echo "Publicada: " . ($homePage->is_published ? 'Sí' : 'No') . "\n";

$content = $homePage->html_content ?? '';
$contentLength = strlen($content);
echo "Longitud del contenido: {$contentLength} caracteres\n\n";

// Verificar código Blade
$hasBlade = false;
$bladePatterns = [];

if (preg_match('/@if\s*\(/', $content)) {
    $hasBlade = true;
    $bladePatterns[] = '@if';
}
if (preg_match('/@include\s*\(/', $content)) {
    $hasBlade = true;
    $bladePatterns[] = '@include';
}
if (preg_match('/\{\{.*\}\}/', $content)) {
    $hasBlade = true;
    $bladePatterns[] = '{{ }}';
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📋 ANÁLISIS DEL CONTENIDO:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Contiene código Blade: " . ($hasBlade ? 'SÍ ❌' : 'NO ✅') . "\n";
if ($hasBlade) {
    echo "Patrones Blade encontrados: " . implode(', ', $bladePatterns) . "\n";
}

// Guardar contenido completo
$outputFile = __DIR__ . '/page-content-sample-production.txt';
file_put_contents($outputFile, "=== CONTENIDO COMPLETO DE LA PÁGINA (PRODUCCIÓN) ===\n\n");
file_put_contents($outputFile, "ID: {$homePage->id}\n", FILE_APPEND);
file_put_contents($outputFile, "Título: {$homePage->title}\n", FILE_APPEND);
file_put_contents($outputFile, "Website: {$website->name}\n", FILE_APPEND);
file_put_contents($outputFile, "Template: {$website->template_id}\n", FILE_APPEND);
file_put_contents($outputFile, "Longitud: {$contentLength} caracteres\n", FILE_APPEND);
file_put_contents($outputFile, "Tiene Blade: " . ($hasBlade ? 'SÍ' : 'NO') . "\n", FILE_APPEND);
file_put_contents($outputFile, "\n=== CONTENIDO HTML ===\n\n", FILE_APPEND);
file_put_contents($outputFile, $content, FILE_APPEND);

echo "\n💾 Contenido completo guardado en: page-content-sample-production.txt\n";

// Mostrar vista previa
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📄 VISTA PREVIA (primeros 500 caracteres):\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$preview = substr($content, 0, 500);
echo $preview . "...\n";

echo "\n✅ Consulta completada\n";

