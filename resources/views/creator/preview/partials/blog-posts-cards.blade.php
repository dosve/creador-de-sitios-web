{{-- Bloque completo de blog con artículos (server-side). Reemplaza la sección data-dynamic-blog en la vista. --}}
<section class="py-16 bg-gray-50 blog-list" data-dynamic-blog="true">
  <div class="container px-4 mx-auto">
    <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Últimos Artículos</h2>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="blog-posts-container" data-website-id="{{ $website->id }}">
@if($blogPosts->isEmpty())
      <div class="col-span-full text-center py-12">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No hay artículos disponibles</h3>
        <p class="text-gray-500">Aún no se han publicado artículos en este blog.</p>
      </div>
@else
@foreach($blogPosts as $post)
@php
    $excerpt = $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 150);
    $readTime = (int) max(1, ceil(str_word_count(strip_tags($post->content ?? '')) / 200));
    $date = $post->published_at ?? $post->created_at;
    $publishDate = $date ? $date->locale('es')->translatedFormat('d F Y') : 'Sin fecha';
    $postUrl = url('/' . $website->slug . '/blog/' . $post->slug);
@endphp
      <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
        <div class="w-full h-48 relative overflow-hidden">
          @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
          @else
            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
              @if($post->category)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $post->category->name }}</span>
              @endif
            </div>
          @endif
          @if($post->featured_image && $post->category)
            <div class="absolute top-4 left-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $post->category->name }}</span>
            </div>
          @endif
        </div>
        <div class="p-6">
          <div class="flex items-center text-sm text-gray-500 mb-2">
            <span>{{ $publishDate }}</span>
            <span class="mx-2">•</span>
            <span>{{ $readTime }} min lectura</span>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">
            <a href="{{ $postUrl }}">{{ $post->title }}</a>
          </h3>
          <p class="text-gray-600 mb-4">{{ $excerpt }}</p>
          @if($post->relationLoaded('tags') && $post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1 mt-2">
              @foreach($post->tags->take(3) as $tag)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">{{ $tag->name }}</span>
              @endforeach
            </div>
          @endif
          <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
              <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
              <span class="text-sm text-gray-600">Autor</span>
            </div>
            <a href="{{ $postUrl }}" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
          </div>
        </div>
      </article>
@endforeach
@endif
    </div>
  </div>
</section>
