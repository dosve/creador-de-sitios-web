{{-- Navbar compartido con blank y páginas de blog post (sin plantilla). Usa $website. --}}
<nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container px-6 py-4 mx-auto">
        <div class="flex items-center justify-between">
            <a href="{{ $website->publicBaseUrl() }}" class="flex items-center gap-2 text-2xl font-bold text-gray-900 transition-colors hover:text-emerald-600">
                @if(!empty($website->logo))
                <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name }}" class="object-contain h-10">
                @else
                {{ $website->name }}
                @endif
            </a>
            <div class="items-center hidden space-x-8 md:flex">
                @include('templates.partials.menu-header')
            </div>
            <button id="mobile-menu-button" type="button" class="text-gray-600 md:hidden hover:text-gray-900 focus:outline-none" aria-label="Menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden pb-4 mt-4 space-y-3 md:hidden">
            @include('templates.partials.menu-header')
        </div>
    </div>
</nav>