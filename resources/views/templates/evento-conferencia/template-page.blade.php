<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$page->title??'Página'}} - {{$website->name??'Evento'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Ubuntu', sans-serif
    }

    .font-heading {
      font-family: 'Montserrat', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1300px'
        }
      }
    }

  </style>@if($page->css_content??false)<style>
    {
       ! !$page->css_content ! !
    }

  </style>@endif
</head>
<body class="bg-purple-50">@include('templates.evento-conferencia.header')<main class="py-20">
    <div class="container px-6 mx-auto max-w-4xl">
      <article class="bg-white p-8 md:p-12 rounded-lg shadow-sm">
        <h1 class="font-heading text-4xl md:text-5xl font-bold mb-8 text-purple-900">{{$page->title??'Título'}}</h1>
        <div class="prose prose-lg max-w-none">{!!$page->html_content??'<p>Contenido...</p>'!!}</div>
      </article>
    </div>
  </main>@include('templates.evento-conferencia.footer')</body>
</html>
