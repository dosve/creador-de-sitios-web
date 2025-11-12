@extends('layouts.creator')

@section('title', 'Test - ' . $website->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Test de Páginas</h2>
            <p>Este es un test para verificar que el layout funciona correctamente.</p>
            
            @if(isset($pages) && count($pages) > 0)
                <div class="alert alert-info">
                    <h4>Páginas encontradas: {{ count($pages) }}</h4>
                    <ul>
                        @foreach($pages as $page)
                            <li>{{ $page->title }} - {{ $page->slug }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert alert-warning">
                    No se encontraron páginas.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
