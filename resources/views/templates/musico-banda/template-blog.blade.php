<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Blog - {{$website->name??'Banda'}}</title>
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

  </style>
</head>
<body>@include('templates.musico-banda.header')<section class="bg-gradient-to-br from-red-900 to-black py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-7xl mb-4">NOTICIAS</h1>
      <p class="text-xl text-red-200">Últimas novedades</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-8">@forelse($posts??[] as $post)<article class="bg-gray-900 rounded-lg overflow-hidden hover:bg-gray-800 transition-colors">@if($post->featured_image)<img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full h-48 object-cover">@else<div class="h-48 bg-red-900"></div>@endif<div class="p-6">
            <h2 class="font-heading text-2xl mb-3"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
            <p class="text-gray-400 text-sm">{{Str::limit($post->excerpt,100)}}</p>
          </div>
        </article>@empty<div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-4xl">NO HAY POSTS</h3>
        </div>@endforelse</div>
    </div>
  </main>@include('templates.musico-banda.footer')
</body>
</html>
