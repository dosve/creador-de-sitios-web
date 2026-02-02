#!/usr/bin/env php
<?php
/**
 * Script CLI para Inspeccionar Página
 * Uso: php artisan inspect:page 33
 */

require __DIR__ . '/../bootstrap/app.php';

use App\Models\Page;

$pageId = isset($argv[1]) ? (int)$argv[1] : 33;

if ($pageId === 0) {
    echo "❌ Uso: php inspect-cli.php <page_id>\n";
    echo "Ejemplo: php inspect-cli.php 33\n";
    exit(1);
}

$page = Page::find($pageId);

if (!$page) {
    echo "❌ Página no encontrada: $pageId\n";
    exit(1);
}

// Colores ANSI
$green = "\033[92m";
$red = "\033[91m";
$yellow = "\033[93m";
$blue = "\033[94m";
$reset = "\033[0m";
$bold = "\033[1m";

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║        INSPECTOR DE PÁGINA - CLI                           ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Información Básica
echo "{$bold}📋 INFORMACIÓN BÁSICA{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "ID:        $page->id\n";
echo "Título:    $page->title\n";
echo "Slug:      $page->slug\n";
echo "Website:   {$page->website->name} (ID: {$page->website->id})\n";
echo "Página de Inicio: " . ($page->is_home ? "{$green}✓ Sí{$reset}" : "{$red}✗ No{$reset}") . "\n";
echo "Publicada:        " . ($page->is_published ? "{$green}✓ Sí{$reset}" : "{$red}✗ No{$reset}") . "\n";
echo "Creada:    " . $page->created_at->format('d/m/Y H:i:s') . "\n";
echo "Actualizada: " . $page->updated_at->format('d/m/Y H:i:s') . "\n\n";

// Contenido HTML
echo "{$bold}📄 CONTENIDO HTML{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";
$htmlLength = strlen($page->html_content);
if ($htmlLength > 0) {
    echo "{$green}✓ Presente{$reset} ({$htmlLength} caracteres)\n";
    echo "  • Divs encontrados: " . substr_count($page->html_content, '<div') . "\n";
    echo "  • Secciones encontradas: " . substr_count($page->html_content, '<section') . "\n";
    echo "  • Imágenes encontradas: " . substr_count($page->html_content, '<img') . "\n";
    echo "  • Clases CSS: " . preg_match_all('/class="[^"]*"/', $page->html_content) . "\n";
    echo "  • Estilos inline: " . preg_match_all('/style="[^"]*"/', $page->html_content) . "\n";
    
    // Mostrar primeros 500 caracteres
    echo "\n  {$blue}Primeros 500 caracteres:{$reset}\n";
    $preview = substr($page->html_content, 0, 500);
    echo "  " . str_replace("\n", "\n  ", htmlspecialchars($preview)) . "\n";
    if (strlen($page->html_content) > 500) {
        echo "  ... (truncado)\n";
    }
} else {
    echo "{$red}✗ Vacío{$reset}\n";
    echo "  {$yellow}⚠️  No hay contenido HTML guardado{$reset}\n";
}
echo "\n";

// Contenido CSS
echo "{$bold}🎨 CONTENIDO CSS{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";
$cssLength = strlen($page->css_content);
if ($cssLength > 0) {
    echo "{$green}✓ Presente{$reset} ({$cssLength} caracteres)\n";
    echo "  • Contiene !important: " . (strpos($page->css_content, '!important') !== false ? "✓ Sí" : "✗ No") . "\n";
    echo "  • Selectores de clase: " . preg_match_all('/\.[a-zA-Z0-9\-_]+/', $page->css_content) . "\n";
    echo "  • Selectores de ID: " . preg_match_all('/#[a-zA-Z0-9\-_]+/', $page->css_content) . "\n";
    echo "  • Media queries: " . preg_match_all('/@media/', $page->css_content) . "\n";
    echo "  • Pseudo-clases: " . preg_match_all('/:hover|:active|:focus/', $page->css_content) . "\n";
    
    // Mostrar primeros 500 caracteres
    echo "\n  {$blue}Primeros 500 caracteres:{$reset}\n";
    $preview = substr($page->css_content, 0, 500);
    echo "  " . str_replace("\n", "\n  ", htmlspecialchars($preview)) . "\n";
    if (strlen($page->css_content) > 500) {
        echo "  ... (truncado)\n";
    }
} else {
    echo "{$yellow}⚠️  Vacío{$reset} (normal si solo usas Tailwind)\n";
}
echo "\n";

// Datos GrapesJS
echo "{$bold}⚙️  DATOS GRAPESJS{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";
if (!empty($page->grapesjs_data)) {
    $grapesData = is_array($page->grapesjs_data) ? $page->grapesjs_data : json_decode($page->grapesjs_data, true);
    $componentCount = count($grapesData['components'] ?? []);
    $styleCount = count($grapesData['styles'] ?? []);
    echo "{$green}✓ Presentes{$reset}\n";
    echo "  • Componentes: $componentCount\n";
    echo "  • Reglas de estilo: $styleCount\n";
} else {
    echo "{$yellow}⚠️  Vacíos{$reset} (normal, se guardó en modo HTML/CSS simple)\n";
}
echo "\n";

// Metadatos
echo "{$bold}📋 METADATOS{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "Meta Title:       " . ($page->meta_title ? htmlspecialchars($page->meta_title) : "{$yellow}(vacío){$reset}") . "\n";
echo "Meta Description: " . ($page->meta_description ? htmlspecialchars(substr($page->meta_description, 0, 50)) . "..." : "{$yellow}(vacío){$reset}") . "\n";
echo "Meta Keywords:    " . ($page->meta_keywords ? htmlspecialchars(substr($page->meta_keywords, 0, 50)) . "..." : "{$yellow}(vacío){$reset}") . "\n";
echo "\n";

// Resumen
echo "{$bold}✅ RESUMEN{$reset}\n";
echo "─────────────────────────────────────────────────────────────\n";

$issues = [];

if ($htmlLength === 0) {
    $issues[] = "{$red}HTML está vacío{$reset} - Edita la página y guarda cambios";
}
if (!$page->is_published) {
    $issues[] = "{$yellow}Página no publicada{$reset} - Publica la página para que sea visible";
}

if (empty($issues)) {
    echo "{$green}✓ Todo parece estar bien guardado{$reset}\n";
    echo "\nPara depurar diferencias con la página real:\n";
    echo "  1. Abre: {$blue}http://127.0.0.1:8000/inspect-page-content.php?page_id=$page->id{$reset}\n";
    echo "  2. Ve página real: {$blue}http://127.0.0.1:8000/eme10/prueba{$reset}\n";
    echo "  3. Compara ancho de viewport (F12 en ambas)\n";
} else {
    echo "{$red}⚠️  Hay problemas:{$reset}\n";
    foreach ($issues as $issue) {
        echo "  • $issue\n";
    }
}

echo "\n";

?>
