@extends('layouts.creator')

@section('title', 'Importar Páginas - ' . $categoryData['name'])

@section('content')
<div class="container-fluid">
    <!-- Header mejorado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-primary rounded-circle p-3 me-3">
                        <i class="fas fa-file-import fa-2x text-white"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 text-dark fw-bold">Importar Páginas</h2>
                        <p class="text-muted mb-0">{{ $categoryData['name'] }} - Selecciona las páginas que necesitas</p>
                    </div>
                </div>
                <a href="{{ route('creator.pages.import.categories', ['website' => $website->id]) }}" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a Categorías
                </a>
            </div>
        </div>
    </div>

    <!-- Plantillas disponibles -->
    @if(!empty($templates))
    <div class="row mb-4">
        <div class="col-12">
            <div class="templates-section">
                <h5 class="section-title">
                    <i class="fas fa-palette me-2"></i>
                    Plantillas Disponibles
                </h5>
                <div class="templates-grid">
                    @foreach($templates as $template)
                    <a href="{{ route('creator.pages.import.template', ['website' => $website->id, 'template' => $template]) }}" 
                       class="template-card">
                        <div class="template-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="template-name">{{ ucfirst(str_replace('-', ' ', $template)) }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulario de importación -->
    <div class="row">
        <div class="col-12">
            <div class="import-form-card">
                <form id="importForm">
                    @csrf
                    <div class="row">
                        <!-- Páginas Comunes -->
                        <div class="col-md-6">
                            <div class="pages-section essential-pages">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="section-content">
                                        <h5 class="section-title">Páginas Esenciales</h5>
                                        <p class="section-subtitle">Páginas básicas que todo sitio web necesita</p>
                                    </div>
                                </div>
                                <div class="pages-list">
                                    @foreach($categoryData['common_pages'] as $slug => $description)
                                    <div class="page-item">
                                        <div class="page-checkbox">
                                            <input class="form-check-input page-checkbox" 
                                                   type="checkbox" 
                                                   value="{{ $slug }}" 
                                                   id="common_{{ $slug }}"
                                                   data-type="common">
                                        </div>
                                        <div class="page-content">
                                            <label class="page-label" for="common_{{ $slug }}">
                                                <div class="page-title">{{ ucfirst(str_replace('-', ' ', $slug)) }}</div>
                                                <div class="page-description">{{ $description }}</div>
                                            </label>
                                        </div>
                                        <div class="page-actions">
                                            <button type="button" 
                                                    class="btn btn-preview" 
                                                    onclick="previewPage('{{ $slug }}')"
                                                    title="Vista previa">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Páginas Especializadas -->
                        <div class="col-md-6">
                            <div class="pages-section specialized-pages">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-magic"></i>
                                    </div>
                                    <div class="section-content">
                                        <h5 class="section-title">Páginas Especializadas</h5>
                                        <p class="section-subtitle">Páginas específicas para este tipo de sitio web</p>
                                    </div>
                                </div>
                                <div class="pages-list">
                                    @foreach($categoryData['specialized_pages'] as $slug => $description)
                                    <div class="page-item">
                                        <div class="page-checkbox">
                                            <input class="form-check-input page-checkbox" 
                                                   type="checkbox" 
                                                   value="{{ $slug }}" 
                                                   id="specialized_{{ $slug }}"
                                                   data-type="specialized">
                                        </div>
                                        <div class="page-content">
                                            <label class="page-label" for="specialized_{{ $slug }}">
                                                <div class="page-title">{{ ucfirst(str_replace('-', ' ', $slug)) }}</div>
                                                <div class="page-description">{{ $description }}</div>
                                            </label>
                                        </div>
                                        <div class="page-actions">
                                            <button type="button" 
                                                    class="btn btn-preview" 
                                                    onclick="previewPage('{{ $slug }}')"
                                                    title="Vista previa">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Controles -->
                    <div class="import-controls">
                        <div class="controls-left">
                            <button type="button" class="btn btn-control" id="selectAll">
                                <i class="fas fa-check-square me-2"></i>
                                Seleccionar Todas
                            </button>
                            <button type="button" class="btn btn-control" id="selectNone">
                                <i class="fas fa-square me-2"></i>
                                Deseleccionar Todas
                            </button>
                            <button type="button" class="btn btn-control" id="selectCommon">
                                <i class="fas fa-star me-2"></i>
                                Solo Esenciales
                            </button>
                        </div>
                        <div class="controls-right">
                            <div class="selection-info">
                                <span class="selection-count">
                                    <span id="selectedCount">0</span> páginas seleccionadas
                                </span>
                            </div>
                            <button type="submit" class="btn btn-import" id="importBtn" disabled>
                                <i class="fas fa-download me-2"></i>
                                Importar Páginas
                            </button>
                        </div>
                    </div>
                </form>
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
                <p>¿Estás seguro de que quieres importar <span id="confirmCount">0</span> páginas?</p>
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
function previewPage(pageSlug) {
    const previewUrl = '{{ route("creator.pages.preview", ["website" => $website->id, "pageSlug" => ":pageSlug"]) }}'.replace(':pageSlug', pageSlug);
    window.open(previewUrl, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.page-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const importBtn = document.getElementById('importBtn');
    const selectAllBtn = document.getElementById('selectAll');
    const selectNoneBtn = document.getElementById('selectNone');
    const selectCommonBtn = document.getElementById('selectCommon');
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

    // Seleccionar solo esenciales
    selectCommonBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkbox.dataset.type === 'common';
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
                pages: selected
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

@push('styles')
<style>
/* Variables CSS */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --purple-gradient: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
}

/* Header mejorado */
.bg-gradient-primary {
    background: var(--primary-gradient);
}

/* Sección de plantillas */
.templates-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 20px;
}

.templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.template-card {
    background: #f8f9ff;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.3s ease;
}

.template-card:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    text-decoration: none;
}

.template-icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

.template-name {
    font-weight: 500;
    font-size: 0.9rem;
}

/* Card de formulario */
.import-form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Secciones de páginas */
.pages-section {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;
}

.essential-pages {
    border-left: 4px solid #667eea;
}

.specialized-pages {
    border-left: 4px solid #48bb78;
}

.section-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.section-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.essential-pages .section-icon {
    background: var(--primary-gradient);
}

.specialized-pages .section-icon {
    background: var(--success-gradient);
}

.section-content {
    flex: 1;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
}

.section-subtitle {
    color: #718096;
    font-size: 0.9rem;
    margin: 0;
}

/* Lista de páginas */
.pages-list {
    padding: 20px;
}

.page-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 10px;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.page-item:hover {
    background: #f8f9ff;
    border-color: #e2e8f0;
}

.page-checkbox {
    margin-right: 15px;
}

.page-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
}

.page-content {
    flex: 1;
}

.page-label {
    cursor: pointer;
    margin: 0;
}

.page-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 5px;
}

.page-description {
    color: #718096;
    font-size: 0.9rem;
}

.page-actions {
    margin-left: 15px;
}

.btn-preview {
    background: #e2e8f0;
    border: none;
    color: #4a5568;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-preview:hover {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

/* Controles de importación */
.import-controls {
    background: #f8f9ff;
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.controls-left {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-control {
    background: white;
    border: 2px solid #e2e8f0;
    color: #4a5568;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-control:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-1px);
}

.controls-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.selection-info {
    text-align: right;
}

.selection-count {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 500;
}

.btn-import {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-import:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
}

.btn-import:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
    .import-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .controls-left {
        justify-content: center;
    }
    
    .controls-right {
        flex-direction: column;
        gap: 15px;
    }
    
    .templates-grid {
        grid-template-columns: 1fr;
    }
    
    .page-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .page-actions {
        margin-left: 0;
        align-self: flex-end;
    }
}
</style>
@endpush
