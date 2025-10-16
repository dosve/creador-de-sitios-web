<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'Banda'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto Condensed', sans-serif;
      background: #0a0a0a;
      color: #f5f5f5
    }

    .font-heading {
      font-family: 'Bebas Neue', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1200px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body>@include('templates.musico-banda.header')<main class="py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <h1 class="font-heading text-6xl mb-8">{{strtoupper($page->title??'TÍTULO')}}</h1>
      <div class="prose prose-invert prose-lg max-w-none">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
    </div>
  </main>@include('templates.musico-banda.footer')</body>
</html>
