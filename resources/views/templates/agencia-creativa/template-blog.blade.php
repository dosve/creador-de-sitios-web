<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Agencia Creativa' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-heading {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width'] ?? '1280px'
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
  @include('templates.agencia-creativa.header')

  {{-- Hero --}}
  <section class="bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 py-20">
    <div class="container px-6 mx-auto text-center">
      <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Blog</span>
      <h1 class="font-heading text-5xl md:text-6xl font-bold mt-4 mb-6">Insights & Tendencias</h1>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        Las últimas noticias sobre diseño, desarrollo y creatividad digital
      </p>
    </div>
  </section>

  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts ?? [] as $post)
        <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow">
          @if($post->featured_image)
          <a href="{{ route('blog.show', $post) }}" class="block overflow-hidden">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
          </a>
          @else
          <div class="h-56 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
            <svg class="w-16 h-16 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          @endif

          <div class="p-6">
            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
              <span>{{ $post->created_at->format('d M, Y') }}</span>
              @if($post->category)
              <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                {{ $post->category->name }}
              </span>
              @endif
            </div>

            <h2 class="font-heading text-xl font-bold mb-3 group-hover:text-purple-600 transition-colors">
              <a href="{{ route('blog.show', $post) }}">
                {{ $post->title }}
              </a>
            </h2>

            <p class="text-gray-600 mb-4 line-clamp-2">
              {{ Str::limit($post->excerpt, 120) }}
            </p>

            <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center text-purple-600 hover:text-pink-600 font-medium transition-colors">
              Leer más
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </article>
        @empty
        <div class="col-span-3 py-24 text-center">
          <svg class="w-24 h-24 mx-auto mb-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="font-heading text-3xl font-bold mb-2">No hay publicaciones</h3>
          <p class="text-gray-600">Aún no se han publicado artículos en el blog.</p>
        </div>
        @endforelse
      </div>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.agencia-creativa.footer')
</body>
</html>
