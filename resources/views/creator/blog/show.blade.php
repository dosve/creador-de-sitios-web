<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blogPost->title }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.blog.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $blogPost->title }}</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.blog.edit', [$website, $blogPost]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Post Header -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blogPost->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $blogPost->is_published ? 'Publicado' : 'Borrador' }}
                            </span>
                            @if($blogPost->category)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium" style="background-color: {{ $blogPost->category->color }}20; color: {{ $blogPost->category->color }};">
                                    {{ $blogPost->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $blogPost->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $blogPost->title }}</h1>
                    
                    @if($blogPost->excerpt)
                        <p class="text-lg text-gray-600 mb-4">{{ $blogPost->excerpt }}</p>
                    @endif
                    
                    @if($blogPost->tags->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($blogPost->tags as $tag)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Featured Image -->
                @if($blogPost->featured_image)
                    <div class="px-6 py-4">
                        {!! render_image_container(
                            $blogPost->featured_image, 
                            $blogPost->title, 
                            'w-full h-64 rounded-lg', 
                            'w-full h-64 object-cover rounded-lg'
                        ) !!}
                    </div>
                @endif

                <!-- Post Content -->
                <div class="px-6 py-8">
                    <div class="prose max-w-none prose-lg">
                        {!! $blogPost->content !!}
                    </div>
                </div>

                <!-- Post Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Creado: {{ $blogPost->created_at->format('d/m/Y H:i') }}</span>
                            @if($blogPost->updated_at != $blogPost->created_at)
                                <span class="ml-4">Actualizado: {{ $blogPost->updated_at->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('creator.blog.edit', [$website, $blogPost]) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('creator.blog.destroy', [$website, $blogPost]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este artículo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
