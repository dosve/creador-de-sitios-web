<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'Gym'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif
    }

    .font-heading {
      font-family: 'Bebas Neue', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1280px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-gray-900 text-white">@php $h=$customization['header']??[];@endphp @include('templates.gimnasio-fitness.header')<main class="min-h-screen py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <h1 class="font-heading text-6xl mb-8">{{$page->title??'TÍTULO'}}</h1>
      <div class="prose prose-invert prose-lg max-w-none">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.gimnasio-fitness.footer')</body>
</html>
