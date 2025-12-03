<?php
/**
 * Script para verificar la configuración de API del sitio mashcol
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Buscar sitio por slug
$website = \App\Models\Website::where('slug', 'mashcol')
    ->orWhere('slug', 'sitio')
    ->first();

if (!$website) {
    echo "❌ No se encontró el sitio 'mashcol' o 'sitio'\n";
    exit(1);
}

echo "✅ Sitio encontrado:\n";
echo "   ID: {$website->id}\n";
echo "   Slug: {$website->slug}\n";
echo "   Nombre: {$website->name}\n";
echo "   API Base URL: " . ($website->api_base_url ?: '❌ NO CONFIGURADA') . "\n";
echo "   API Key: " . ($website->api_key ? '✅ Configurada (' . strlen($website->api_key) . ' caracteres)' : '❌ NO CONFIGURADA') . "\n";

// Verificar qué URL se usaría para login
if ($website->api_base_url) {
    $apiUrl = rtrim($website->api_base_url, '/');
    $loginUrl = str_ends_with($apiUrl, '/api') ? $apiUrl . '/login' : $apiUrl . '/api/login';
    echo "\n📡 URL que se usará para login:\n";
    echo "   {$loginUrl}\n";
}

echo "\n";

