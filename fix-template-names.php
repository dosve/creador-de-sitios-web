<?php
/**
 * Script para arreglar los nombres de plantillas en todos los templates
 * 
 * Este script corrige las referencias a $templateName por el nombre real de cada plantilla
 */

$templatesDir = __DIR__ . '/resources/views/templates/';

echo "🔧 Arreglando nombres de plantillas en todos los templates...\n\n";

// Obtener todas las plantillas
$templates = glob($templatesDir . '*/template.blade.php');

foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "📄 Procesando: $templateName\n";
    
    // Leer el contenido del template
    $content = file_get_contents($templateFile);
    
    // Reemplazar las referencias incorrectas
    $content = str_replace('@include("templates.{$templateName}.header")', "@include('templates.{$templateName}.header')", $content);
    $content = str_replace('@include("templates.{$templateName}.footer")', "@include('templates.{$templateName}.footer')", $content);
    
    // Escribir el archivo corregido
    file_put_contents($templateFile, $content);
    echo "   ✅ Nombres corregidos\n";
}

echo "\n🎉 ¡Proceso completado! Todos los templates ahora tienen los nombres correctos.\n";
echo "\n📋 Templates procesados:\n";
foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "   - $templateName\n";
}
