<header class="bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4">
    <nav class="flex items-center justify-between py-5 font-extrabold tracking-tight">
      <a href="/" class="text-2xl text-gray-900">{{ $website->name ?? 'Plantilla Demo' }}</a>
      <ul class="hidden md:flex items-center gap-8 text-gray-800 text-lg">
@php
    $headerMenu = isset($website) ? $website->menus()->byLocation('header')->active()->with(['items' => function($q){
        $q->whereNull('parent_id')->where('is_active', true)->orderBy('order');
    }, 'items.page'])->first() : null;
@endphp
@if($headerMenu && $headerMenu->items->count())
@foreach($headerMenu->items as $item)
        <li><a href="{{ $item->final_url }}" target="{{ $item->target }}" class="hover:text-black">{{ $item->title }}</a></li>
@endforeach
@else
        <li><a href="/inicio" class="hover:text-black">Inicio</a></li>
        <li><a href="/productos" class="hover:text-black">Productos</a></li>
        <li><a href="/categorias" class="hover:text-black">Categorías</a></li>
        <li><a href="/contacto" class="hover:text-black">Contacto</a></li>
@endif
      </ul>
      <button class="md:hidden text-2xl" aria-label="Abrir menú">☰</button>
    </nav>
  </div>
</header>


