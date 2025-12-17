{{--
    Componente para cargar formularios dinámicamente
    
    @param int $websiteId - ID del sitio web
--}}
@props(['websiteId' => ''])

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Función para renderizar un campo del formulario
    function renderFormField(field) {
        const fieldId = `field_${field.id}_${Date.now()}`;
        let fieldHtml = '';
        
        // Label
        if (field.label) {
            fieldHtml += `
                <label for="${fieldId}" class="block text-sm font-medium text-gray-700 mb-2">
                    ${escapeHtml(field.label)}
                    ${field.required ? '<span class="text-red-500">*</span>' : ''}
                </label>
            `;
        }
        
        // Campo según el tipo
        switch(field.type) {
            case 'text':
            case 'email':
            case 'number':
            case 'tel':
                fieldHtml += `
                    <input 
                        type="${field.type}" 
                        id="${fieldId}" 
                        name="${field.name}" 
                        ${field.placeholder ? `placeholder="${escapeHtml(field.placeholder)}"` : ''}
                        ${field.required ? 'required' : ''}
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                `;
                break;
                
            case 'textarea':
                fieldHtml += `
                    <textarea 
                        id="${fieldId}" 
                        name="${field.name}" 
                        rows="4"
                        ${field.placeholder ? `placeholder="${escapeHtml(field.placeholder)}"` : ''}
                        ${field.required ? 'required' : ''}
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    ></textarea>
                `;
                break;
                
            case 'select':
                fieldHtml += `
                    <select 
                        id="${fieldId}" 
                        name="${field.name}"
                        ${field.required ? 'required' : ''}
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Selecciona una opción</option>
                        ${field.options ? field.options.map(opt => {
                            const value = typeof opt === 'object' ? (opt.value || opt.label) : opt;
                            const label = typeof opt === 'object' ? (opt.label || opt.value) : opt;
                            return `<option value="${escapeHtml(value)}">${escapeHtml(label)}</option>`;
                        }).join('') : ''}
                    </select>
                `;
                break;
                
            case 'checkbox':
                fieldHtml += `
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="${fieldId}" 
                            name="${field.name}" 
                            value="1"
                            ${field.required ? 'required' : ''}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="${fieldId}" class="ml-2 text-sm text-gray-700">
                            ${escapeHtml(field.placeholder || field.label || 'Acepto')}
                        </label>
                    </div>
                `;
                break;
                
            case 'radio':
                if (field.options && field.options.length > 0) {
                    fieldHtml += '<div class="space-y-2">';
                    field.options.forEach((opt, index) => {
                        const value = typeof opt === 'object' ? (opt.value || opt.label) : opt;
                        const label = typeof opt === 'object' ? (opt.label || opt.value) : opt;
                        const radioId = `${fieldId}_${index}`;
                        fieldHtml += `
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    id="${radioId}" 
                                    name="${field.name}" 
                                    value="${escapeHtml(value)}"
                                    ${field.required ? 'required' : ''}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                >
                                <label for="${radioId}" class="ml-2 text-sm text-gray-700">
                                    ${escapeHtml(label)}
                                </label>
                            </div>
                        `;
                    });
                    fieldHtml += '</div>';
                }
                break;
                
            case 'date':
                fieldHtml += `
                    <input 
                        type="date" 
                        id="${fieldId}" 
                        name="${field.name}" 
                        ${field.required ? 'required' : ''}
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                `;
                break;
                
            case 'file':
                fieldHtml += `
                    <input 
                        type="file" 
                        id="${fieldId}" 
                        name="${field.name}" 
                        ${field.required ? 'required' : ''}
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                `;
                break;
        }
        
        // Help text
        if (field.help_text) {
            fieldHtml += `<p class="mt-1 text-sm text-gray-500">${escapeHtml(field.help_text)}</p>`;
        }
        
        return `<div class="mb-4">${fieldHtml}</div>`;
    }
    
    // Función para renderizar el formulario completo
    function renderForm(formData) {
        let formHtml = '<form class="space-y-4 dynamic-form" method="POST" data-form-id="' + formData.id + '">';
        formHtml += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
        
        // Título del formulario
        if (formData.show_title && formData.name) {
            formHtml += `<h3 class="text-xl font-bold text-gray-900 mb-4">${escapeHtml(formData.name)}</h3>`;
        }
        
        // Descripción
        if (formData.show_description && formData.description) {
            formHtml += `<p class="text-gray-600 mb-4">${escapeHtml(formData.description)}</p>`;
        }
        
        // Campos del formulario
        if (formData.fields && formData.fields.length > 0) {
            formData.fields.forEach(field => {
                formHtml += renderFormField(field);
            });
        }
        
        // Botón de envío
        formHtml += `
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                ${escapeHtml(formData.submit_button_text || 'Enviar')}
            </button>
        `;
        
        formHtml += '</form>';
        
        // Agregar event listener para el envío del formulario
        setTimeout(() => {
            const formEl = container.querySelector('form');
            if (formEl) {
                formEl.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleFormSubmit(e.target, formData);
                });
            }
        }, 100);
        
        return formHtml;
    }
    
    // Función para manejar el envío del formulario
    function handleFormSubmit(formElement, formData) {
        console.log("📋 [FORM SCRIPT] Enviando formulario:", formData.id);
        
        const formButton = formElement.querySelector('button[type="submit"]');
        const originalText = formButton ? formButton.innerHTML : '';
        
        // Deshabilitar botón y mostrar loading
        if (formButton) {
            formButton.disabled = true;
            formButton.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Enviando...</span>';
        }
        
        // Recopilar datos del formulario
        const formDataObj = new FormData(formElement);
        const data = {};
        for (let [key, value] of formDataObj.entries()) {
            if (key !== '_token') {
                data[key] = value;
            }
        }
        
        const websiteId = {{ $websiteId }};
        
        // Enviar formulario
        fetch(`/creator/api/websites/${websiteId}/forms/${formData.id}/submit`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Mostrar mensaje de éxito
                formElement.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xl font-semibold text-green-600 mb-2">${escapeHtml(formData.success_message || '¡Formulario enviado exitosamente!')}</p>
                    </div>
                `;
            } else {
                throw new Error(result.message || 'Error al enviar el formulario');
            }
        })
        .catch(error => {
            console.error("❌ [FORM SCRIPT] Error al enviar formulario:", error);
            
            // Restaurar botón
            if (formButton) {
                formButton.disabled = false;
                formButton.innerHTML = originalText;
            }
            
            // Mostrar mensaje de error
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-md';
            errorDiv.innerHTML = `
                <p class="text-red-600">${escapeHtml(formData.error_message || 'Hubo un error al enviar el formulario. Por favor, intenta nuevamente.')}</p>
            `;
            if (formElement && formElement.firstChild) {
                formElement.insertBefore(errorDiv, formElement.firstChild);
            } else if (formElement) {
                formElement.appendChild(errorDiv);
            } else {
                console.error('❌ No se puede insertar el mensaje de error: formElement no encontrado');
            }
            
            // Remover mensaje después de 5 segundos
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        });
    }
    
    // Función para cargar formularios
    function loadForms() {
        const formContainers = document.querySelectorAll('[data-dynamic-form="true"]');
        
        if (formContainers.length === 0) {
            return;
        }
        
        const websiteId = {{ $websiteId }};
        
        formContainers.forEach((container, index) => {
            const formId = container.getAttribute('data-form-id');
            
            if (!formId || formId === '') {
                return;
            }
            
            if (!websiteId || websiteId === '') {
                return;
            }
            
            // Mostrar loading
            const placeholder = container.querySelector('#form-placeholder');
            if (placeholder) {
                placeholder.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                        <p class="text-gray-600">Cargando formulario...</p>
                    </div>
                `;
            }
            
            // Cargar formulario desde la API
            fetch(`/creator/api/websites/${websiteId}/forms/${formId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error " + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data && data.data) {
                    const formHtml = renderForm(data.data);
                    container.innerHTML = formHtml;
                } else {
                    throw new Error("Formulario no encontrado");
                }
            })
            .catch(error => {
                console.error("❌ [FORM SCRIPT] Error al cargar formulario:", error);
                if (placeholder) {
                    placeholder.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-600">Error al cargar el formulario</p>
                            <p class="text-sm text-gray-500 mt-2">Verifica que el formulario esté activo</p>
                        </div>
                    `;
                }
            });
        });
    }
    
    // Función auxiliar para escapar HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Cargar formularios después de un delay
    setTimeout(() => {
        loadForms();
    }, 500);
    
    // También intentar cargar después del evento load
    if (document.readyState === 'loading') {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loadForms();
            }, 300);
        });
    }
});
</script>
