{{-- Bloques Básicos de WordPress --}}
{
  id: 'list',
  label: 'Lista',
  category: 'Básicos',
  content: `
    <div class="list-container">
      <ul class="list-disc list-inside space-y-2">
        <li>Primer elemento de la lista</li>
        <li>Segundo elemento de la lista</li>
        <li>Tercer elemento de la lista</li>
      </ul>
    </div>
  `
},
{
  id: 'quote',
  label: 'Cita',
  category: 'Básicos',
  content: `
    <blockquote class="border-l-4 border-blue-500 pl-6 py-4 bg-gray-50 rounded-r-lg">
      <p class="text-lg italic text-gray-700 mb-4">"Esta es una cita destacada que resalta una frase importante o testimonio."</p>
      <cite class="text-sm text-gray-600 font-medium">— Autor de la cita</cite>
    </blockquote>
  `
},
{
  id: 'code',
  label: 'Código',
  category: 'Básicos',
  content: `
    <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto">
      <code class="text-sm">
        // Código de ejemplo
        function ejemplo() {
          return "Hola mundo";
        }
      </code>
    </pre>
  `
},
{
  id: 'preformatted',
  label: 'Preformateado',
  category: 'Básicos',
  content: `
    <pre class="bg-gray-100 p-4 rounded-lg font-mono text-sm whitespace-pre-wrap">
      Texto preformateado
      que mantiene
      el formato original
    </pre>
  `
},
{
  id: 'table',
  label: 'Tabla',
  category: 'Diseño',
  content: `
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Juan Pérez</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">juan@ejemplo.com</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Administrador</td>
          </tr>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">María García</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">maria@ejemplo.com</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Editor</td>
          </tr>
        </tbody>
      </table>
    </div>
  `
},
{
  id: 'verse',
  label: 'Verso',
  category: 'Básicos',
  content: `
    <div class="verse-container bg-gray-50 p-6 rounded-lg">
      <div class="text-center font-serif text-lg leading-relaxed text-gray-700">
        <p class="mb-4">Este es un verso</p>
        <p class="mb-4">que mantiene el formato</p>
        <p class="mb-4">y la estructura poética</p>
        <p class="text-sm text-gray-500 italic">— Autor del verso</p>
      </div>
    </div>
  `
},
{
  id: 'classic-editor',
  label: 'Editor Clásico',
  category: 'Básicos',
  content: `
    <div class="classic-editor bg-white border border-gray-300 rounded-lg p-4">
      <div class="prose max-w-none">
        <h2>Título del contenido</h2>
        <p>Este es un párrafo de ejemplo que simula el editor clásico de WordPress con formato rico.</p>
        <p><strong>Texto en negrita</strong> y <em>texto en cursiva</em>.</p>
        <ul>
          <li>Lista con viñetas</li>
          <li>Segundo elemento</li>
        </ul>
      </div>
    </div>
  `
}
