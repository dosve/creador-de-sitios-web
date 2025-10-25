<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Evento Conferencia</title>
    <meta name="description" content="Artículos, noticias y actualizaciones sobre nuestro evento. Mantente informado sobre las últimas novedades.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .font-heading { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
@include('templates.evento-conferencia.header')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl font-heading">Noticias del Evento</h1>
                <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">Mantente informado sobre las últimas novedades.</p>
            </div>
        </div>
    </div>
    <!-- Blog Posts Grid -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-3 sm:grid-cols-2">
            @for ($i = 0; $i < 6; $i++)
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="https://via.placeholder.com/400x200?text=Blog+Post+{{ $i + 1 }}" alt="">
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-orange-600">
                                <a href="#" class="hover:underline">
                                    Categoría {{ $i % 3 == 0 ? 'Evento' : ($i % 3 == 1 ? 'Conferencia' : 'Actualización') }}
                                </a>
                            </p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900">
                                    Noticia del Evento {{ $i + 1 }}
                                </p>
                                <p class="mt-3 text-base text-gray-500">
                                    Breve descripción del contenido del artículo. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <a href="#">
                                    <span class="sr-only">Autor {{ $i + 1 }}</span>
                                    <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40x40?text=A{{ $i + 1 }}" alt="">
                                </a>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    <a href="#" class="hover:underline">
                                        Organizador {{ $i + 1 }}
                                    </a>
                                </p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="2023-03-16">Mar {{ 16 + $i }}, 2023</time>
                                    <span aria-hidden="true">&middot;</span>
                                    <span>{{ 5 + $i }} min de lectura</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-orange-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-orange-700 transition-colors">
                Cargar Más Artículos
            </button>
        </div>
    </div>
</div>
@include('templates.evento-conferencia.footer')
</body>
</html>
