<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Mi Tienda Virtual' }}</title>
  <meta name="description" content="{{ $website->description ?? '' }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
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
<body class="bg-gray-50">
  @php
  $headerConfig = $customization['header'] ?? [];
  @endphp
  @include('templates.tienda-virtual.header')

  <section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container px-4 mx-auto text-center">
      <h2 class="mb-4 text-4xl font-bold">Blog</h2>
      <p class="text-xl">Últimas noticias y artículos</p>
    </div>
  </section>

  <main class="py-16 bg-gray-50">
    <div class="container px-4 mx-auto">
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Lista de posts -->
        <div class="space-y-8 lg:col-span-2">
          @forelse($posts ?? [] as $post)
          <article class="overflow-hidden transition-shadow bg-white rounded-lg shadow-sm hover:shadow-md">
            @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="object-cover w-full h-48">
            @endif

            <div class="p-6">
              <div class="flex items-center mb-2 text-sm text-gray-500">
                <span>{{ $post->created_at->format('d M, Y') }}</span>
                @if($post->category)
                <span class="mx-2">•</span>
                <span class="text-blue-600">{{ $post->category->name }}</span>
                @endif
              </div>

              <h2 class="mb-3 text-2xl font-bold text-gray-900">
                <a href="{{ route('blog.show', $post) }}" class="hover:text-blue-600">
                  {{ $post->title }}
                </a>
              </h2>

              <p class="mb-4 text-gray-600">{{ Str::limit($post->excerpt, 150) }}</p>

              <a href="{{ route('blog.show', $post) }}" class="font-medium text-blue-600 hover:text-blue-700">
                Leer más →
              </a>
            </div>
          </article>
          @empty
          <div class="p-12 text-center bg-white rounded-lg shadow-sm">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mb-2 text-xl font-semibold text-gray-900">No hay publicaciones</h3>
            <p class="text-gray-600">Aún no se han publicado artículos en el blog.</p>
          </div>
          @endforelse
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
          <!-- Categorías -->
          <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-bold text-gray-900">Categorías</h3>
            <ul class="space-y-2">
              @forelse($categories ?? [] as $category)
              <li>
                <a href="#" class="flex items-center justify-between text-gray-600 hover:text-blue-600">
                  <span>{{ $category->name }}</span>
                  <span class="text-sm text-gray-400">({{ $category->posts_count }})</span>
                </a>
              </li>
              @empty
              <li class="text-sm text-gray-500">No hay categorías</li>
              @endforelse
            </ul>
          </div>

          <!-- Posts recientes -->
          <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-bold text-gray-900">Posts Recientes</h3>
            <div class="space-y-4">
              @forelse($recentPosts ?? [] as $post)
              <div>
                <a href="{{ route('blog.show', $post) }}" class="font-medium text-gray-900 hover:text-blue-600 line-clamp-2">
                  {{ $post->title }}
                </a>
                <p class="mt-1 text-sm text-gray-500">{{ $post->created_at->format('d M, Y') }}</p>
              </div>
              @empty
              <p class="text-sm text-gray-500">No hay posts recientes</p>
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
  @include('templates.tienda-virtual.footer')
</body>
</html>
