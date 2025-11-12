@extends('layouts.creator')

@section('title', 'Importar Páginas por Categoría')

@section('content')
<div class="container-fluid">
    <!-- Header mejorado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-gradient-primary rounded-circle p-3 me-3">
                    <i class="fas fa-magic fa-2x text-white"></i>
                </div>
                <div>
                    <h2 class="mb-1 text-dark fw-bold">Importar Páginas por Categoría</h2>
                    <p class="text-muted mb-0">Selecciona el tipo de sitio web para ver las páginas disponibles</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorías con diseño mejorado -->
    <div class="row">
        @foreach($categories as $key => $category)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="category-card h-100" data-category="{{ $key }}">
                <div class="category-icon">
                    @switch($key)
                        @case('ecommerce')
                            <i class="fas fa-shopping-cart"></i>
                            @break
                        @case('business')
                            <i class="fas fa-briefcase"></i>
                            @break
                        @case('health')
                            <i class="fas fa-heartbeat"></i>
                            @break
                        @case('education')
                            <i class="fas fa-graduation-cap"></i>
                            @break
                        @case('creative')
                            <i class="fas fa-palette"></i>
                            @break
                        @case('events')
                            <i class="fas fa-calendar-alt"></i>
                            @break
                        @default
                            <i class="fas fa-globe"></i>
                    @endswitch
                </div>
                <div class="category-content">
                    <h4 class="category-title">{{ $category['name'] }}</h4>
                    <div class="category-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt"></i>
                            <span>{{ count($category['common_pages']) + count($category['specialized_pages']) }} páginas</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-puzzle-piece"></i>
                            <span>{{ count($category['templates']) }} plantillas</span>
                        </div>
                    </div>
                    <div class="category-actions">
                        <a href="{{ route('creator.pages.import.category', ['website' => $website->id, 'category' => $key]) }}" 
                           class="btn btn-gradient-primary">
                            <i class="fas fa-eye me-2"></i>
                            Ver Páginas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Información adicional -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="info-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">💡 Consejo</h5>
                        <p class="mb-0 text-muted">
                            Cada categoría incluye páginas esenciales y especializadas. 
                            Puedes previsualizar cualquier página antes de importarla.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <i class="fas fa-lightbulb fa-3x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Card de categoría */
.category-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover::before {
    opacity: 1;
}

/* Icono de categoría */
.category-icon {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.category-icon i {
    font-size: 3.5rem;
    color: white;
    z-index: 2;
    position: relative;
}

.category-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--primary-gradient);
    opacity: 0.9;
}

/* Colores específicos por categoría */
.category-card[data-category="ecommerce"] .category-icon::before {
    background: var(--primary-gradient);
}

.category-card[data-category="business"] .category-icon::before {
    background: var(--success-gradient);
}

.category-card[data-category="health"] .category-icon::before {
    background: var(--danger-gradient);
}

.category-card[data-category="education"] .category-icon::before {
    background: var(--warning-gradient);
}

.category-card[data-category="creative"] .category-icon::before {
    background: var(--info-gradient);
}

.category-card[data-category="events"] .category-icon::before {
    background: var(--purple-gradient);
}

/* Contenido de categoría */
.category-content {
    padding: 30px 25px;
    text-align: center;
}

.category-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 20px;
}

.category-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 25px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.stat-item i {
    color: #667eea;
    font-size: 1.2rem;
}

.stat-item span {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
}

/* Botón de acción */
.btn-gradient-primary {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    color: white;
    text-decoration: none;
}

/* Card de información */
.info-card {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    border-radius: 15px;
    padding: 30px;
    border-left: 4px solid #667eea;
}

/* Header mejorado */
.bg-gradient-primary {
    background: var(--primary-gradient);
}

/* Responsive */
@media (max-width: 768px) {
    .category-stats {
        flex-direction: column;
        gap: 15px;
    }
    
    .category-content {
        padding: 25px 20px;
    }
    
    .category-icon {
        height: 100px;
    }
    
    .category-icon i {
        font-size: 2.5rem;
    }
}
</style>
@endpush
