<?php
/**
 * Script para limpiar todos los templates de plantillas
 * 
 * Este script elimina todo el contenido hardcodeado de los templates
 * y los deja solo para renderizar el contenido específico de las páginas
 */

$templatesDir = __DIR__ . '/resources/views/templates/';

echo "🧹 Limpiando todos los templates de plantillas...\n\n";

// Obtener todas las plantillas
$templates = glob($templatesDir . '*/template.blade.php');

foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "📄 Procesando: $templateName\n";
    
    // Crear el template limpio
    $cleanTemplate = createCleanTemplate($templateName);
    
    // Escribir el archivo limpio
    file_put_contents($templateFile, $cleanTemplate);
    echo "   ✅ Template limpiado\n";
}

echo "\n🎉 ¡Proceso completado! Todos los templates ahora solo renderizan contenido de páginas.\n";
echo "\n📋 Templates procesados:\n";
foreach ($templates as $templateFile) {
    $templateName = basename(dirname($templateFile));
    echo "   - $templateName\n";
}

function createCleanTemplate($templateName) {
    return '<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{ $page->title ?? $website->name ?? "Mi Sitio Web" }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? "Descripción de mi sitio web" }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: "Inter", sans-serif;
    }
    .container {
      max-width: {{ $customization["layout"]["container_width"] ?? "1200px" }};
    }
  </style>
</head>
<body class="bg-gray-50">
  {{-- Barra de administración para propietarios logueados --}}
  @if(Auth::check() && (Auth::user()->role === "admin" || Auth::user()->id === $website->user_id))
    <x-admin-bar :website="$website" />
  @endif
  
  {{-- Header de la plantilla --}}
  @include("templates.{$templateName}.header")
  
  {{-- Contenido específico de la página --}}
  <main class="min-h-screen">
    @if($page && $page->html_content)
      {!! $page->html_content !!}
    @else
      <section class="py-20 bg-white">
        <div class="container px-6 mx-auto">
          <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">
              {{ $page->title ?? "Página" }}
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
              {{ $page->meta_description ?? "Contenido de la página" }}
            </p>
          </div>
        </div>
      </section>
    @endif
  </main>
  
  {{-- Footer de la plantilla --}}
  @include("templates.{$templateName}.footer")
  
  {{-- Scripts globales para funcionalidad dinámica --}}
  <x-global-scripts :website="$website" />
</body>
</html>';
}
