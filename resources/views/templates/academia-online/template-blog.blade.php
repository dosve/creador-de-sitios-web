<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Blog - {{$website->name??'Academia'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Nunito', sans-serif
    }

    .font-heading {
      font-family: 'Raleway', sans-serif
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
<body class="bg-gray-50">@include('templates.academia-online.header')<section class="bg-gradient-to-br from-violet-600 to-blue-600 text-white py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl font-bold mb-4">Blog Educativo</h1>
      <p class="text-xl text-violet-100">Aprende con nuestros artículos</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-8">@forelse($posts??[] as $post)<article class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow">@if($post->featured_image)<img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full h-48 object-cover rounded-t-lg">@else<div class="h-48 bg-violet-200 rounded-t-lg"></div>@endif<div class="p-6">
            <h2 class="font-heading text-xl font-bold mb-3"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
            <p class="text-gray-600 text-sm">{{Str::limit($post->excerpt,100)}}</p>
          </div>
        </article>@empty<div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-2xl">No hay artículos</h3>
        </div>@endforelse</div>
    </div>
  </main>@include('templates.academia-online.footer')
</body>
</html>
