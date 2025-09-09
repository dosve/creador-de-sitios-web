@extends('layouts.creator')

@section('title', 'Biblioteca Multimedia - ' . $website->name)
@section('page-title', 'Biblioteca Multimedia - ' . $website->name)
@section('content')
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <span class="text-white text-lg">🖼️</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Imágenes</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['images'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                    <span class="text-white text-lg">📄</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Documentos</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['documents'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <span class="text-white text-lg">🎥</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Videos</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['videos'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <span class="text-white text-lg">🎵</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Audios</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['audios'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}"
                                   placeholder="Buscar archivos..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <select name="type" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="all" {{ $fileType === 'all' ? 'selected' : '' }}>Todos los tipos</option>
                                <option value="image" {{ $fileType === 'image' ? 'selected' : '' }}>Imágenes</option>
                                <option value="document" {{ $fileType === 'document' ? 'selected' : '' }}>Documentos</option>
                                <option value="video" {{ $fileType === 'video' ? 'selected' : '' }}>Videos</option>
                                <option value="audio" {{ $fileType === 'audio' ? 'selected' : '' }}>Audios</option>
                                <option value="other" {{ $fileType === 'other' ? 'selected' : '' }}>Otros</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Filtrar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Media Files Grid -->
            <div class="bg-white shadow rounded-lg">
                @if($mediaFiles->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($mediaFiles as $file)
                                <div class="relative group cursor-pointer" onclick="selectFile({{ $file->id }})">
                                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-transparent group-hover:border-blue-500 transition-colors">
                                        @if($file->isImage())
                                            <img src="{{ $file->file_url }}" 
                                                 alt="{{ $file->alt_text ?: $file->original_name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="text-4xl mb-2">{{ $file->getFileTypeIcon() }}</div>
                                                    <div class="text-xs text-gray-600 px-2">{{ $file->file_extension }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- File Info -->
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-900 truncate" title="{{ $file->original_name }}">
                                            {{ $file->original_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $file->file_size_formatted }}
                                        </p>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="flex space-x-1">
                                            <button onclick="event.stopPropagation(); copyUrl('{{ $file->file_url }}')" 
                                                    class="bg-white bg-opacity-90 p-1 rounded text-gray-600 hover:text-blue-600"
                                                    title="Copiar URL">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="event.stopPropagation(); editFile({{ $file->id }})" 
                                                    class="bg-white bg-opacity-90 p-1 rounded text-gray-600 hover:text-green-600"
                                                    title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="event.stopPropagation(); deleteFile({{ $file->id }})" 
                                                    class="bg-white bg-opacity-90 p-1 rounded text-gray-600 hover:text-red-600"
                                                    title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $mediaFiles->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay archivos</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza subiendo tu primer archivo.</p>
                        <div class="mt-6">
                            <button onclick="openUploadModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Subir Archivos
                            </button>
                        </div>
                    </div>
                @endif
            </div>
@endsection

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Subir Archivos</h3>
                </div>
                <form id="uploadForm" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="files" class="block text-sm font-medium text-gray-700 mb-2">
                            Seleccionar archivos
                        </label>
                        <input type="file" 
                               id="files" 
                               name="files[]" 
                               multiple 
                               accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Máximo 10MB por archivo</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Texto alternativo (opcional)
                        </label>
                        <input type="text" 
                               id="alt_text" 
                               name="alt_text" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Descripción para accesibilidad">
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (opcional)
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Descripción del archivo..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeUploadModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Subir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('uploadForm').reset();
        }

        function copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copiada al portapapeles');
            });
        }

        function selectFile(fileId) {
            // Implementar selección de archivo
            console.log('Selected file:', fileId);
        }

        function editFile(fileId) {
            // Implementar edición de archivo
            console.log('Edit file:', fileId);
        }

        function deleteFile(fileId) {
            if (confirm('¿Estás seguro de eliminar este archivo?')) {
                fetch(`{{ route('creator.media.destroy', [$website, '']) }}/${fileId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el archivo');
                    }
                });
            }
        }

        // Upload form handling
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const files = document.getElementById('files').files;
            
            if (files.length === 0) {
                alert('Por favor selecciona al menos un archivo');
                return;
            }
            
            // Add files to FormData
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }
            
            fetch('{{ route("creator.media.store", $website) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeUploadModal();
                    location.reload();
                } else {
                    alert('Error al subir archivos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al subir archivos');
            });
        });
    </script>
</body>
</html>
