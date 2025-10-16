<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Boutique' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      letter-spacing: 0.02em;
    }

    .font-display {
      font-family: 'Cormorant Garamond', serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1400px'
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
  @include('templates.moda-boutique.header')

  <main class="min-h-screen py-24">
    <div class="container px-6 mx-auto">
      <article class="max-w-4xl mx-auto">
        <h1 class="font-display text-5xl md:text-6xl font-light mb-12 text-center tracking-wide">
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
  @include('templates.moda-boutique.footer')
</body>
</html>
