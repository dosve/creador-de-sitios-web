{{-- Componente para previsualizar un campo en el canvas --}}
@props(['field'])

<div class="p-4 mb-4 border border-gray-200 rounded-lg form-field bg-white hover:border-green-400 transition-colors group" 
     data-field-id="{{ $field->id }}"
     draggable="true">
    
    <!-- Header del campo -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-2">
            <!-- Icono de drag -->
            <svg class="w-4 h-4 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
            </svg>
            
            <!-- Label del campo -->
            <span class="text-sm font-medium text-gray-900">
                {{ $field->label ?: $field->name }}
                @if($field->required)
                    <span class="text-red-500">*</span>
                @endif
            </span>
        </div>
        
        <!-- Acciones -->
        <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button type="button" 
                    onclick="editField({{ $field->id }})"
                    class="p-1 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            <button type="button" 
                    onclick="deleteField({{ $field->id }})"
                    class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Preview del campo -->
    <div>
        @if($field->type === 'text' || $field->type === 'email' || $field->type === 'number' || $field->type === 'tel')
            <input type="{{ $field->type }}" 
                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                   placeholder="{{ $field->placeholder ?: '' }}"
                   @if($field->required) required @endif
                   disabled>
                   
        @elseif($field->type === 'textarea')
            <textarea rows="3" 
                      class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                      placeholder="{{ $field->placeholder ?: '' }}"
                      @if($field->required) required @endif
                      disabled></textarea>
                      
        @elseif($field->type === 'select')
            <select class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" 
                    @if($field->required) required @endif
                    disabled>
                <option value="">Selecciona una opción</option>
                @if($field->options)
                    @foreach($field->options as $option)
                        <option value="{{ is_array($option) ? ($option['value'] ?? $option['label']) : $option }}">
                            {{ is_array($option) ? ($option['label'] ?? $option['value']) : $option }}
                        </option>
                    @endforeach
                @endif
            </select>
            
        @elseif($field->type === 'checkbox')
            <div class="flex items-center">
                <input type="checkbox" 
                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500" 
                       @if($field->required) required @endif
                       disabled>
                <label class="ml-2 text-sm text-gray-700">{{ $field->placeholder ?: 'Acepto' }}</label>
            </div>
            
        @elseif($field->type === 'radio')
            <div class="space-y-2">
                @if($field->options)
                    @foreach($field->options as $index => $option)
                        <div class="flex items-center">
                            <input type="radio" 
                                   name="radio_{{ $field->id }}" 
                                   value="{{ is_array($option) ? ($option['value'] ?? $option['label']) : $option }}"
                                   class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" 
                                   @if($field->required) required @endif
                                   disabled>
                            <label class="ml-2 text-sm text-gray-700">
                                {{ is_array($option) ? ($option['label'] ?? $option['value']) : $option }}
                            </label>
                        </div>
                    @endforeach
                @else
                    <div class="flex items-center">
                        <input type="radio" name="radio_{{ $field->id }}" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" disabled>
                        <label class="ml-2 text-sm text-gray-700">Opción 1</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="radio_{{ $field->id }}" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" disabled>
                        <label class="ml-2 text-sm text-gray-700">Opción 2</label>
                    </div>
                @endif
            </div>
            
        @elseif($field->type === 'date')
            <input type="date" 
                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                   @if($field->required) required @endif
                   disabled>
                   
        @elseif($field->type === 'file')
            <input type="file" 
                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                   @if($field->required) required @endif
                   disabled>
        @endif
    </div>
    
    <!-- Info adicional -->
    @if($field->validation_rules || $field->help_text)
        <div class="mt-2 text-xs text-gray-500">
            @if($field->help_text)
                <p>{{ $field->help_text }}</p>
            @endif
            @if($field->validation_rules)
                <p class="text-gray-400">Validación: {{ $field->validation_rules }}</p>
            @endif
        </div>
    @endif
</div>


