@php
$headerMenu = $website->menus()->where('location', 'header')->where('is_active', true)->first();
@endphp

@if($headerMenu && $headerMenu->activeItems()->count() > 0)
@foreach($headerMenu->activeItems()->orderBy('order')->get() as $item)
@php
$finalUrl = $item->final_url;
$isExternal = \Illuminate\Support\Str::startsWith($finalUrl ?? '', ['http://', 'https://', '//']);

if (!$isExternal) {
    // El método final_url ya retorna la URL correcta con el slug del website incluido
    // Solo necesitamos convertirlo a URL completa si no es externo
    $finalUrl = url($finalUrl);
}
@endphp
<a href="{{ $finalUrl }}"
    target="{{ $item->target }}"
    class="text-gray-600 transition-colors hover:text-gray-900">
    @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
    {{ $item->title }}
</a>
@endforeach
@else
{{-- Menú por defecto si no hay menú configurado --}}
<a href="{{ url($website->slug) }}" class="text-gray-600 transition-colors hover:text-gray-900">Inicio</a>
@if($website->pages()->where('slug', 'productos')->where('is_published', true)->exists())
<a href="{{ url($website->slug . '/productos') }}" class="text-gray-600 transition-colors hover:text-gray-900">Productos</a>
@endif
<a href="{{ url($website->slug . '/blog') }}" class="text-gray-600 transition-colors hover:text-gray-900">Blog</a>
<a href="{{ url($website->slug . '#contacto') }}" class="text-gray-600 transition-colors hover:text-gray-900">Contacto</a>
@endif