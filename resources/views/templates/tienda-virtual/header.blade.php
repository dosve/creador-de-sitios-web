{{-- Header para Tienda Virtual --}}
<header class="bg-white border-b shadow-sm {{ $headerConfig['sticky'] ?? true ? 'sticky top-0 z-50' : '' }}">
    <div class="container px-4 py-4 mx-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                {{-- Logo --}}
                @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10">
                @else
                    <h1 class="text-2xl font-bold text-gray-900">{{ $website->name ?? 'Mi Tienda' }}</h1>
                @endif
                
                {{-- Menú de navegación --}}
                <nav class="hidden space-x-6 md:flex">
                    @include('templates.partials.menu-header')
                </nav>
            </div>
            
            <div class="flex items-center space-x-4">
                {{-- Buscador (opcional) --}}
                @if($headerConfig['show_search'] ?? false)
                <button class="p-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                @endif
                
                {{-- Carrito de compras --}}
                @if($headerConfig['show_cart'] ?? true)
                <button id="cart-button" class="relative p-2 text-gray-800 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="#374151" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/>
                        <path d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/>
                    </svg>
                    <span id="cart-counter" class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-1 -right-1">0</span>
                </button>
                @endif
                
                {{-- Botón menú móvil --}}
                <button id="mobile-menu-btn" class="p-2 md:hidden text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Menú móvil --}}
        <nav id="mobile-menu" class="hidden mt-4 pb-4 border-t md:hidden">
            <div class="flex flex-col space-y-2 mt-4">
                @include('templates.partials.menu-header')
            </div>
        </nav>
    </div>
</header>

{{-- Script para menú móvil --}}
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

