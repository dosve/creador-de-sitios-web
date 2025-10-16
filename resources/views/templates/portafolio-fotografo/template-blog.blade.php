<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Blog - {{$website->name??'Foto'}}</title>
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

  </style>
</head>
<body class="bg-white">@php $h=$customization['header']??[];@endphp @include('templates.portafolio-fotografo.header')<section class="py-20 bg-gray-50">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-6xl font-light mb-4 tracking-wider">BLOG</h1>
      <p class="text-xl text-gray-600">Historias detrás de la lente</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-8">@forelse($posts??[] as $post)<article class="group">@if($post->featured_image)<a href="{{route('blog.show',$post)}}" class="block mb-6"><img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full aspect-[4/3] object-cover group-hover:opacity-75 transition-opacity"></a>@else<div class="aspect-[4/3] bg-gray-200 mb-6"></div>@endif<h2 class="font-heading text-2xl mb-3 tracking-wide"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
          <p class="text-gray-600 text-sm">{{Str::limit($post->excerpt,120)}}</p>
        </article>@empty<div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-3xl tracking-wider">NO HAY POSTS</h3>
        </div>@endforelse</div>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.portafolio-fotografo.footer')
</body>
</html>
