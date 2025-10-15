@php
    $headerMenu = $website->menus()->where('location', 'header')->where('is_active', true)->first();
@endphp

@if($headerMenu && $headerMenu->activeItems()->count() > 0)
    @foreach($headerMenu->activeItems()->orderBy('order')->get() as $item)
        <a href="{{ $item->final_url }}" 
           target="{{ $item->target }}"
           class="text-gray-600 hover:text-gray-900 transition-colors">
            @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
            {{ $item->title }}
        </a>
    @endforeach
@else
    {{-- Menú por defecto si no hay menú configurado --}}
    <a href="/{{ $website->slug }}" class="text-gray-600 hover:text-gray-900">Inicio</a>
    <a href="/{{ $website->slug }}/blog" class="text-gray-600 hover:text-gray-900">Blog</a>
    <a href="/{{ $website->slug }}/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>
@endif

