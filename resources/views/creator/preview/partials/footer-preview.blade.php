{{-- Footer predefinido para vista previa (solo preview). Usa info de Información General. --}}
<footer class="py-12 mt-12 text-white bg-gray-800 border-t border-gray-700">
    <div class="container px-4 mx-auto max-w-7xl">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            {{-- Columna 1: Info del sitio --}}
            <div>
                @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10 mb-4 brightness-0 invert object-contain">
                @else
                    <h3 class="mb-4 text-lg font-semibold">{{ $website->name ?? 'Mi Sitio Web' }}</h3>
                @endif
                <p class="text-gray-400">{{ $website->description ?? 'Descripción de mi sitio web' }}</p>
            </div>

            {{-- Columna 2: Enlaces rápidos (menú footer) --}}
            <div>
                <h4 class="mb-4 text-lg font-semibold">Enlaces rápidos</h4>
                <ul class="space-y-2">
                    @include('templates.partials.menu-footer')
                </ul>
            </div>

            {{-- Columna 3: Contacto (desde Información General) --}}
            <div>
                <h4 class="mb-4 text-lg font-semibold">Contacto</h4>
                <div class="space-y-2 text-gray-400">
                    @if(!empty($website->settings['contact_email'] ?? null))
                        <p>Email: <a href="mailto:{{ $website->settings['contact_email'] }}" class="text-blue-300 hover:text-blue-200">{{ $website->settings['contact_email'] }}</a></p>
                    @else
                        <p class="text-gray-500">Email: (sin configurar)</p>
                    @endif
                    @if(!empty($website->settings['contact_phone'] ?? null))
                        <p>Teléfono: {{ $website->settings['contact_phone'] }}</p>
                    @else
                        <p class="text-gray-500">Teléfono: (sin configurar)</p>
                    @endif
                    @if(!empty($website->settings['contact_address'] ?? null))
                        <p>Dirección: {{ $website->settings['contact_address'] }}</p>
                    @else
                        <p class="text-gray-500">Dirección: (sin configurar)</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="pt-8 mt-8 text-center border-t border-gray-700 text-gray-400">
            <p>&copy; {{ date('Y') }} {{ $website->name ?? 'Mi Sitio Web' }}. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
