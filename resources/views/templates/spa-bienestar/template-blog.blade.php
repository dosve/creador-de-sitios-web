<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Spa' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif
    }

    .font-heading {
      font-family: 'Cinzel', serif
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
<body class="bg-stone-50">
  @php $headerConfig=$customization['header']??[];@endphp
  @include('templates.spa-bienestar.header')
  <section class="bg-gradient-to-br from-amber-100 to-stone-100 py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl font-light mb-4 text-amber-900">Blog de Bienestar</h1>
      <p class="text-xl text-stone-600">Tips y consejos para tu salud</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-3 gap-8">
        @forelse($posts??[] as $post)
        <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
          @if($post->featured_image)<img src="{{$post->featured_image}}" alt="{{$post->title}}" class="w-full h-48 object-cover">@else<div class="h-48 bg-stone-200"></div>@endif
          <div class="p-6">
            <h2 class="font-heading text-xl mb-3"><a href="{{route('blog.show',$post)}}">{{$post->title}}</a></h2>
            <p class="text-stone-600 text-sm">{{Str::limit($post->excerpt,100)}}</p>
          </div>
        </article>
        @empty
        <div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-2xl">No hay publicaciones</h3>
        </div>
        @endforelse
      </div>
    </div>
  </main>
  @php $footerConfig=$customization['footer']??[];@endphp
  @include('templates.spa-bienestar.footer')
</body>
</html>
