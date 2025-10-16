<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Consultoría' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }

    .font-heading {
      font-family: 'Merriweather', serif;
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
<body class="bg-slate-50">
  @php $headerConfig = $customization['header'] ?? []; @endphp
  @include('templates.consultoria-corporativa.header')
  <main class="min-h-screen py-20">
    <div class="container px-6 mx-auto">
      <article class="max-w-4xl mx-auto bg-white p-12 rounded-lg shadow-sm">
        <h1 class="font-heading text-4xl md:text-5xl font-bold mb-8 text-blue-900">{{ $page->title ?? 'Título' }}</h1>
        <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
          {!! $page->html_content ?? '<p>Contenido aquí...</p>' !!}
        </div>
      </article>
    </div>
  </main>
  @php $footerConfig = $customization['footer'] ?? []; @endphp
  @include('templates.consultoria-corporativa.footer')
</body>
</html>
