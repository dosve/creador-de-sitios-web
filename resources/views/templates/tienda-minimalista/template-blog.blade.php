<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Tienda Minimalista' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1200px'
        }
      }

      ;
    }

  </style>
</head>
<body class="antialiased bg-white">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.header')

  <main class="py-24">
    <div class="container px-6 mx-auto">
      <div class="max-w-2xl mx-auto mb-16 text-center">
        <h1 class="text-5xl font-bold mb-6">Blog</h1>
        <p class="text-xl text-gray-600">Historias, ideas y pensamientos</p>
      </div>

      <div class="max-w-4xl mx-auto space-y-16">
        @forelse($posts ?? [] as $post)
        <article class="group">
          @if($post->featured_image)
          <a href="{{ route('blog.show', $post) }}" class="block mb-8">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full aspect-[16/9] object-cover rounded-2xl transition-transform duration-500 group-hover:scale-[1.02]">
          </a>
          @endif

          <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
            <span>{{ $post->created_at->format('d M, Y') }}</span>
            @if($post->category)
            <span>·</span>
            <span class="text-black">{{ $post->category->name }}</span>
            @endif
          </div>

          <h2 class="text-3xl font-bold mb-4 group-hover:text-blue-600 transition-colors">
            <a href="{{ route('blog.show', $post) }}">
              {{ $post->title }}
            </a>
          </h2>

          <p class="text-lg text-gray-600 mb-6 leading-relaxed">
            {{ Str::limit($post->excerpt, 200) }}
          </p>

          <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            Leer más
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </article>
        @empty
        <div class="py-24 text-center">
          <svg class="w-16 h-16 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="text-2xl font-semibold mb-2">No hay publicaciones</h3>
          <p class="text-gray-600">Aún no se han publicado artículos en el blog.</p>
        </div>
        @endforelse
      </div>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.tienda-minimalista.footer')
</body>
</html>
