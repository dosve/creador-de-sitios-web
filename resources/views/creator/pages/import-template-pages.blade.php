@extends('layouts.creator')

@section('title', 'Importar Páginas - ' . ucfirst(str_replace('-', ' ', $templateSlug)))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title">
                                <i class="fas fa-palette mr-2"></i>
                                Importar Páginas - {{ ucfirst(str_replace('-', ' ', $templateSlug)) }}
                            </h3>
                            <p class="text-muted mb-0">Páginas prediseñadas de esta plantilla específica</p>
                        </div>
                        <a href="{{ route('creator.pages.import.categories', ['website' => $website->id]) }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Volver a Categorías
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="importForm">
                        @csrf
                        <input type="hidden" name="template_slug" value="{{ $templateSlug }}">
                        
                        <div class="row">
                            @foreach($pages as $page)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check mr-3">
                                                <input class="form-check-input page-checkbox" 
                                                       type="checkbox" 
                                                       value="{{ $page['slug'] }}" 
                                                       id="page_{{ $page['slug'] }}">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="card-title mb-2">
                                                    {{ $page['title'] }}
                                                    @if($page['is_home'] ?? false)
                                                        <span class="badge badge-primary ml-2">Inicio</span>
                                                    @endif
                                                </h6>
                                                <p class="card-text text-muted small mb-2">
                                                    {{ $page['meta_description'] ?? 'Sin descripción' }}
                                                </p>
                                                <div class="text-muted small">
                                                    <i class="fas fa-link mr-1"></i>
                                                    /{{ $page['slug'] }}
                                                </div>
                                                @if(isset($page['blocks']) && count($page['blocks']) > 0)
                                                <div class="text-muted small mt-2">
                                                    <i class="fas fa-cubes mr-1"></i>
                                                    {{ count($page['blocks']) }} bloques
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ml-2">
                                                <button type="button" 
                                                        class="btn btn-outline-info btn-sm" 
                                                        onclick="previewTemplatePage('{{ $page['slug'] }}')"
                                                        title="Vista previa">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Controles -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="selectAll">
                                                    <i class="fas fa-check-square mr-1"></i>
                                                    Seleccionar Todas
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="selectNone">
                                                    <i class="fas fa-square mr-1"></i>
                                                    Deseleccionar Todas
                                                </button>
                                            </div>
                                            <div>
                                                <span class="text-muted mr-3">
                                                    <span id="selectedCount">0</span> páginas seleccionadas
                                                </span>
                                                <button type="submit" class="btn btn-primary" id="importBtn" disabled>
                                                    <i class="fas fa-download mr-1"></i>
                                                    Importar Páginas
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Importación</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres importar <span id="confirmCount">0</span> páginas de la plantilla <strong>{{ ucfirst(str_replace('-', ' ', $templateSlug)) }}</strong>?</p>
                <div id="selectedPagesList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmImport">Importar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    
function previewTemplatePage(pageSlug) {
    const previewUrl = '{{ route("creator.pages.preview.template", ["website" => $website->id, "pageSlug" => ":pageSlug", "templateSlug" => $templateSlug]) }}'.replace(':pageSlug', pageSlug);
    window.open(previewUrl, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.page-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const importBtn = document.getElementById('importBtn');
    const selectAllBtn = document.getElementById('selectAll');
    const selectNoneBtn = document.getElementById('selectNone');
    const confirmModal = document.getElementById('confirmModal');
    const confirmCount = document.getElementById('confirmCount');
    const selectedPagesList = document.getElementById('selectedPagesList');
    const confirmImportBtn = document.getElementById('confirmImport');

    // Actualizar contador
    function updateCounter() {
        const selected = document.querySelectorAll('.page-checkbox:checked');
        const count = selected.length;
        selectedCount.textContent = count;
        importBtn.disabled = count === 0;
    }

    // Event listeners para checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCounter);
    });

    // Seleccionar todas
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateCounter();
    });

    // Deseleccionar todas
    selectNoneBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateCounter();
    });

    // Enviar formulario
    document.getElementById('importForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selected = Array.from(document.querySelectorAll('.page-checkbox:checked'))
            .map(checkbox => checkbox.value);
        
        if (selected.length === 0) {
            alert('Por favor selecciona al menos una página para importar.');
            return;
        }

        // Mostrar modal de confirmación
        confirmCount.textContent = selected.length;
        selectedPagesList.innerHTML = selected.map(slug => 
            `<li>${slug.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}</li>`
        ).join('');
        
        $('#confirmModal').modal('show');
    });

    // Confirmar importación
    confirmImportBtn.addEventListener('click', function() {
        const selected = Array.from(document.querySelectorAll('.page-checkbox:checked'))
            .map(checkbox => checkbox.value);
        
        // Deshabilitar botón y mostrar loading
        confirmImportBtn.disabled = true;
        confirmImportBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Importando...';
        
        // Enviar petición AJAX
        fetch('{{ route("creator.pages.import.store", ["website" => $website->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                pages: selected,
                template_slug: '{{ $templateSlug }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`¡Éxito! Se importaron ${data.imported} páginas.`);
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al importar las páginas.');
        })
        .finally(() => {
            confirmImportBtn.disabled = false;
            confirmImportBtn.innerHTML = 'Importar';
            $('#confirmModal').modal('hide');
        });
    });
});
</script>
@endpush
