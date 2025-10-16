<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Blog - {{$website->name??'CV'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif
    }

    .font-heading {
      font-family: 'Space Grotesk', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1100px'
        }
      }
    }

  </style>
</head>
<body class="bg-slate-50">@php $h=$customization['header']??[];@endphp @include('templates.cv-personal.header')<section class="py-20 bg-gradient-to-br from-blue-600 to-cyan-500 text-white">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl font-bold mb-4">Blog</h1>
      <p class="text-xl text-blue-100">Artículos y pensamientos</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">@forelse($posts??[] as $post)<article class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">@if($post->featured_image)<img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full h-48 object-cover">@else<div class="h-48 bg-slate-200"></div>@endif<div class="p-6">
            <div class="text-sm text-slate-500 mb-3">{{$post->created_at->format('d M, Y')}}</div>
            <h2 class="font-heading text-xl font-bold mb-3 hover:text-blue-600"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
            <p class="text-slate-600 text-sm">{{Str::limit($post->excerpt,100)}}</p>
          </div>
        </article>@empty<div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-2xl font-bold">No hay publicaciones</h3>
        </div>@endforelse</div>
    </div>
  </main>@php $f=$customization['footer']??[];@endphp @include('templates.cv-personal.footer')
</body>
</html>
