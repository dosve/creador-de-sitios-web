@extends('layouts.creator')

@section('title', 'Editar Sitio Web - ' . $website->name)
@section('page-title', 'Editar Sitio Web')
@section('content')
            @if(session('success'))
                <div class="max-w-2xl mx-auto mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            <!-- Edit Website Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Editar {{ $website->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">Modifica la información de tu sitio web.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.config.general.update') }}" class="px-6 py-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Logo del Sitio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo del Sitio</label>
                                <p class="text-xs text-gray-500 mb-2">Se muestra en la barra de navegación del sitio (nombre o imagen).</p>
                                @if(!empty($website->logo))
                                <div class="flex items-center gap-4 mb-3">
                                    <img src="{{ asset('storage/' . $website->logo) }}" alt="Logo actual" class="h-14 border border-gray-200 rounded-lg p-2 bg-white object-contain">
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="remove_logo" value="1" class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                        <span class="text-sm text-gray-700">Eliminar logo</span>
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500 mb-2">Subir otro archivo para reemplazar:</p>
                                @else
                                <p class="text-sm text-gray-500 mb-2">Subir logo (opcional):</p>
                                @endif
                                <input type="file" name="logo" id="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG o SVG. Máx. 2 MB. Recomendado: fondo transparente.</p>
                                @error('logo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Sitio Web</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $website->name) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror" 
                                           placeholder="Mi Sitio Web" required>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror" 
                                              placeholder="Describe brevemente tu sitio web...">{{ old('description', $website->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">URL (Slug)</label>
                                <div class="mt-1">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $website->slug) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror" 
                                           placeholder="mi-sitio-web" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/<span id="slug-preview">{{ $website->slug }}</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Template Selection -->
                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Plantilla</label>
                                <div class="mt-1">
                                    <select name="template_id" id="template_id" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('template_id') border-red-300 @enderror">
                                        <option value="">Sin plantilla</option>
                                        @foreach(\App\Models\Template::active()->get() as $template)
                                            <option value="{{ $template->id }}" {{ old('template_id', $website->template_id) == $template->id ? 'selected' : '' }}>
                                                {{ $template->name }} - {{ $template->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('template_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $website->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Sitio web publicado
                                </label>
                            </div>

                            <!-- Información para el footer (solo vista previa) -->
                            <div class="pt-6 mt-6 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 mb-1">Información para el footer</h4>
                                <p class="text-xs text-gray-500 mb-4">Solo se muestra en vista previa. Email, teléfono y dirección que aparecerán en el footer.</p>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
                                    <div>
                                        <label for="footer_contact_email" class="block text-sm font-medium text-gray-700">Email de contacto</label>
                                        <input type="email" name="footer_contact_email" id="footer_contact_email"
                                               value="{{ old('footer_contact_email', $website->settings['contact_email'] ?? '') }}"
                                               class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                               placeholder="contacto@tusitio.com">
                                    </div>
                                    <div>
                                        <label for="footer_contact_phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                        <input type="text" name="footer_contact_phone" id="footer_contact_phone"
                                               value="{{ old('footer_contact_phone', $website->settings['contact_phone'] ?? '') }}"
                                               class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                               placeholder="+57 300 123 4567">
                                    </div>
                                    <div>
                                        <label for="footer_contact_address" class="block text-sm font-medium text-gray-700">Dirección</label>
                                        <input type="text" name="footer_contact_address" id="footer_contact_address"
                                               value="{{ old('footer_contact_address', $website->settings['contact_address'] ?? '') }}"
                                               class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                               placeholder="Calle 123, Ciudad">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('creator.dashboard') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Sitio Web
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Update slug preview
                document.getElementById('slug').addEventListener('input', function() {
                    document.getElementById('slug-preview').textContent = this.value;
                });
            </script>
@endsection
