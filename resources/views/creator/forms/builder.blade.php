@extends('layouts.creator')

@section('title', 'Constructor de Formularios')

@section('content')
<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('creator.forms.index', $website) }}" class="text-gray-400 hover:text-gray-500">
                                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    <span class="sr-only">Formularios</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">Constructor</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Constructor: {{ $form->name }}
                </h2>
            </div>
            <div class="flex mt-4 md:mt-0 md:ml-4">
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Vista Previa
                </button>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Cambios
                </button>
            </div>
        </div>

        <!-- Builder Interface -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-3">
            <!-- Sidebar - Field Types -->
            <div class="lg:col-span-1">
                <div class="p-6 bg-white rounded-lg shadow">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Elementos del Formulario</h3>
                    
                    <div class="space-y-3">
                        <!-- Text Input -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="text">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Campo de Texto</span>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="email">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Email</span>
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="textarea">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Área de Texto</span>
                            </div>
                        </div>

                        <!-- Select -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="select">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Lista Desplegable</span>
                            </div>
                        </div>

                        <!-- Checkbox -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="checkbox">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Casilla de Verificación</span>
                            </div>
                        </div>

                        <!-- Radio -->
                        <div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50" draggable="true" data-field-type="radio">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Botones de Opción</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Area - Form Builder -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <!-- Form Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Diseñador de Formulario</h3>
                        <p class="mt-1 text-sm text-gray-500">Arrastra elementos desde la izquierda para construir tu formulario</p>
                    </div>

                    <!-- Form Canvas -->
                    <div class="p-6">
                        <div id="form-canvas" class="p-4 border-2 border-gray-300 border-dashed rounded-lg min-h-96">
                            @if($form->fields->count() > 0)
                                @foreach($form->fields as $field)
                                    <div class="p-4 mb-4 border border-gray-200 rounded-lg form-field bg-gray-50" data-field-id="{{ $field->id }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">{{ $field->label ?: $field->name }}</span>
                                            <div class="flex space-x-2">
                                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button type="button" class="text-red-400 hover:text-red-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        @if($field->type === 'text' || $field->type === 'email')
                                            <input type="{{ $field->type }}" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                                   placeholder="{{ $field->placeholder ?: 'Ingresa tu ' . strtolower($field->label) }}"
                                                   disabled>
                                        @elseif($field->type === 'textarea')
                                            <textarea rows="3" 
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                                      placeholder="{{ $field->placeholder ?: 'Ingresa tu ' . strtolower($field->label) }}"
                                                      disabled></textarea>
                                        @elseif($field->type === 'select')
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" disabled>
                                                <option>Selecciona una opción</option>
                                            </select>
                                        @elseif($field->type === 'checkbox')
                                            <div class="flex items-center">
                                                <input type="checkbox" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" disabled>
                                                <label class="ml-2 text-sm text-gray-700">{{ $field->label ?: 'Opción' }}</label>
                                            </div>
                                        @elseif($field->type === 'radio')
                                            <div class="space-y-2">
                                                <div class="flex items-center">
                                                    <input type="radio" name="radio_{{ $field->id }}" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" disabled>
                                                    <label class="ml-2 text-sm text-gray-700">Opción 1</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="radio" name="radio_{{ $field->id }}" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" disabled>
                                                    <label class="ml-2 text-sm text-gray-700">Opción 2</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Formulario vacío</h3>
                                    <p class="mt-1 text-sm text-gray-500">Arrastra elementos desde la izquierda para comenzar</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Drag and Drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const formCanvas = document.getElementById('form-canvas');
    
    // Make draggable elements
    document.querySelectorAll('[draggable="true"]').forEach(element => {
        element.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.fieldType);
        });
    });
    
    // Handle drop
    formCanvas.addEventListener('dragover', function(e) {
        e.preventDefault();
        formCanvas.classList.add('border-green-400', 'bg-green-50');
    });
    
    formCanvas.addEventListener('dragleave', function(e) {
        e.preventDefault();
        formCanvas.classList.remove('border-green-400', 'bg-green-50');
    });
    
    formCanvas.addEventListener('drop', function(e) {
        e.preventDefault();
        formCanvas.classList.remove('border-green-400', 'bg-green-50');
        
        const fieldType = e.dataTransfer.getData('text/plain');
        addFieldToForm(fieldType);
    });
    
    function addFieldToForm(type) {
        // This would typically make an AJAX call to add the field
        console.log('Adding field type:', type);
        // For now, just show a placeholder
        alert('Funcionalidad de agregar campos en desarrollo');
    }
});
</script>
@endpush
@endsection
