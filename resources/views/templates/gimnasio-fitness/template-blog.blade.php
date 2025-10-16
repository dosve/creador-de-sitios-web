<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{$website->name??'Gym'}}</title>
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

  </style>
</head>
<body class="bg-gray-900 text-white">@php $h=$customization['header']??[];@endphp @include('templates.gimnasio-fitness.header')<section class="bg-gradient-to-br from-red-900 to-gray-900 py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-7xl mb-4">BLOG</h1>
      <p class="text-2xl">Tips de fitness y nutrición</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-8">@forelse($posts??[] as $post)<article class="bg-gray-800 rounded-lg overflow-hidden hover:bg-gray-700 transition-colors">@if($post->featured_image)<img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full h-48 object-cover">@else<div class="h-48 bg-gray-700"></div>@endif<div class="p-6">
            <h2 class="font-heading text-2xl mb-3"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
            <p class="text-gray-400 text-sm">{{Str::limit($post->excerpt,100)}}</p>
          </div>
        </article>@empty<div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-4xl">NO HAY POSTS</h3>
        </div>@endforelse</div>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.gimnasio-fitness.footer')
</body>
</html>
