<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'Blog'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Merriweather', serif
    }

    .font-heading {
      font-family: 'Lora', serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'740px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-white">@include('templates.blog-minimalista.header')<main class="py-16">
    <div class="container px-6 mx-auto">
      <h1 class="font-heading text-5xl font-bold mb-8">{{$page->title??'Título'}}</h1>
      <div class="prose prose-lg max-w-none">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
    </div>
  </main>@include('templates.blog-minimalista.footer')</body>
</html>
