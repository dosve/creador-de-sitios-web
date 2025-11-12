@extends('templates.plantilla-demo.layout')

@section('content')
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold tracking-tight mb-4">Bienvenido a Plantilla Demo</h1>
        <p class="text-gray-600 mb-8">Esta es una plantilla base con menú grueso y footer blanco. Úsala como punto de partida para un sitio real.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i=1;$i<=3;$i++)
            <div class="p-6 rounded-2xl border border-gray-200">
                <h3 class="font-semibold mb-2">Sección {{ $i }}</h3>
                <p class="text-sm text-gray-600">Contenido de ejemplo para la sección {{ $i }}.</p>
            </div>
            @endfor
        </div>
    </div>
@endsection


