<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? $website->name ?? 'Mi Sitio Web' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? $website->description ?? 'Descripción de mi sitio web' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @include('templates.partials.customization-vars')
</head>
<body class="bg-gray-50">
    {{-- Barra de administración para propietarios logueados --}}
    @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->id === $website->user_id))
        <x-admin-bar :website="$website" />
    @endif
    
    @include('templates.plantilla-basica.header')

    <main class="min-h-screen py-16">
        <div class="container px-4 mx-auto">
            <div class="text-center">
                @if($page && $page->html_content)
                    {!! $page->html_content !!}
                @else
                    <h2 class="mb-6 text-4xl font-bold text-gray-900">Bienvenido a tu sitio web</h2>
                    <p class="max-w-2xl mx-auto mb-8 text-lg text-gray-600">
                        Esta es tu página de inicio. Puedes editar este contenido desde el panel de administración.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="/{{ $website->slug }}/productos" class="px-6 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Ver Productos
                        </a>
                        <a href="/{{ $website->slug }}/contacto" class="px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Contactar
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('templates.plantilla-basica.footer')
</body>
</html>