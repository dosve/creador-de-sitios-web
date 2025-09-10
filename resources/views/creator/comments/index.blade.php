@extends('layouts.creator')

@section('title', 'Comentarios')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Comentarios
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Gestiona los comentarios de tu sitio web y blog.
                </p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form method="GET" action="{{ route('creator.comments.index', $website) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                        <option value="">Todos los estados</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobados</option>
                        <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option>
                    </select>
                </div>
                
                <div>
                    <label for="blog_post_id" class="block text-sm font-medium text-gray-700">Post del Blog</label>
                    <select name="blog_post_id" id="blog_post_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                        <option value="">Todos los posts</option>
                        @foreach($blogPosts as $post)
                            <option value="{{ $post->id }}" {{ request('blog_post_id') == $post->id ? 'selected' : '' }}>
                                {{ $post->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Comentarios -->
        <div class="mt-8">
            @if($comments->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($comments as $comment)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $comment->author_name }}
                                                    </p>
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                        {{ $comment->status_label }}
                                                    </span>
                                                </div>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">
                                                        {{ $comment->author_email }}
                                                        @if($comment->author_website)
                                                            • <a href="{{ $comment->author_website }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ $comment->author_website }}</a>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-500">
                                                {{ $comment->created_at->format('d/m/Y H:i') }}
                                            </span>
                                            <a href="{{ route('creator.comments.show', [$website, $comment]) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Ver
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Contenido del comentario -->
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-700">{{ Str::limit($comment->content, 200) }}</p>
                                    </div>
                                    
                                    <!-- Información del post -->
                                    @if($comment->blogPost)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500">
                                                En: <a href="#" class="text-blue-600 hover:text-blue-800">{{ $comment->blogPost->title }}</a>
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <!-- Acciones -->
                                    <div class="mt-4 flex space-x-2">
                                        @if($comment->status === 'pending')
                                            <form method="POST" action="{{ route('creator.comments.approve', [$website, $comment]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Aprobar
                                                </button>
                                            </form>
                                        @elseif($comment->status === 'approved')
                                            <form method="POST" action="{{ route('creator.comments.unapprove', [$website, $comment]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                    Desaprobar
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($comment->status !== 'spam')
                                            <form method="POST" action="{{ route('creator.comments.mark-spam', [$website, $comment]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Marcar como Spam
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('creator.comments.mark-not-spam', [$website, $comment]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    No es Spam
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('creator.comments.destroy', [$website, $comment]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este comentario?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay comentarios</h3>
                    <p class="mt-1 text-sm text-gray-500">Aún no se han recibido comentarios en tu sitio web.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
