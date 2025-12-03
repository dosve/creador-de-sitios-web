<?php
/**
 * Script para actualizar la configuración de API a HTTPS
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Actualizar TODOS los sitios que usen HTTP a HTTPS
$websites = \App\Models\Website::where('api_base_url', 'LIKE', 'http://servidor.adminnegocios.com%')->get();

if ($websites->isEmpty()) {
    echo "❌ No se encontraron sitios con http://servidor.adminnegocios.com\n";
    exit(1);
}

echo "📋 Sitios a actualizar:\n\n";

foreach ($websites as $website) {
    echo "✏️  Sitio: {$website->name} (slug: {$website->slug})\n";
    echo "   Antes: {$website->api_base_url}\n";
    
    // Cambiar HTTP a HTTPS
    $website->api_base_url = str_replace('http://', 'https://', $website->api_base_url);
    $website->save();
    
    echo "   Después: {$website->api_base_url}\n\n";
}

echo "✅ Actualización completada!\n";

