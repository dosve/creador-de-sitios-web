<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Restaurante' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-display {
      font-family: 'Playfair Display', serif;
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
<body class="bg-amber-50">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.restaurante-menu.header')

  {{-- Hero --}}
  <section class="bg-gradient-to-br from-amber-600 to-amber-800 text-white py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-display text-5xl md:text-6xl font-bold mb-4">Nuestro Blog</h1>
      <p class="text-xl text-amber-100">Recetas, tips y noticias del mundo culinario</p>
    </div>
  </section>

  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid lg:grid-cols-3 gap-12">
        {{-- Posts --}}
        <div class="lg:col-span-2 space-y-12">
          @forelse($posts ?? [] as $post)
          <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
            @if($post->featured_image)
            <a href="{{ route('blog.show', $post) }}">
              <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
            </a>
            @endif

            <div class="p-8">
              <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                <span>{{ $post->created_at->format('d M, Y') }}</span>
                @if($post->category)
                <span>·</span>
                <span class="text-amber-700 font-medium">{{ $post->category->name }}</span>
                @endif
              </div>

              <h2 class="font-display text-3xl font-bold text-amber-900 mb-4 hover:text-amber-700 transition-colors">
                <a href="{{ route('blog.show', $post) }}">
                  {{ $post->title }}
                </a>
              </h2>

              <p class="text-gray-700 mb-6 leading-relaxed">
                {{ Str::limit($post->excerpt, 180) }}
              </p>

              <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center text-amber-700 hover:text-amber-800 font-semibold">
                Leer más
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </article>
          @empty
          <div class="bg-white rounded-2xl p-16 text-center">
            <svg class="w-20 h-20 mx-auto mb-6 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="font-display text-2xl font-bold text-amber-900 mb-2">No hay publicaciones</h3>
            <p class="text-gray-600">Aún no se han publicado artículos en el blog.</p>
          </div>
          @endforelse
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-8">
          {{-- About --}}
          <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h3 class="font-display text-2xl font-bold text-amber-900 mb-4">Sobre Nosotros</h3>
            <p class="text-gray-700 leading-relaxed">
              Compartimos recetas, consejos culinarios y las últimas noticias de nuestro restaurante.
            </p>
          </div>

          {{-- Categories --}}
          <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h3 class="font-display text-2xl font-bold text-amber-900 mb-6">Categorías</h3>
            <ul class="space-y-3">
              @forelse($categories ?? [] as $category)
              <li>
                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-amber-700 transition-colors group">
                  <span class="group-hover:translate-x-1 transition-transform">{{ $category->name }}</span>
                  <span class="text-sm text-gray-400">({{ $category->posts_count }})</span>
                </a>
              </li>
              @empty
              <li class="text-gray-500 text-sm">No hay categorías</li>
              @endforelse
            </ul>
          </div>

          {{-- Recent Posts --}}
          <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h3 class="font-display text-2xl font-bold text-amber-900 mb-6">Posts Recientes</h3>
            <div class="space-y-6">
              @forelse($recentPosts ?? [] as $post)
              <div>
                <a href="{{ route('blog.show', $post) }}" class="font-medium text-gray-900 hover:text-amber-700 transition-colors line-clamp-2 mb-2 block">
                  {{ $post->title }}
                </a>
                <p class="text-sm text-gray-500">{{ $post->created_at->format('d M, Y') }}</p>
              </div>
              @empty
              <p class="text-gray-500 text-sm">No hay posts recientes</p>
              @endforelse
            </div>
          </div>
        </aside>
      </div>
    </div>
  </main>

  @php
  $footerConfig = $customization['footer'] ?? [];
  @endphp
  @include('templates.restaurante-menu.footer')
</body>
</html>
