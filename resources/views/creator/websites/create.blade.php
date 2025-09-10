@extends('layouts.creator')

@section('title', 'Crear Sitio Web')
@section('page-title', 'Crear Sitio Web')
@section('content')
            <!-- Create Website Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Crear Nuevo Sitio Web</h3>
                        <p class="mt-1 text-sm text-gray-600">Completa la información básica para tu nuevo sitio web.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.websites.store') }}" class="px-6 py-4">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Website Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Sitio Web</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
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
                                              placeholder="Describe brevemente tu sitio web...">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Template Selection -->
                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Plantilla</label>
                                <div class="mt-1">
                                    <select name="template_id" id="template_id" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('template_id') border-red-300 @enderror">
                                        <option value="">Seleccionar plantilla (opcional)</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                                {{ $template->name }} - {{ $template->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Si no seleccionas una plantilla, se asignará una por defecto.</p>
                                @error('template_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
                                Crear Sitio Web
                            </button>
                        </div>
                    </form>
                </div>
            </div>
@endsection