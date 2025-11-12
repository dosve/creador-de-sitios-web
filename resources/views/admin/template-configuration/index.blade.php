@extends('layouts.admin')

@section('title', 'Configuración de Plantillas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-palette mr-2"></i>
                        Configuración de Plantillas - {{ $website->name }}
                    </h3>
                    <a href="{{ route('admin.websites.show', $website) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Volver al Sitio
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        @forelse($templateConfigs as $config)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="card-title text-capitalize">
                                                {{ str_replace('-', ' ', $config->template_slug) }}
                                            </h5>
                                            <span class="badge badge-{{ $config->is_active ? 'success' : 'secondary' }}">
                                                {{ $config->is_active ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </div>
                                        
                                        <p class="card-text text-muted small">
                                            Última actualización: {{ $config->updated_at->diffForHumans() }}
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('admin.template-configuration.show', [$website, $config->template_slug]) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-cog mr-1"></i>
                                                Configurar
                                            </a>
                                            
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                        onclick="toggleActive({{ $config->id }})">
                                                    <i class="fas fa-{{ $config->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                
                                                <button type="button" class="btn btn-outline-warning btn-sm" 
                                                        onclick="resetConfig('{{ $config->template_slug }}')">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-palette fa-3x text-muted mb-3"></i>
                                    <h4 class="text-muted">No hay configuraciones de plantillas</h4>
                                    <p class="text-muted">Las configuraciones se crean automáticamente cuando accedes a una plantilla.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para reset -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Reset</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres resetear la configuración de esta plantilla a los valores por defecto?
                <strong>Esta acción no se puede deshacer.</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="confirmReset">Resetear</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let resetTemplateSlug = null;

function toggleActive(configId) {
    // Implementar toggle de activación
    console.log('Toggle active for config:', configId);
}

function resetConfig(templateSlug) {
    resetTemplateSlug = templateSlug;
    $('#resetModal').modal('show');
}

$('#confirmReset').click(function() {
    if (resetTemplateSlug) {
        window.location.href = `{{ route('admin.template-configuration.reset', [$website, '']) }}/${resetTemplateSlug}`;
    }
});
</script>
@endsection
