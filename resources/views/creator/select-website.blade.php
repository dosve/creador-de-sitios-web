@extends('layouts.creator-simple')

@section('title', 'Seleccionar Sitio Web')
@section('page-title', 'Seleccionar Sitio Web')
@section('content')
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                    <p class="text-lg text-gray-600">Selecciona el sitio web con el que quieres trabajar en esta sesión</p>
                </div>

                <!-- Websites Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($websites as $website)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" 
                         onclick="selectWebsite({{ $website->id }})">
                        <!-- Website Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $website->name }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $website->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $website->is_published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Delete Button -->
                                <button type="button" 
                                        onclick="event.stopPropagation(); deleteWebsite({{ $website->id }}, '{{ $website->name }}')"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
                                        title="Eliminar sitio web">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Website Description -->
                        @if($website->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $website->description }}</p>
                        @endif

                        <!-- Website Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $website->pages->count() }} páginas
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    {{ $website->blogPosts->count() }} posts
                                </span>
                            </div>
                            <span>{{ $website->created_at->format('d/m/Y') }}</span>
                        </div>

                        <!-- Select Button -->
                        <div class="mt-4">
                            <button type="button" class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 text-sm font-medium">
                                Seleccionar este sitio
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Create New Website Option -->
                @if(auth()->user()->isAdmin() || $websites->count() == 0)
                <div class="text-center">
                    <div class="bg-white border-2 border-dashed border-gray-300 rounded-lg p-8 hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 cursor-pointer" 
                         onclick="createNewWebsite()">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Crear Nuevo Sitio Web</h3>
                        <p class="text-sm text-gray-500">Comienza un nuevo proyecto web</p>
                    </div>
                </div>
                @else
                <!-- Message for non-admin users who already have a website -->
                <div class="text-center">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-yellow-800 mb-2">Límite de sitios web alcanzado</h3>
                        <p class="text-sm text-yellow-700">Solo puedes crear un sitio web. Contacta al administrador si necesitas crear más sitios.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Hidden Form for Website Selection -->
            <form id="selectWebsiteForm" method="POST" action="{{ route('creator.select-website') }}" style="display: none;">
                @csrf
                <input type="hidden" name="website_id" id="selectedWebsiteId">
            </form>

            <!-- Hidden Form for Website Deletion -->
            <form id="deleteWebsiteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="website_id" id="websiteToDelete">
            </form>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">¿Eliminar sitio web?</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que quieres eliminar el sitio web "<span id="websiteNameToDelete" class="font-medium text-gray-900"></span>"?
                                Esta acción no se puede deshacer y se eliminarán todas las páginas, posts y contenido asociado.
                            </p>
                        </div>
                        <div class="flex items-center justify-center space-x-3 mt-4">
                            <button type="button" onclick="closeDeleteModal()" 
                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </button>
                            <button type="button" onclick="confirmDeleteWebsite()" 
                                    class="bg-red-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let websiteToDelete = null;

                function selectWebsite(websiteId) {
                    document.getElementById('selectedWebsiteId').value = websiteId;
                    document.getElementById('selectWebsiteForm').submit();
                }

                function createNewWebsite() {
                    window.location.href = "{{ route('creator.websites.create') }}";
                }

                function deleteWebsite(websiteId, websiteName) {
                    websiteToDelete = websiteId;
                    document.getElementById('websiteNameToDelete').textContent = websiteName;
                    document.getElementById('deleteModal').classList.remove('hidden');
                }

                function closeDeleteModal() {
                    document.getElementById('deleteModal').classList.add('hidden');
                    websiteToDelete = null;
                }

                function confirmDeleteWebsite() {
                    if (websiteToDelete) {
                        document.getElementById('websiteToDelete').value = websiteToDelete;
                        document.getElementById('deleteWebsiteForm').action = "{{ route('creator.websites.destroy', 'WEBSITE_ID') }}".replace('WEBSITE_ID', websiteToDelete);
                        document.getElementById('deleteWebsiteForm').submit();
                    }
                }

                // Close modal when clicking outside
                document.getElementById('deleteModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeDeleteModal();
                    }
                });
            </script>
@endsection
