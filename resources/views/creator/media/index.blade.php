@extends('layouts.creator')

@section('title', 'Multimedia - ' . $website->name)
@section('page-title', 'Biblioteca Multimedia')
@section('content')
            <!-- Media Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Biblioteca Multimedia de {{ $website->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Gestiona las imágenes y archivos de tu sitio web</p>
                        </div>
                        <button onclick="openUploadModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Subir Archivos
                        </button>
                    </div>
                </div>
            </div>

            <!-- Media Files Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($mediaFiles as $file)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                    <!-- File Preview -->
                    <div class="aspect-square bg-gray-100 rounded-lg mb-3 overflow-hidden">
                        @if(str_starts_with($file->mime_type, 'image/'))
                            <img src="{{ Storage::disk('public')->url($file->file_path) }}" 
                                 alt="{{ $file->alt_text }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- File Info -->
                    <div class="text-xs text-gray-600 mb-2">
                        <p class="font-medium truncate" title="{{ $file->filename }}">{{ $file->filename }}</p>
                        <p>{{ number_format($file->file_size / 1024, 1) }} KB</p>
                    </div>

                    <!-- File Actions -->
                    <div class="flex space-x-1">
                        <button onclick="copyUrl('{{ Storage::disk('public')->url($file->file_path) }}')" 
                                class="flex-1 bg-gray-100 text-gray-700 text-center py-1 px-2 rounded text-xs hover:bg-gray-200">
                            URL
                        </button>
                        <form method="POST" action="{{ route('creator.media.destroy', [$website, $file]) }}" class="flex-1" onsubmit="return confirm('¿Eliminar archivo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 text-red-700 py-1 px-2 rounded text-xs hover:bg-red-200">
                                ×
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($mediaFiles->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay archivos multimedia</h3>
                <p class="text-gray-500 mb-8">Sube imágenes y archivos para usar en tu sitio web.</p>
                <button onclick="openUploadModal()" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                    Subir Archivos
                </button>
            </div>
            @endif

            <!-- Upload Modal -->
            <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subir Archivos</h3>
                        
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <input type="file" name="files[]" id="files" multiple accept="image/*,.pdf,.doc,.docx" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="closeUploadModal()" 
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                    Cancelar
                                </button>
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
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
                }

                function copyUrl(url) {
                    navigator.clipboard.writeText(url).then(function() {
                        alert('URL copiada al portapapeles');
                    });
                }

                // Handle form submission
                document.getElementById('uploadForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch('{{ route("creator.media.store", $website) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
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
@endsection