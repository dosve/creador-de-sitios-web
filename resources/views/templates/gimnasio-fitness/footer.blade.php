{{-- Footer Gym --}}
<footer class="bg-black text-white">
  <div class="container px-6 py-16 mx-auto">
    <div class="grid md:grid-cols-3 gap-12 mb-12">
      <div>
        <h3 class="text-2xl font-bold mb-6" style="font-family:'Bebas Neue',sans-serif;">{{ strtoupper($website->name ?? 'GYM') }}</h3>
        <p class="text-gray-400">Tu mejor versión te espera. Entrena con nosotros.</p>
      </div>
      <div>
        <h3 class="text-lg font-bold mb-6">Horarios</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li>Lunes - Viernes: 6:00 - 22:00</li>
          <li>Sábados: 8:00 - 20:00</li>
          <li>Domingos: 9:00 - 14:00</li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-bold mb-6">Contacto</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li>Tel: +1 234 567 89</li>
          <li>Email: info@gym.com</li>
        </ul>
      </div>
    </div>
    <div class="pt-8 border-t border-gray-900 text-center text-sm text-gray-500">
      <p>© {{ date('Y') }} {{ $website->name ?? 'Gym' }}. {{ $footerConfig['copyright_text'] ?? 'Todos los derechos reservados.' }}</p>
    </div>
  </div>
</footer>
