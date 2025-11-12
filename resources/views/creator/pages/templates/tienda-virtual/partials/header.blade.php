<section class="relative overflow-hidden text-center {{ ($full ?? false) ? 'min-h-[90vh] flex items-center' : 'py-24' }}">
    <!-- Fondo con imagen y color por encima -->
    <div class="absolute inset-0">
        @if(!empty($image))
            <img src="{{ $image }}" alt="Header" class="w-full h-full object-cover">
            <!-- Capa de color con transparencia sobre la imagen -->
            <div class="absolute inset-0 bg-indigo-700/90 mix-blend-multiply"></div>
        @else
            <div class="absolute inset-0 bg-indigo-700"></div>
        @endif
    </div>

    <div class="relative max-w-5xl mx-auto px-4 text-white">
        @if(!empty($badge))
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs tracking-wider bg-white/15 text-indigo-50 mb-4">
                <i class="fas fa-bolt mr-2"></i>{{ $badge }}
            </span>
        @endif
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-3">{{ $title ?? 'Título' }}</h1>
        @if(!empty($subtitle))
            <p class="text-base md:text-lg text-indigo-100 max-w-3xl mx-auto">{{ $subtitle }}</p>
        @endif
        @isset($cta)
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a class="px-6 py-3 rounded-xl font-semibold bg-white text-indigo-700 hover:bg-gray-100 transition-colors">{{ $cta['primary'] ?? 'Ver Más' }}</a>
                <a class="px-6 py-3 rounded-xl font-semibold border-2 border-white text-white hover:bg-white hover:text-indigo-700 transition-colors">{{ $cta['secondary'] ?? 'Contactar' }}</a>
            </div>
        @endisset

        <!-- Badges de confianza -->
        <div class="mt-6 flex flex-wrap justify-center gap-6 text-sm text-indigo-100">
            <span class="inline-flex items-center"><i class="fas fa-truck mr-2"></i>Envío rápido</span>
            <span class="inline-flex items-center"><i class="fas fa-shield-alt mr-2"></i>Compra segura</span>
            <span class="inline-flex items-center"><i class="fas fa-undo mr-2"></i>Devoluciones 30 días</span>
        </div>
    </div>
</section>


