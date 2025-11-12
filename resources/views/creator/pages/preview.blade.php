@extends('layouts.creator')

@section('title', 'Vista Previa - ' . $pageData['title'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header de Vista Previa -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">
                                <i class="fas fa-eye mr-2"></i>
                                Vista Previa de Página
                            </h3>
                            <p class="mb-0">{{ $pageData['title'] }} - {{ $pageData['slug'] }}</p>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>
                            <button class="btn btn-success btn-sm" onclick="importThisPage()">
                                <i class="fas fa-download mr-1"></i>
                                Importar Esta Página
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Página -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Información de la Página</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Título:</strong></td>
                                    <td>{{ $pageData['title'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug:</strong></td>
                                    <td>/{{ $pageData['slug'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Página de Inicio:</strong></td>
                                    <td>
                                        @if($pageData['is_home'] ?? false)
                                            <span class="badge badge-success">Sí</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Meta Título:</strong></td>
                                    <td>{{ $pageData['meta_title'] ?? 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Meta Descripción:</strong></td>
                                    <td>{{ $pageData['meta_description'] ?? 'No especificada' }}</td>
                                </tr>
                                @if(isset($pageData['blocks']))
                                <tr>
                                    <td><strong>Bloques:</strong></td>
                                    <td>{{ count($pageData['blocks']) }} bloques</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Bloques de Contenido</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($pageData['blocks']) && count($pageData['blocks']) > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($pageData['blocks'] as $index => $block)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ ucfirst(str_replace('_', ' ', $block['type'])) }}</strong>
                                            @if(isset($block['title']))
                                                <br><small class="text-muted">{{ $block['title'] }}</small>
                                            @endif
                                        </div>
                                        <span class="badge badge-primary">{{ $index + 1 }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No hay bloques de contenido definidos.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista Previa del Contenido -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vista Previa del Contenido</h5>
                    <small class="text-muted">Esta es una simulación de cómo se verá la página</small>
                </div>
                <div class="card-body">
                    <div class="preview-container" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        <!-- Simulación de la página -->
                        <div class="preview-page" style="min-height: 600px; background: #fff;">
                            <!-- Header simulado -->
                            <div class="preview-header" style="background: #f8f9fa; padding: 20px; border-bottom: 1px solid #dee2e6;">
                                <h1 style="margin: 0; color: #333;">{{ $pageData['title'] }}</h1>
                                @if(isset($pageData['meta_description']))
                                    <p style="margin: 10px 0 0 0; color: #666;">{{ $pageData['meta_description'] }}</p>
                                @endif
                            </div>

                            <!-- Contenido simulado -->
                            <div class="preview-content" style="padding: 30px;">
                                @if(isset($pageData['blocks']))
                                    @foreach($pageData['blocks'] as $block)
                                        @include('creator.pages.preview-blocks.' . $block['type'], ['block' => $block])
                                    @endforeach
                                @else
                                    <div class="text-center text-muted" style="padding: 60px 20px;">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <h4>Contenido de la Página</h4>
                                        <p>Esta página no tiene bloques de contenido definidos.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de importación -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Importación</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres importar la página <strong>"{{ $pageData['title'] }}"</strong>?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    La página se importará con todos sus bloques de contenido.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmImportBtn">
                    <i class="fas fa-download mr-1"></i>
                    Importar Página
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function importThisPage() {
    $('#importModal').modal('show');
}

document.getElementById('confirmImportBtn').addEventListener('click', function() {
    const pageSlug = '{{ $pageData["slug"] }}';
    const templateSlug = '{{ $templateSlug }}';
    
    // Deshabilitar botón y mostrar loading
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Importando...';
    
    // Enviar petición AJAX
    fetch('{{ route("creator.pages.import.store", ["website" => $website->id]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            pages: [pageSlug],
            template_slug: templateSlug
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Página importada exitosamente!');
            window.location.href = '{{ route("creator.pages.index") }}';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al importar la página.');
    })
    .finally(() => {
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-download mr-1"></i>Importar Página';
        $('#importModal').modal('hide');
    });
});
</script>
@endpush

@push('styles')
<style>
.preview-container {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.preview-page {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.preview-header h1 {
    font-size: 2rem;
    font-weight: 600;
}

.preview-content {
    line-height: 1.6;
}

.preview-content h2 {
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.preview-content h3 {
    color: #555;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.preview-content p {
    color: #666;
    margin-bottom: 1rem;
}

.preview-content .btn {
    margin: 0.25rem;
}
</style>
@endpush
