<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ $website->name ?? 'Consultoría' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }

    .font-heading {
      font-family: 'Merriweather', serif;
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
<body class="bg-slate-50">
  @php $headerConfig = $customization['header'] ?? []; @endphp
  @include('templates.consultoria-corporativa.header')
  <section class="bg-blue-900 text-white py-20">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl font-bold mb-4">Insights Corporativos</h1>
      <p class="text-xl text-blue-100">Artículos y análisis del mundo empresarial</p>
    </div>
  </section>
  <main class="py-16">
    <div class="container px-6 mx-auto">
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts ?? [] as $post)
        <article class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
          @if($post->featured_image)
          <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
          @else
          <div class="h-48 bg-slate-200 flex items-center justify-center">
            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          @endif
          <div class="p-6">
            <div class="text-sm text-slate-500 mb-3">{{ $post->created_at->format('d M, Y') }}</div>
            <h2 class="font-heading text-xl font-bold mb-3 hover:text-blue-900 transition-colors">
              <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <p class="text-slate-600 mb-4">{{ Str::limit($post->excerpt, 120) }}</p>
            <a href="{{ route('blog.show', $post) }}" class="text-blue-900 hover:text-blue-700 font-semibold text-sm">Leer más →</a>
          </div>
        </article>
        @empty
        <div class="col-span-3 py-24 text-center">
          <h3 class="font-heading text-2xl font-bold mb-2">No hay publicaciones</h3>
          <p class="text-slate-600">Próximamente nuevos artículos.</p>
        </div>
        @endforelse
      </div>
    </div>
  </main>
  @php $footerConfig = $customization['footer'] ?? []; @endphp
  @include('templates.consultoria-corporativa.footer')
</body>
</html>
