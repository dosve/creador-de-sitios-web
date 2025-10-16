<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Blog'}}</title>
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

  </style>
</head>
<body class="bg-white text-gray-900">@php $h=$customization['header']??[];@endphp @include('templates.blog-minimalista.header')<main class="py-16">
    <div class="container px-6 mx-auto">
      <article class="mb-16">
        <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6 leading-tight">Título del Artículo Principal</h2>
        <div class="flex items-center text-sm text-gray-500 mb-8"><span>Por Autor</span><span class="mx-2">•</span><span>15 min lectura</span></div>
        <div class="prose prose-lg max-w-none">
          <p class="text-xl leading-relaxed mb-6">Este es un blog minimalista centrado en la lectura. El diseño limpio permite que el contenido sea el protagonista.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </article>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.blog-minimalista.footer')</body>
</html>
