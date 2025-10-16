<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Boutique' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      letter-spacing: 0.02em;
    }

    .font-display {
      font-family: 'Cormorant Garamond', serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1400px'
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
  @include('templates.moda-boutique.header')

  <main class="py-24">
    <div class="container px-6 mx-auto">
      <div class="text-center mb-16">
        <h1 class="font-display text-5xl md:text-6xl font-light mb-4">Journal</h1>
        <p class="text-gray-600 tracking-wide">ESTILO & INSPIRACIÓN</p>
      </div>

      <div class="grid md:grid-cols-3 gap-12">
        @forelse($posts ?? [] as $post)
        <article class="group">
          @if($post->featured_image)
          <a href="{{ route('blog.show', $post) }}" class="block mb-6">
            <div class="aspect-[4/5] bg-gray-100 overflow-hidden">
              <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
          </a>
          @else
          <div class="aspect-[4/5] bg-gray-100 mb-6 flex items-center justify-center">
            <svg class="w-20 h-20 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          @endif

          <div class="text-center">
            <p class="text-xs tracking-widest text-gray-500 mb-3">
              {{ $post->created_at->format('d M, Y') }}
              @if($post->category)
              · {{ strtoupper($post->category->name) }}
              @endif
            </p>

            <h2 class="text-xl font-light mb-4 group-hover:text-gray-600 transition-colors">
              <a href="{{ route('blog.show', $post) }}">
                {{ $post->title }}
              </a>
            </h2>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
              {{ Str::limit($post->excerpt, 120) }}
            </p>

            <a href="{{ route('blog.show', $post) }}" class="inline-block text-xs tracking-widest border-b border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition-colors">
              LEER MÁS
            </a>
          </div>
        </article>
        @empty
        <div class="col-span-3 py-24 text-center">
          <svg class="w-20 h-20 mx-auto mb-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="font-display text-3xl font-light mb-2">No hay publicaciones</h3>
          <p class="text-gray-600">Aún no se han publicado artículos en el journal.</p>
        </div>
        @endforelse
      </div>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.moda-boutique.footer')
</body>
</html>
