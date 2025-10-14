@php
    $headerConfig = $customization['header'] ?? [];
@endphp
@include('templates.tienda-virtual.header')

<main class="min-h-screen py-16 bg-gray-50">
    <div class="container px-4 mx-auto">
        <article class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm p-8">
            <h1 class="mb-6 text-4xl font-bold text-gray-900">{{ $page->title ?? 'Título de la Página' }}</h1>
            
            <div class="prose prose-lg max-w-none">
                {!! $page->html_content ?? '<p>Contenido de la página aquí...</p>' !!}
            </div>
        </article>
    </div>
</main>

@php
    $footerConfig = $customization['footer'] ?? [];
@endphp
@include('templates.tienda-virtual.footer')

