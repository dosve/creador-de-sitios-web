<?php

/**
 * Elimina el sitio lyman-sas (y en cascada: páginas, menús, etc.).
 * Uso: php scripts/reset-lyman.php
 *
 * Para eliminar y recrear todo, ejecuta: reset-lyman.bat
 * (el .bat borra con este script y luego corre los seeders en consola).
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Website;

echo "=== Reset sitio LYMAN SAS ===\n\n";

$slug = 'lyman-sas';
$website = Website::where('slug', $slug)->first();

if ($website) {
    $id = $website->id;
    $website->delete();
    echo "✓ Sitio '{$slug}' (ID {$id}) eliminado.\n";
} else {
    echo "○ No existía sitio '{$slug}'.\n";
}

echo "\n=== Listo ===\n";
