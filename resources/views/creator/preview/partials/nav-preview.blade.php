{{-- Navbar compartido con blank y páginas de blog post (sin plantilla). Usa $website. --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="{{ url($website->slug) }}" class="flex items-center gap-2 text-2xl font-bold text-gray-900 hover:text-emerald-600 transition-colors">
                @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="h-10 object-contain">
                @else
                    {{ $website->name }}
                @endif
            </a>
            <div class="hidden md:flex items-center space-x-8">
                @include('templates.partials.menu-header')
            </div>
            <button id="mobile-menu-button" type="button" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none" aria-label="Menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3">
            @include('templates.partials.menu-header')
        </div>
    </div>
</nav>
