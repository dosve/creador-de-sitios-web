<?php
/**
 * Script para actualizar la configuración de API del sitio mashcol
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Configuración
$siteSlug = 'mashcol'; // Cambiar si es necesario
$apiBaseUrl = 'https://servidor.adminnegocios.com/api';
$apiKey = 'sk_BeCacJQ2bbT21SrCsItaSEbYe8VdmUTb62TPUaAt';

// Buscar sitio
$website = \App\Models\Website::where('slug', $siteSlug)->first();

if (!$website) {
    echo "❌ No se encontró el sitio '{$siteSlug}'\n";
    echo "\nSitios disponibles:\n";
    \App\Models\Website::all(['id', 'slug', 'name'])->each(function($site) {
        echo "  - {$site->slug} (ID: {$site->id}, Nombre: {$site->name})\n";
    });
    exit(1);
}

echo "📝 Configuración actual:\n";
echo "   API Base URL: " . ($website->api_base_url ?: '(vacío)') . "\n";
echo "   API Key: " . ($website->api_key ? 'Configurada' : '(vacío)') . "\n\n";

echo "🔄 Actualizando a:\n";
echo "   API Base URL: {$apiBaseUrl}\n";
echo "   API Key: {$apiKey}\n\n";

// Actualizar
$website->api_base_url = $apiBaseUrl;
$website->api_key = $apiKey;
$website->save();

echo "✅ Configuración actualizada exitosamente\n\n";

echo "📡 URL que se usará para login:\n";
$apiUrl = rtrim($website->api_base_url, '/');
$loginUrl = str_ends_with($apiUrl, '/api') ? $apiUrl . '/login' : $apiUrl . '/api/login';
echo "   {$loginUrl}\n";

