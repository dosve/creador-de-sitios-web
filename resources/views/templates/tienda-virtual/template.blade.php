<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ isset($product) ? ($product['nombre'] ?? $product['name'] ?? 'Producto') . ' - ' . $website->name : (isset($blogPost) ? $blogPost->title . ' - ' . $website->name : (isset($page) && $page ? ($page->title ?? $website->name) : ($website->name ?? "Mi Sitio Web"))) }}</title>
  <meta name="description" content="{{ isset($product) ? ($product['descripcion'] ?? $product['description'] ?? '') : (isset($blogPost) ? ($blogPost->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blogPost->content), 160)) : (isset($page) && $page ? ($page->meta_description ?? $website->description) : ($website->description ?? "Descripción de mi sitio web"))) }}">
  @php
    $isProduction = app()->environment('production');
    $hasCompiledCss = file_exists(public_path('build/assets/app.css'));
  @endphp
  @if($isProduction && $hasCompiledCss)
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
  @else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      // Suprimir advertencia de producción en desarrollo
      (function() {
        if (typeof tailwind !== 'undefined' && tailwind.config) {
          try {
            // Intentar suprimir la advertencia
            const originalWarn = console.warn;
            console.warn = function(...args) {
              if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com should not be used in production')) {
                return; // Suprimir esta advertencia específica
              }
              originalWarn.apply(console, args);
            };
          } catch(e) {
            // Ignorar errores al suprimir advertencias
          }
        }
      })();
    </script>
  @endif
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  {{-- CSS específico de la plantilla --}}
  @if(\App\Helpers\TemplateCssHelper::hasCss('tienda-virtual'))
    {!! \App\Helpers\TemplateCssHelper::renderCss('tienda-virtual', $customization ?? []) !!}
  @endif
  
  {{-- Estilos CSS personalizados de la página --}}
  @if(isset($page) && $page && $page->css_content)
    @php
      echo '<style>';
      echo $page->css_content;
      echo '</style>';
    @endphp
  @endif
</head>
<body class="bg-gray-50 tienda-template" data-page-id="{{ isset($page) && $page ? $page->id : '' }}">
  {{-- Barra de administración para propietarios logueados --}}
  @if(Auth::check() && (Auth::user()->role === "admin" || Auth::user()->id === $website->user_id))
    <x-admin-bar :website="$website" />
  @endif
  
  {{-- Configuración del header basado en la página y la plantilla --}}
  @php
    $headerConfig = array_merge(
      $customization['header'] ?? [],
      [
        // Si la página tiene enable_store activado, mostrar el carrito
        'show_cart' => (isset($page) && $page ? ($page->enable_store ?? false) : false) && ($customization['header']['show_cart'] ?? true)
      ]
    );
  @endphp
  
  {{-- Header de la plantilla --}}
  @include('templates.tienda-virtual.header')
  
  {{-- Mensajes Flash --}}
  @if(session('error'))
  <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-auto max-w-7xl mt-4">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <p class="text-red-800">{{ session('error') }}</p>
    </div>
  </div>
  @endif
  
  @if(session('success'))
  <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-auto max-w-7xl mt-4">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <p class="text-green-800">{{ session('success') }}</p>
    </div>
  </div>
  @endif
  
  {{-- Contenido específico de la página, blog post o producto --}}
  <main class="min-h-screen">
    @if(isset($product))
      {{-- Contenido del producto --}}
      @include('templates.plantilla-basica.product-content', ['product' => $product])
    @elseif(isset($blogPost))
      {{-- Contenido del blog post --}}
      @include('templates.plantilla-basica.blog-post-content', ['blogPost' => $blogPost, 'relatedPosts' => $relatedPosts ?? collect()])
    @elseif(isset($page) && $page && $page->html_content)
      {!! $page->html_content !!}
    @elseif(isset($page) && $page)
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
  @include('templates.tienda-virtual.footer')
  
  {{-- Scripts globales para funcionalidad dinámica --}}
  <x-global-scripts :website="$website" :customization="$customization ?? []" />

  @if(isset($page) && $page && ($page->enable_store ?? false))
    <script src="https://checkout.epayco.co/checkout.js" defer></script>
    @include('components.payments.epayco.handler', [
        'publicKey' => $website->epayco_public_key ?? '',
        'privateKey' => $website->epayco_private_key ?? '',
        'customerId' => $website->epayco_customer_id ?? ''
    ])
    <x-cart.script 
        :templateSlug="'tienda-virtual'"
        :colors="$customization['colors'] ?? []"
        :paymentHandler="'epayco'"
        :websiteSlug="$website->slug"
    />
  @endif
</body>
</html>