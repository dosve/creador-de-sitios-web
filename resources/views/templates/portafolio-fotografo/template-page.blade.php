<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'Foto'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;600&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif
    }

    .font-heading {
      font-family: 'Oswald', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1600px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-white">@php $h=$customization['header']??[];@endphp @include('templates.portafolio-fotografo.header')<main class="min-h-screen py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <h1 class="font-heading text-5xl md:text-6xl font-light mb-12 text-center tracking-wider">{{strtoupper($page->title??'TÍTULO')}}</h1>
      <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.portafolio-fotografo.footer')</body>
</html>
