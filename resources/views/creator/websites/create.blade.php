@extends('layouts.creator')

@section('title', 'Crear Sitio Web')
@section('page-title', 'Crear Sitio Web')
@section('content')
            <!-- Create Website Form -->
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Crear Nuevo Sitio Web</h2>
                    <p class="mt-2 text-lg text-gray-600">¿Cómo quieres empezar tu sitio web?</p>
                    </div>
                    
                <form method="POST" action="{{ route('creator.websites.store') }}" id="createWebsiteForm">
                        @csrf
                        
                    <!-- Website Basic Info -->
                    <div class="mb-8 bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Básica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        </div>
                            </div>

                            <!-- Template Selection -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6 text-center">Elige cómo quieres empezar</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Blank Page Option -->
                            <div class="template-option" data-template="blank">
                                <div class="relative bg-white border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition-colors">
                                    <div class="text-center">
                                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                                            <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Página en Blanco</h4>
                                        <p class="text-gray-600 mb-4">Empieza desde cero con total libertad creativa. Ideal para diseños únicos y personalizados.</p>
                                        <div class="text-sm text-gray-500">
                                            <ul class="space-y-1">
                                                <li>• Editor visual completo</li>
                                                <li>• Diseño personalizado</li>
                                                <li>• Máxima flexibilidad</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="radio" name="template_type" value="blank" class="sr-only" id="template_blank">
                                </div>
                            </div>

                            <!-- Template Option -->
                            <div class="template-option" data-template="template">
                                <div class="relative bg-white border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition-colors">
                                    <div class="text-center">
                                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Usar Plantilla</h4>
                                        <p class="text-gray-600 mb-4">Elige una plantilla predefinida y personalízala según tus necesidades.</p>
                                        <div class="text-sm text-gray-500">
                                            <ul class="space-y-1">
                                                <li>• Diseños profesionales</li>
                                                <li>• Fácil personalización</li>
                                                <li>• Ahorro de tiempo</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="radio" name="template_type" value="template" class="sr-only" id="template_template">
                                </div>
                            </div>
                        </div>

                        <!-- Template Selection (Hidden by default) -->
                        <div id="templateSelection" class="mt-6 hidden">
                            <div class="bg-white border rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Selecciona una Plantilla</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($templates as $template)
                                        <div class="template-item border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors">
                                            <div class="text-center">
                                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-3">
                                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                    </svg>
                                                </div>
                                                <h5 class="font-medium text-gray-900">{{ $template['name'] }}</h5>
                                                <p class="text-sm text-gray-500">{{ $template['category'] }}</p>
                                            </div>
                                            <input type="radio" name="template_slug" value="{{ $template['slug'] }}" class="sr-only template-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                    <div class="flex items-center justify-center space-x-4">
                            <a href="{{ route('creator.dashboard') }}" 
                           class="bg-white py-3 px-6 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Crear Sitio Web
                            </button>
                        </div>
                    </form>
                </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const templateOptions = document.querySelectorAll('.template-option');
                    const templateSelection = document.getElementById('templateSelection');
                    const templateItems = document.querySelectorAll('.template-item');
                    
                    templateOptions.forEach(option => {
                        option.addEventListener('click', function() {
                            // Remove active class from all options
                            templateOptions.forEach(opt => {
                                opt.querySelector('.border-2').classList.remove('border-blue-500', 'bg-blue-50');
                                opt.querySelector('.border-2').classList.add('border-gray-200');
                            });
                            
                            // Add active class to clicked option
                            this.querySelector('.border-2').classList.remove('border-gray-200');
                            this.querySelector('.border-2').classList.add('border-blue-500', 'bg-blue-50');
                            
                            // Check the radio button
                            this.querySelector('input[type="radio"]').checked = true;
                            
                            // Show/hide template selection
                            if (this.dataset.template === 'template') {
                                templateSelection.classList.remove('hidden');
                            } else {
                                templateSelection.classList.add('hidden');
                                // Clear template selection
                                document.querySelectorAll('input[name="template_slug"]').forEach(radio => {
                                    radio.checked = false;
                                });
                                templateItems.forEach(item => {
                                    item.classList.remove('border-blue-500', 'bg-blue-50');
                                    item.classList.add('border-gray-200');
                                });
                            }
                        });
                    });
                    
                    // Template item selection
                    templateItems.forEach(item => {
                        item.addEventListener('click', function() {
                            // Remove active class from all template items
                            templateItems.forEach(templateItem => {
                                templateItem.classList.remove('border-blue-500', 'bg-blue-50');
                                templateItem.classList.add('border-gray-200');
                            });
                            
                            // Add active class to clicked item
                            this.classList.remove('border-gray-200');
                            this.classList.add('border-blue-500', 'bg-blue-50');
                            
                            // Check the radio button
                            this.querySelector('.template-radio').checked = true;
                        });
                    });
                });
            </script>
@endsection