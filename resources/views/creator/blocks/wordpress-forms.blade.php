{{-- Bloques de Formularios de WordPress --}}
{
  id: 'contact-form',
  label: 'Formulario de Contacto',
  category: 'WordPress Formularios',
  content: `
    <div class="contact-form bg-white border border-gray-200 rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulario de Contacto</h3>
      <form class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
            <input type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
          <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje *</label>
          <textarea rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
          Enviar Mensaje
        </button>
      </form>
    </div>
  `
},
{
  id: 'text-field',
  label: 'Campo de Texto',
  category: 'WordPress Formularios',
  content: `
    <div class="text-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Campo de Texto</label>
      <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Escribe aquí...">
    </div>
  `
},
{
  id: 'email-field',
  label: 'Campo de Email',
  category: 'WordPress Formularios',
  content: `
    <div class="email-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
      <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="tu@email.com">
    </div>
  `
},
{
  id: 'phone-field',
  label: 'Campo de Teléfono',
  category: 'WordPress Formularios',
  content: `
    <div class="phone-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
      <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="+1 234 567 8900">
    </div>
  `
},
{
  id: 'textarea-field',
  label: 'Área de Texto',
  category: 'WordPress Formularios',
  content: `
    <div class="textarea-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
      <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Escribe tu mensaje aquí..."></textarea>
    </div>
  `
},
{
  id: 'checkbox-field',
  label: 'Casilla de Verificación',
  category: 'WordPress Formularios',
  content: `
    <div class="checkbox-field">
      <label class="flex items-center space-x-2">
        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <span class="text-sm text-gray-700">Acepto los términos y condiciones</span>
      </label>
    </div>
  `
},
{
  id: 'radio-field',
  label: 'Botón de Opción',
  category: 'WordPress Formularios',
  content: `
    <div class="radio-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona una opción</label>
      <div class="space-y-2">
        <label class="flex items-center space-x-2">
          <input type="radio" name="option" value="option1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
          <span class="text-sm text-gray-700">Opción 1</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="radio" name="option" value="option2" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
          <span class="text-sm text-gray-700">Opción 2</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="radio" name="option" value="option3" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
          <span class="text-sm text-gray-700">Opción 3</span>
        </label>
      </div>
    </div>
  `
},
{
  id: 'select-field',
  label: 'Lista Desplegable',
  category: 'WordPress Formularios',
  content: `
    <div class="select-field">
      <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona una opción</label>
      <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <option value="">Selecciona...</option>
        <option value="opcion1">Opción 1</option>
        <option value="opcion2">Opción 2</option>
        <option value="opcion3">Opción 3</option>
        <option value="opcion4">Opción 4</option>
      </select>
    </div>
  `
},
{
  id: 'file-upload',
  label: 'Carga de Archivos',
  category: 'WordPress Formularios',
  content: `
    <div class="file-upload">
      <label class="block text-sm font-medium text-gray-700 mb-2">Subir Archivo</label>
      <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        <p class="text-sm text-gray-600 mb-2">Arrastra y suelta tu archivo aquí</p>
        <p class="text-xs text-gray-500">o</p>
        <button type="button" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Seleccionar archivo
        </button>
        <p class="text-xs text-gray-500 mt-2">Máximo 10MB</p>
      </div>
    </div>
  `
}
