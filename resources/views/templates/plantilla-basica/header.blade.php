{{-- Header para Plantilla Básica --}}
<header class="basica-header">
    <div class="container px-4 py-6 mx-auto">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <div>
                @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10">
                @else
                    <h1 class="basica-logo text-2xl font-bold">{{ $website->name ?? 'Mi Sitio Web' }}</h1>
                @endif
            </div>
            
            {{-- Menú navegación desktop --}}
            <nav class="hidden space-x-6 md:flex">
                @include('templates.partials.menu-header')
            </nav>
            
            {{-- Botón menú móvil --}}
            <button id="mobile-menu-btn" class="p-2 md:hidden text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        {{-- Menú móvil --}}
        <nav id="mobile-menu" class="hidden mt-4 pb-4 border-t md:hidden">
            <div class="flex flex-col space-y-2 mt-4">
                @include('templates.partials.menu-header')
            </div>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>

