<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'CV'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif
    }

    .font-heading {
      font-family: 'Space Grotesk', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1100px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-slate-50">@php $h=$customization['header']??[];@endphp @include('templates.cv-personal.header')<main class="min-h-screen py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <article class="bg-white p-8 md:p-12 rounded-lg shadow-sm">
        <h1 class="font-heading text-4xl md:text-5xl font-bold mb-8">{{$page->title??'Título'}}</h1>
        <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
      </article>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.cv-personal.footer')</body>
</html>
