<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $page->title ?? $website->name ?? 'Plantilla Demo' }}</title>
  <meta name="description" content="{{ $page->meta_description ?? $website->description ?? 'Plantilla Demo' }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-white demo-template" data-page-id="{{ $page?->id }}">
  @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->id === $website->user_id))
    <x-admin-bar :website="$website" />
  @endif

  @include('templates.plantilla-demo.header')

  <main class="min-h-screen">
    @if($page && $page->html_content)
      {!! $page->html_content !!}
    @else
      <section class="py-20">
        <div class="max-w-7xl mx-auto px-4">
          <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">{{ $page->title ?? 'Página' }}</h1>
          <p class="text-gray-600">{{ $page->meta_description ?? 'Contenido de la página' }}</p>
        </div>
      </section>
    @endif
  </main>

  @include('templates.plantilla-demo.footer')

  <x-global-scripts :website="$website" :customization="$customization ?? []" />
</body>
</html>


