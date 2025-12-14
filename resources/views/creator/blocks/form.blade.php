{{-- 
  ========================================
  📋 WIDGET DE FORMULARIO
  ========================================
  Categoría: Formularios
  Widget: Formulario Dinámico (permite seleccionar formulario creado en el admin)
--}}

{{-- Widget: Formulario Dinámico --}}
{
  id: 'form-dynamic',
  label: '📋 Formulario',
  category: 'Avanzados',
  attributes: {
    class: 'gjs-block-form',
    title: 'Formulario dinámico - Selecciona un formulario creado en el administrador'
  },
  content: `<div class="form-container max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg" data-dynamic-form="true" data-form-id="">
    <div id="form-placeholder" class="text-center py-8">
      <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <p class="text-gray-600">El formulario se cargará dinámicamente en la vista previa</p>
      <p class="text-sm text-gray-500 mt-2">Selecciona un formulario en las propiedades del bloque</p>
    </div>
  </div>`,
  traits: [
    {
      type: 'select',
      name: 'form-id',
      label: 'Seleccionar Formulario',
      changeProp: 1,
      options: [
        { value: '', name: '-- Selecciona un formulario --' }
      ]
    }
  ]
}
