<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Blog - {{$website->name??'Blog'}}</title>
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
<body class="bg-white">@include('templates.blog-minimalista.header')<main class="py-16">
    <div class="container px-6 mx-auto space-y-16">@forelse($posts??[] as $post)<article>
        <h2 class="font-heading text-3xl font-bold mb-4 hover:text-blue-600"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
        <div class="text-sm text-gray-500 mb-4">{{$post->created_at->format('d M, Y')}}</div>
        <p class="text-lg text-gray-700 leading-relaxed">{{Str::limit($post->excerpt,200)}}</p>
      </article>@empty<p class="text-center text-gray-500 py-16">No hay artículos publicados</p>@endforelse</div>
  </main>@include('templates.blog-minimalista.footer')</body>
</html>
