<?php
// Script de diagnóstico para verificar dominios y páginas
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔍 Diagnóstico de Dominios y Páginas</h1>";
echo "<hr>";

$host = $_SERVER['HTTP_HOST'] ?? 'desconocido';
echo "<h2>📍 Host Actual: <code>{$host}</code></h2>";

// Verificar dominio
echo "<h3>1. Verificar Dominio</h3>";
$domain = DB::table('domains')->where('domain', $host)->first();

if ($domain) {
    echo "<pre style='background:#d4edda; padding:10px; border-radius:5px;'>";
    echo "✅ DOMINIO ENCONTRADO:\n";
    echo "ID: {$domain->id}\n";
    echo "Website ID: {$domain->website_id}\n";
    echo "Verificado: " . ($domain->is_verified ? 'SÍ' : 'NO') . "\n";
    echo "Estado: {$domain->status}\n";
    echo "</pre>";
    
    // Verificar website
    echo "<h3>2. Verificar Website</h3>";
    $website = DB::table('websites')->where('id', $domain->website_id)->first();
    
    if ($website) {
        echo "<pre style='background:#d4edda; padding:10px; border-radius:5px;'>";
        echo "✅ WEBSITE ENCONTRADO:\n";
        echo "ID: {$website->id}\n";
        echo "Nombre: {$website->name}\n";
        echo "Slug: {$website->slug}\n";
        echo "Publicado: " . ($website->is_published ? 'SÍ' : 'NO') . "\n";
        echo "Plantilla: {$website->template_id}\n";
        echo "</pre>";
        
        // Verificar páginas
        echo "<h3>3. Páginas del Sitio</h3>";
        $pages = DB::table('pages')->where('website_id', $website->id)->get();
        
        if ($pages->count() > 0) {
            echo "<table border='1' cellpadding='5' style='border-collapse:collapse; width:100%;'>";
            echo "<tr style='background:#007bff; color:white;'>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Slug</th>
                    <th>Publicada</th>
                    <th>Es Inicio</th>
                    <th>URL</th>
                  </tr>";
            
            foreach ($pages as $page) {
                $publicada = $page->is_published ? '✅' : '❌';
                $esInicio = $page->is_home ? '🏠' : '';
                $url = "https://{$host}/{$page->slug}";
                
                $rowColor = $page->is_published ? '#d4edda' : '#f8d7da';
                
                echo "<tr style='background:{$rowColor};'>
                        <td>{$page->id}</td>
                        <td>{$page->title}</td>
                        <td><strong>{$page->slug}</strong></td>
                        <td>{$publicada}</td>
                        <td>{$esInicio}</td>
                        <td><a href='{$url}' target='_blank'>{$url}</a></td>
                      </tr>";
            }
            
            echo "</table>";
        } else {
            echo "<pre style='background:#fff3cd; padding:10px; border-radius:5px;'>";
            echo "⚠️ NO HAY PÁGINAS EN ESTE SITIO\n";
            echo "Crea al menos una página desde el panel del creador.";
            echo "</pre>";
        }
    } else {
        echo "<pre style='background:#f8d7da; padding:10px; border-radius:5px;'>";
        echo "❌ WEBSITE NO ENCONTRADO con ID: {$domain->website_id}";
        echo "</pre>";
    }
} else {
    echo "<pre style='background:#f8d7da; padding:10px; border-radius:5px;'>";
    echo "❌ DOMINIO NO ENCONTRADO: {$host}\n\n";
    echo "Dominios en la base de datos:\n";
    
    $allDomains = DB::table('domains')->get();
    foreach ($allDomains as $d) {
        echo "- {$d->domain} (Website ID: {$d->website_id}, Verificado: " . ($d->is_verified ? 'SÍ' : 'NO') . ")\n";
    }
    echo "</pre>";
}

echo "<hr>";
echo "<h3>4. Configuración del Servidor</h3>";
echo "<pre style='background:#e7f3ff; padding:10px; border-radius:5px;'>";
echo "PHP Version: " . phpversion() . "\n";
echo "Laravel: " . app()->version() . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'desconocido') . "\n";
echo "Script Filename: " . (__FILE__) . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'desconocido') . "\n";
echo "</pre>";

echo "<hr>";
echo "<p><a href='/' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>← Volver al Inicio</a></p>";
?>

