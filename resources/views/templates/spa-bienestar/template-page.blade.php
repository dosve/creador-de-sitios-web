<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Spa' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif
    }

    .font-heading {
      font-family: 'Cinzel', serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1200px'
        }
      }
    }

  </style>
  @if($page->css_content ?? false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-stone-50">
  @php $headerConfig=$customization['header']??[];@endphp
  @include('templates.spa-bienestar.header')
  <main class="min-h-screen py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <h1 class="font-heading text-5xl font-light mb-8 text-center text-amber-900">{{$page->title??'Título'}}</h1>
      <div class="prose prose-lg max-w-none text-stone-700 leading-relaxed">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
    </div>
  </main>
  @php $footerConfig=$customization['footer']??[];@endphp
  @include('templates.spa-bienestar.footer')
</body>
</html>
