<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Tienda' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }

      ;
    }

  </style>

  @if($page->css_content ?? false)
  <style>
    {
       ! ! $page->css_content ! !
    }

  </style>
  @endif
</head>
<body class="antialiased bg-white">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.header')

  <main class="min-h-screen py-24">
    <div class="container px-6 mx-auto">
      <article class="max-w-3xl mx-auto">
        <h1 class="text-5xl font-bold mb-8 tracking-tight">{{ $page->title ?? 'Título de la Página' }}</h1>

        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
          {!! $page->html_content ?? '<p>Contenido de la página aquí...</p>' !!}
        </div>
      </article>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.footer')

  @include('templates.partials.cart-script')
</body>
</html>
