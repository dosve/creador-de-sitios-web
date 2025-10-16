<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Restaurante' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-display {
      font-family: 'Playfair Display', serif;
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
<body class="bg-amber-50">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.restaurante-menu.header')

  <main class="min-h-screen py-16">
    <div class="container px-6 mx-auto">
      <article class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-12">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-amber-900 mb-8">
          {{ $page->title ?? 'Título de la Página' }}
        </h1>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
          {!! $page->html_content ?? '<p>Contenido de la página aquí...</p>' !!}
        </div>
      </article>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.restaurante-menu.footer')
</body>
</html>
