@extends('layouts.admin')

@section('title', 'Configuración de Plantilla')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-cog mr-2"></i>
                        Configuración - {{ ucfirst(str_replace('-', ' ', $templateConfig->template_slug)) }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.template-configuration.index', $website) }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Volver
                        </a>
                        <button type="button" class="btn btn-warning" onclick="resetConfig()">
                            <i class="fas fa-undo mr-1"></i>
                            Resetear
                        </button>
                    </div>
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

                    <!-- Pestañas de configuración -->
                    <ul class="nav nav-tabs" id="configTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">
                                <i class="fas fa-cog mr-1"></i>
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="appearance-tab" data-toggle="tab" href="#appearance" role="tab">
                                <i class="fas fa-palette mr-1"></i>
                                Apariencia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="layout-tab" data-toggle="tab" href="#layout" role="tab">
                                <i class="fas fa-th mr-1"></i>
                                Diseño
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab">
                                <i class="fas fa-edit mr-1"></i>
                                Contenido
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-4" id="configTabsContent">
                        <!-- Pestaña General -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <form id="generalForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_name">Nombre del Sitio</label>
                                            <input type="text" class="form-control" id="site_name" name="site_name" 
                                                   value="{{ $website->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_description">Descripción</label>
                                            <input type="text" class="form-control" id="site_description" name="site_description" 
                                                   value="{{ $website->description }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">Logo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label" for="logo">Seleccionar logo</label>
                                            </div>
                                            @if($website->logo)
                                                <small class="form-text text-muted">
                                                    Logo actual: <a href="{{ asset('storage/' . $website->logo) }}" target="_blank">Ver</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="favicon">Favicon</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                                <label class="custom-file-label" for="favicon">Seleccionar favicon</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_email">Email de Contacto</label>
                                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                                   value="{{ $templateConfig->settings['contact_email'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_phone">Teléfono</label>
                                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                                   value="{{ $templateConfig->settings['contact_phone'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Guardar Configuración General
                                </button>
                            </form>
                        </div>

                        <!-- Pestaña Apariencia -->
                        <div class="tab-pane fade" id="appearance" role="tabpanel">
                            <form id="appearanceForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Colores</h5>
                                        <div class="form-group">
                                            <label for="primary_color">Color Primario</label>
                                            <input type="color" class="form-control" id="primary_color" name="colors[primary]" 
                                                   value="{{ $templateConfig->customization['colors']['primary'] ?? '#3b82f6' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="secondary_color">Color Secundario</label>
                                            <input type="color" class="form-control" id="secondary_color" name="colors[secondary]" 
                                                   value="{{ $templateConfig->customization['colors']['secondary'] ?? '#1f2937' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="accent_color">Color de Acento</label>
                                            <input type="color" class="form-control" id="accent_color" name="colors[accent]" 
                                                   value="{{ $templateConfig->customization['colors']['accent'] ?? '#10b981' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Fuentes</h5>
                                        <div class="form-group">
                                            <label for="heading_font">Fuente de Títulos</label>
                                            <select class="form-control" id="heading_font" name="fonts[heading]">
                                                <option value="Inter, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                                <option value="Poppins, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                                <option value="Raleway, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Raleway, sans-serif' ? 'selected' : '' }}>Raleway</option>
                                                <option value="Montserrat, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Montserrat, sans-serif' ? 'selected' : '' }}>Montserrat</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="body_font">Fuente del Cuerpo</label>
                                            <select class="form-control" id="body_font" name="fonts[body]">
                                                <option value="Inter, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                                <option value="Open Sans, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                                                <option value="Nunito, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                                                <option value="Roboto, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-palette mr-1"></i>
                                    Guardar Apariencia
                                </button>
                            </form>
                        </div>

                        <!-- Pestaña Diseño -->
                        <div class="tab-pane fade" id="layout" role="tabpanel">
                            <form id="layoutForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="container_width">Ancho del Contenedor</label>
                                            <select class="form-control" id="container_width" name="layout[container_width]">
                                                <option value="1200px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1200px' ? 'selected' : '' }}>1200px (Estándar)</option>
                                                <option value="1280px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1280px' ? 'selected' : '' }}>1280px (Ancho)</option>
                                                <option value="1000px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1000px' ? 'selected' : '' }}>1000px (Estrecho)</option>
                                                <option value="100%" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '100%' ? 'selected' : '' }}>100% (Completo)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="header_style">Estilo del Header</label>
                                            <select class="form-control" id="header_style" name="layout[header_style]">
                                                <option value="fixed" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'fixed' ? 'selected' : '' }}>Fijo</option>
                                                <option value="static" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'static' ? 'selected' : '' }}>Estático</option>
                                                <option value="transparent" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'transparent' ? 'selected' : '' }}>Transparente</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-th mr-1"></i>
                                    Guardar Diseño
                                </button>
                            </form>
                        </div>

                        <!-- Pestaña Contenido -->
                        <div class="tab-pane fade" id="content" role="tabpanel">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                La configuración de contenido específico de cada plantilla se puede personalizar desde el editor de páginas.
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Redes Sociales</h5>
                                    <div class="form-group">
                                        <label for="facebook">Facebook</label>
                                        <input type="url" class="form-control" id="facebook" name="social_media[facebook]" 
                                               value="{{ $templateConfig->settings['social_media']['facebook'] ?? '' }}" 
                                               placeholder="https://facebook.com/tu-pagina">
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter">Twitter</label>
                                        <input type="url" class="form-control" id="twitter" name="social_media[twitter]" 
                                               value="{{ $templateConfig->settings['social_media']['twitter'] ?? '' }}" 
                                               placeholder="https://twitter.com/tu-usuario">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram">Instagram</label>
                                        <input type="url" class="form-control" id="instagram" name="social_media[instagram]" 
                                               value="{{ $templateConfig->settings['social_media']['instagram'] ?? '' }}" 
                                               placeholder="https://instagram.com/tu-usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="linkedin">LinkedIn</label>
                                        <input type="url" class="form-control" id="linkedin" name="social_media[linkedin]" 
                                               value="{{ $templateConfig->settings['social_media']['linkedin'] ?? '' }}" 
                                               placeholder="https://linkedin.com/in/tu-perfil">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary" onclick="saveSocialMedia()">
                                <i class="fas fa-share-alt mr-1"></i>
                                Guardar Redes Sociales
                            </button>
                        </div>
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
                <button type="button" class="btn btn-warning" onclick="confirmReset()">Resetear</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Manejo de formularios
$('#generalForm').on('submit', function(e) {
    e.preventDefault();
    saveGeneralSettings();
});

$('#appearanceForm').on('submit', function(e) {
    e.preventDefault();
    saveAppearanceSettings();
});

$('#layoutForm').on('submit', function(e) {
    e.preventDefault();
    saveLayoutSettings();
});

function saveGeneralSettings() {
    const formData = new FormData(document.getElementById('generalForm'));
    
    fetch(`{{ route('admin.template-configuration.update-settings', [$website, $templateConfig->template_slug]) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar la configuración');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar la configuración');
    });
}

function saveAppearanceSettings() {
    const formData = new FormData(document.getElementById('appearanceForm'));
    
    fetch(`{{ route('admin.template-configuration.update-customization', [$website, $templateConfig->template_slug]) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar la apariencia');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar la apariencia');
    });
}

function saveLayoutSettings() {
    const formData = new FormData(document.getElementById('layoutForm'));
    
    fetch(`{{ route('admin.template-configuration.update-customization', [$website, $templateConfig->template_slug]) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar el diseño');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar el diseño');
    });
}

function saveSocialMedia() {
    const socialData = {
        social_media: {
            facebook: document.getElementById('facebook').value,
            twitter: document.getElementById('twitter').value,
            instagram: document.getElementById('instagram').value,
            linkedin: document.getElementById('linkedin').value
        }
    };
    
    fetch(`{{ route('admin.template-configuration.update-settings', [$website, $templateConfig->template_slug]) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(socialData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar las redes sociales');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar las redes sociales');
    });
}

function resetConfig() {
    $('#resetModal').modal('show');
}

function confirmReset() {
    window.location.href = `{{ route('admin.template-configuration.reset', [$website, $templateConfig->template_slug]) }}`;
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    // Insertar alerta al inicio del card-body
    const cardBody = document.querySelector('.card-body');
    cardBody.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        const alert = cardBody.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Actualizar labels de archivos
document.querySelectorAll('.custom-file-input').forEach(input => {
    input.addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.files[0] ? this.files[0].name : 'Seleccionar archivo';
    });
});
</script>
@endsection
