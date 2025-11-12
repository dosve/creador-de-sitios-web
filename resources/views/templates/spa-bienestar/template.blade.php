<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  
  {{-- Estilos CSS personalizados de la página --}}
  @if($page && $page->css_content)
    <style>
      {!! $page->css_content !!}
    </style>
  @endif
</head>
<body class="bg-gray-50" data-page-id="{{ $page ? $page->id : '' }}">
  {{-- Barra de administración para propietarios logueados --}}
  @if(Auth::check() && (Auth::user()->role === "admin" || Auth::user()->id === $website->user_id))
    <x-admin-bar :website="$website" />
  @endif
  
  {{-- Header de la plantilla --}}
  @include('templates.spa-bienestar.header')
  
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
  @include('templates.spa-bienestar.footer')
  
  {{-- Scripts globales para funcionalidad dinámica --}}
  <x-global-scripts :website="$website" :customization="$customization ?? []" />
</body>
</html>