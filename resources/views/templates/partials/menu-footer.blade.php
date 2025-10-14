@php
    $footerMenu = $website->menus()->where('location', 'footer')->where('is_active', true)->first();
@endphp

@if($footerMenu && $footerMenu->activeItems()->count() > 0)
    @foreach($footerMenu->activeItems()->orderBy('order')->get() as $item)
        <li>
            <a href="{{ $item->final_url }}" 
               target="{{ $item->target }}"
               class="text-gray-400 hover:text-white transition-colors">
                @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
                {{ $item->title }}
            </a>
        </li>
    @endforeach
@else
    {{-- Menú por defecto si no hay menú configurado --}}
    <li><a href="/{{ $website->slug }}" class="text-gray-400 hover:text-white">Inicio</a></li>
    <li><a href="/{{ $website->slug }}/blog" class="text-gray-400 hover:text-white">Blog</a></li>
    <li><a href="/{{ $website->slug }}/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>
@endif

