<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Agencia' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-heading {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1280px'
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
  @include('templates.agencia-creativa.header')

  <main class="min-h-screen py-20">
    <div class="container px-6 mx-auto">
      <article class="max-w-4xl mx-auto">
        <h1 class="font-heading text-4xl md:text-6xl font-bold mb-8 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
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
  @include('templates.agencia-creativa.footer')
</body>
</html>
