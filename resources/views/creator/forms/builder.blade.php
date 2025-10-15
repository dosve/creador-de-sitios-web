@extends('layouts.creator')

@section('title', 'Constructor de Formularios')

@section('content')
<div class="py-6" x-data="formBuilder()">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('creator.forms.index') }}" class="text-gray-400 hover:text-gray-500">
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
                <a href="{{ route('creator.forms.index') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Builder Interface -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-4">
            <!-- Sidebar - Field Types -->
            <div class="lg:col-span-1">
                <div class="p-6 bg-white rounded-lg shadow">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Elementos</h3>
                    
                    <div class="space-y-3">
                        <x-form-builder.field-type 
                            type="text" 
                            icon="M4 6h16M4 12h16M4 18h7" 
                            label="Campo de Texto" />
                        
                        <x-form-builder.field-type 
                            type="email" 
                            icon="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" 
                            label="Email" />
                        
                        <x-form-builder.field-type 
                            type="tel" 
                            icon="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" 
                            label="Teléfono" />
                        
                        <x-form-builder.field-type 
                            type="number" 
                            icon="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" 
                            label="Número" />
                        
                        <x-form-builder.field-type 
                            type="textarea" 
                            icon="M4 6h16M4 12h16M4 18h7" 
                            label="Área de Texto" />
                        
                        <x-form-builder.field-type 
                            type="select" 
                            icon="M8 9l4-4 4 4m0 6l-4 4-4-4" 
                            label="Lista Desplegable" />
                        
                        <x-form-builder.field-type 
                            type="checkbox" 
                            icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" 
                            label="Casilla de Verificación" />
                        
                        <x-form-builder.field-type 
                            type="radio" 
                            icon="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" 
                            label="Botones de Opción" />
                        
                        <x-form-builder.field-type 
                            type="date" 
                            icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" 
                            label="Fecha" />
                        
                        <x-form-builder.field-type 
                            type="file" 
                            icon="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" 
                            label="Archivo" />
                    </div>
                </div>
            </div>

            <!-- Main Area - Form Builder -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow">
                    <!-- Form Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                        <h3 class="text-lg font-medium text-gray-900">Diseñador de Formulario</h3>
                        <p class="mt-1 text-sm text-gray-500">Arrastra elementos desde la izquierda para construir tu formulario</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span x-text="fields.length"></span> campos
                            </div>
                        </div>
                    </div>

                    <!-- Form Canvas -->
                    <div class="p-6">
                        <div id="form-canvas" 
                             class="p-4 border-2 border-gray-300 border-dashed rounded-lg min-h-96"
                             @dragover.prevent="dragOver"
                             @dragleave.prevent="dragLeave"
                             @drop.prevent="drop">
                            
                            <template x-if="fields.length === 0">
                                <x-form-builder.empty-state />
                            </template>

                            <div id="fields-container" class="space-y-0">
                                @foreach($form->fields as $field)
                                    <x-form-builder.field-preview :field="$field" />
                                @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de edición -->
<x-form-builder.field-editor-modal />

@push('scripts')
<script>
// Variables globales
const FORM_ID = {{ $form->id }};
const CSRF_TOKEN = '{{ csrf_token() }}';
let currentEditingField = null;

function formBuilder() {
    return {
        fields: @json($form->fields),
        
        dragOver(e) {
            const canvas = document.getElementById('form-canvas');
            canvas.classList.add('border-green-400', 'bg-green-50');
        },
        
        dragLeave(e) {
            const canvas = document.getElementById('form-canvas');
            canvas.classList.remove('border-green-400', 'bg-green-50');
        },
        
        drop(e) {
            const canvas = document.getElementById('form-canvas');
            canvas.classList.remove('border-green-400', 'bg-green-50');
            
            const fieldType = e.dataTransfer.getData('text/plain');
            if (fieldType) {
                addFieldToForm(fieldType);
            }
        }
    }
}

// Hacer draggable los elementos
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[draggable="true"][data-field-type]').forEach(element => {
        element.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.fieldType);
            e.target.classList.add('opacity-50');
        });
        
        element.addEventListener('dragend', function(e) {
            e.target.classList.remove('opacity-50');
        });
    });
});

// Agregar campo al formulario
async function addFieldToForm(type) {
    try {
        const response = await fetch(`/creator/forms/${FORM_ID}/fields`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ type })
        });

        const data = await response.json();

        if (data.success) {
            // Recargar la página para mostrar el nuevo campo
            window.location.reload();
        } else {
            alert('Error al agregar el campo');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al agregar el campo');
    }
}

// Editar campo
function editField(fieldId) {
    const field = {{ Js::from($form->fields) }}.find(f => f.id === fieldId);
    if (!field) return;

    currentEditingField = fieldId;
    
    // Rellenar el formulario
    document.getElementById('field-label').value = field.label || '';
    document.getElementById('field-name').value = field.name || '';
    document.getElementById('field-placeholder').value = field.placeholder || '';
    document.getElementById('field-required').checked = field.required || false;
    document.getElementById('field-validation').value = field.validation_rules || '';

    // Mostrar/ocultar opciones según el tipo
    const optionsContainer = document.getElementById('field-options-container');
    if (['select', 'radio', 'checkbox'].includes(field.type)) {
        optionsContainer.classList.remove('hidden');
        loadOptions(field.options || []);
    } else {
        optionsContainer.classList.add('hidden');
    }

    // Mostrar modal
    document.getElementById('field-editor-modal').classList.remove('hidden');
}

// Cerrar editor
function closeFieldEditor() {
    document.getElementById('field-editor-modal').classList.add('hidden');
    currentEditingField = null;
}

// Cargar opciones
function loadOptions(options) {
    const container = document.getElementById('options-list');
    container.innerHTML = '';
    
    if (Array.isArray(options) && options.length > 0) {
        options.forEach((option, index) => {
            addOptionToList(typeof option === 'string' ? option : (option.label || option.value), index);
        });
    } else {
        addOptionToList('Opción 1', 0);
        addOptionToList('Opción 2', 1);
    }
}

// Agregar opción a la lista
function addOptionToList(value = '', index = null) {
    const container = document.getElementById('options-list');
    const optionIndex = index !== null ? index : container.children.length;
    
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <input type="text" 
               value="${value}" 
               class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
               placeholder="Opción ${optionIndex + 1}">
        <button type="button" 
                onclick="this.parentElement.remove()"
                class="p-2 text-red-600 hover:text-red-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    container.appendChild(div);
}

// Agregar nueva opción
function addOption() {
    addOptionToList();
}

// Guardar cambios del campo
async function saveFieldChanges() {
    if (!currentEditingField) return;

    const formData = {
        label: document.getElementById('field-label').value,
        name: document.getElementById('field-name').value,
        placeholder: document.getElementById('field-placeholder').value,
        required: document.getElementById('field-required').checked,
        validation_rules: document.getElementById('field-validation').value,
    };

    // Recoger opciones si aplica
    const optionsContainer = document.getElementById('field-options-container');
    if (!optionsContainer.classList.contains('hidden')) {
        const optionInputs = document.querySelectorAll('#options-list input');
        formData.options = Array.from(optionInputs).map(input => input.value).filter(v => v);
    }

    try {
        const response = await fetch(`/creator/forms/${FORM_ID}/fields/${currentEditingField}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            closeFieldEditor();
            window.location.reload();
        } else {
            alert('Error al guardar los cambios');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    }
}

// Eliminar campo
async function deleteField(fieldId) {
    if (!confirm('¿Estás seguro de que deseas eliminar este campo?')) {
        return;
    }

    try {
        const response = await fetch(`/creator/forms/${FORM_ID}/fields/${fieldId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });

        const data = await response.json();

        if (data.success) {
            window.location.reload();
        } else {
            alert('Error al eliminar el campo');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al eliminar el campo');
    }
}
</script>
@endpush
@endsection
