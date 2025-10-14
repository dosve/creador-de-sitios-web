{{-- Modal para editar propiedades de un campo --}}
<div id="field-editor-modal" 
     class="fixed inset-0 z-50 hidden overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
             aria-hidden="true"
             onclick="closeFieldEditor()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Editar Campo
                        </h3>
                        
                        <form id="field-editor-form" class="mt-4 space-y-4">
                            <!-- Label -->
                            <div>
                                <label for="field-label" class="block text-sm font-medium text-gray-700">
                                    Etiqueta
                                </label>
                                <input type="text" 
                                       id="field-label" 
                                       name="label"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                       placeholder="Nombre del campo">
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="field-name" class="block text-sm font-medium text-gray-700">
                                    Nombre (interno)
                                </label>
                                <input type="text" 
                                       id="field-name" 
                                       name="name"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                       placeholder="nombre_campo">
                                <p class="mt-1 text-xs text-gray-500">Usado para identificar el campo en la base de datos</p>
                            </div>

                            <!-- Placeholder -->
                            <div>
                                <label for="field-placeholder" class="block text-sm font-medium text-gray-700">
                                    Placeholder
                                </label>
                                <input type="text" 
                                       id="field-placeholder" 
                                       name="placeholder"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                       placeholder="Texto de ayuda">
                            </div>

                            <!-- Required -->
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="field-required" 
                                       name="required"
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <label for="field-required" class="ml-2 text-sm text-gray-700">
                                    Campo obligatorio
                                </label>
                            </div>

                            <!-- Options (para select, radio, checkbox) -->
                            <div id="field-options-container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700">
                                    Opciones
                                </label>
                                <div id="options-list" class="mt-2 space-y-2">
                                    <!-- Las opciones se añadirán dinámicamente aquí -->
                                </div>
                                <button type="button" 
                                        onclick="addOption()"
                                        class="inline-flex items-center px-3 py-1 mt-2 text-sm font-medium text-green-700 bg-green-100 border border-transparent rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar opción
                                </button>
                            </div>

                            <!-- Validation Rules -->
                            <div>
                                <label for="field-validation" class="block text-sm font-medium text-gray-700">
                                    Reglas de validación
                                </label>
                                <input type="text" 
                                       id="field-validation" 
                                       name="validation_rules"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                       placeholder="min:3|max:100">
                                <p class="mt-1 text-xs text-gray-500">Reglas de validación de Laravel separadas por |</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" 
                        onclick="saveFieldChanges()"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Guardar
                </button>
                <button type="button" 
                        onclick="closeFieldEditor()"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


