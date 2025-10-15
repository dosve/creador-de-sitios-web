{{-- Footer para Plantilla Básica --}}
<footer class="py-12 text-white bg-gray-800">
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            {{-- Columna 1: Info del sitio --}}
            <div>
                @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10 mb-4 brightness-0 invert">
                @else
                    <h3 class="mb-4 text-lg font-semibold">{{ $website->name ?? 'Mi Sitio Web' }}</h3>
                @endif
                <p class="text-gray-400">{{ $website->description ?? 'Descripción de mi sitio web' }}</p>
            </div>
            
            {{-- Columna 2: Enlaces rápidos --}}
            <div>
                <h4 class="mb-4 text-lg font-semibold">Enlaces Rápidos</h4>
                <ul class="space-y-2">
                    @include('templates.partials.menu-footer')
                </ul>
            </div>
            
            {{-- Columna 3: Contacto --}}
            <div>
                <h4 class="mb-4 text-lg font-semibold">Contacto</h4>
                @if(!empty($website->contact_email))
                <p class="text-gray-400 mb-2">Email: {{ $website->contact_email }}</p>
                @else
                <p class="text-gray-400 mb-2">Email: contacto@misitio.com</p>
                @endif
                
                @if(!empty($website->contact_phone))
                <p class="text-gray-400 mb-2">Teléfono: {{ $website->contact_phone }}</p>
                @else
                <p class="text-gray-400 mb-2">Teléfono: +1 234 567 890</p>
                @endif
                
                @if(!empty($website->contact_address))
                <p class="text-gray-400">Dirección: {{ $website->contact_address }}</p>
                @endif
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-700">
            <p>&copy; {{ date('Y') }} {{ $website->name ?? 'Mi Sitio Web' }}. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

