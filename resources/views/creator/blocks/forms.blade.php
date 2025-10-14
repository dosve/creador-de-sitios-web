{{-- Bloques de Formularios --}}
{
  id: 'form-contact',
  label: 'Formulario de Contacto',
  category: 'Formularios', attributes: {
    class: 'gjs-block-form'
  }
  , content: `<section class="py-16 contact-form bg-gray-50">
    <div class="container max-w-2xl px-4 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center">Contáctanos</h2>
        <form class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <input type="text" placeholder="Nombre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <input type="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <input type="text" placeholder="Asunto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <textarea placeholder="Mensaje" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            <button type="submit" class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">Enviar Mensaje</button>
        </form>
    </div>
  </section>`
},
{
  id: 'newsletter',
  label: 'Newsletter',
  category: 'Formularios', attributes: {
    class: 'gjs-block-newsletter'
  }
  , content: `<section class="py-16 text-white bg-blue-600 newsletter">
    <div class="container px-4 mx-auto text-center">
        <h2 class="mb-4 text-3xl font-bold">Suscríbete a nuestro Newsletter</h2>
        <p class="max-w-2xl mx-auto mb-8 text-blue-100">Recibe las últimas noticias y actualizaciones directamente en tu bandeja de entrada.</p>
        <form class="flex flex-col max-w-md gap-4 mx-auto md:flex-row">
            <input type="email" placeholder="Tu email" class="flex-1 px-4 py-3 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" class="px-6 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Suscribirse</button>
        </form>
    </div>
  </section>`
}
