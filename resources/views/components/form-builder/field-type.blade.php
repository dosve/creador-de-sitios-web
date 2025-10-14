{{-- Componente para un tipo de campo arrastrable --}}
@props(['type', 'icon', 'label'])

<div class="p-3 border border-gray-200 rounded-lg cursor-move hover:bg-gray-50 hover:border-green-300 transition-colors" 
     draggable="true" 
     data-field-type="{{ $type }}">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
        </svg>
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
    </div>
</div>


