<!-- Modal de Navegación de Páginas Simplificado -->
<div class="modal fade" id="pagesNavigationModal" tabindex="-1" aria-labelledby="pagesNavigationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pagesNavigationModalLabel">
                    <i class="fas fa-compass me-2"></i>
                    Navegador de Páginas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Filtros -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="pageSearch" placeholder="Buscar páginas...">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Todas las categorías</option>
                            <option value="ecommerce">🛒 Tiendas Online</option>
                            <option value="business">💼 Negocios y Servicios</option>
                            <option value="health">🏥 Salud y Bienestar</option>
                            <option value="education">🎓 Educación</option>
                            <option value="creative">🎨 Creativos y Portfolio</option>
                            <option value="events">🎪 Eventos y Entretenimiento</option>
                        </select>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="row mb-4 text-center">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id="totalPages">0</h5>
                                <p class="card-text">Total Páginas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id="filteredPages">0</h5>
                                <p class="card-text">Mostradas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id="selectedPages">0</h5>
                                <p class="card-text">Seleccionadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">6</h5>
                                <p class="card-text">Categorías</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de páginas -->
                <div class="row" id="pagesGrid">
                    <!-- Las páginas se cargarán aquí -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="importSelectedPages">Importar Seleccionadas</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Datos de páginas estáticos
const allPages = [
    // E-commerce
    { slug: 'inicio', title: 'Inicio', description: 'Página principal de la tienda', category: 'ecommerce', type: 'common' },
    { slug: 'productos', title: 'Productos', description: 'Catálogo de productos', category: 'ecommerce', type: 'common' },
    { slug: 'categorias', title: 'Categorías', description: 'Categorías de productos', category: 'ecommerce', type: 'specialized' },
    { slug: 'carrito', title: 'Carrito', description: 'Carrito de compras', category: 'ecommerce', type: 'specialized' },
    { slug: 'checkout', title: 'Checkout', description: 'Proceso de compra', category: 'ecommerce', type: 'specialized' },
    { slug: 'ofertas', title: 'Ofertas', description: 'Página de ofertas especiales', category: 'ecommerce', type: 'specialized' },
    
    // Business
    { slug: 'servicios', title: 'Servicios', description: 'Nuestros servicios', category: 'business', type: 'common' },
    { slug: 'sobre-nosotros', title: 'Sobre Nosotros', description: 'Información de la empresa', category: 'business', type: 'common' },
    { slug: 'contacto', title: 'Contacto', description: 'Información de contacto', category: 'business', type: 'common' },
    { slug: 'equipo', title: 'Equipo', description: 'Nuestro equipo de trabajo', category: 'business', type: 'specialized' },
    { slug: 'testimonios', title: 'Testimonios', description: 'Testimonios de clientes', category: 'business', type: 'specialized' },
    
    // Health
    { slug: 'especialidades', title: 'Especialidades', description: 'Especialidades médicas', category: 'health', type: 'specialized' },
    { slug: 'doctores', title: 'Doctores', description: 'Equipo médico', category: 'health', type: 'specialized' },
    { slug: 'citas', title: 'Citas', description: 'Agendar cita médica', category: 'health', type: 'specialized' },
    
    // Education
    { slug: 'cursos', title: 'Cursos', description: 'Catálogo de cursos', category: 'education', type: 'specialized' },
    { slug: 'instructores', title: 'Instructores', description: 'Nuestros instructores', category: 'education', type: 'specialized' },
    
    // Creative
    { slug: 'portfolio', title: 'Portfolio', description: 'Nuestro trabajo', category: 'creative', type: 'specialized' },
    { slug: 'galeria', title: 'Galería', description: 'Galería de trabajos', category: 'creative', type: 'specialized' },
    
    // Events
    { slug: 'eventos', title: 'Eventos', description: 'Próximos eventos', category: 'events', type: 'specialized' },
    { slug: 'reservas', title: 'Reservas', description: 'Reservar entrada', category: 'events', type: 'specialized' }
];

let filteredPages = [...allPages];
let selectedPages = new Set();

// Elementos del DOM
let searchInput, categoryFilter, pagesGrid, totalPagesSpan, filteredPagesSpan, selectedPagesSpan, importSelectedBtn;

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando navegador de páginas...');
    
    // Obtener elementos del DOM
    searchInput = document.getElementById('pageSearch');
    categoryFilter = document.getElementById('categoryFilter');
    pagesGrid = document.getElementById('pagesGrid');
    totalPagesSpan = document.getElementById('totalPages');
    filteredPagesSpan = document.getElementById('filteredPages');
    selectedPagesSpan = document.getElementById('selectedPages');
    importSelectedBtn = document.getElementById('importSelectedPages');
    
    // Inicializar
    updateStats();
    renderPages();
    
    // Event listeners
    if (searchInput) {
        searchInput.addEventListener('input', filterPages);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterPages);
    }
    if (importSelectedBtn) {
        importSelectedBtn.addEventListener('click', importSelected);
    }
});

// Filtrar páginas
function filterPages() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter.value;

    filteredPages = allPages.filter(page => {
        const matchesSearch = page.title.toLowerCase().includes(searchTerm) ||
                            page.description.toLowerCase().includes(searchTerm);
        const matchesCategory = !selectedCategory || page.category === selectedCategory;
        
        return matchesSearch && matchesCategory;
    });

    updateStats();
    renderPages();
}

// Renderizar páginas
function renderPages() {
    console.log('Renderizando páginas...', filteredPages.length);
    
    if (!pagesGrid) return;
    
    pagesGrid.innerHTML = '';

    if (filteredPages.length === 0) {
        pagesGrid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    No se encontraron páginas con los filtros aplicados.
                </div>
            </div>
        `;
        return;
    }

    filteredPages.forEach(page => {
        const isSelected = selectedPages.has(page.slug);
        const categoryIcon = getCategoryIcon(page.category);
        
        const pageCard = document.createElement('div');
        pageCard.className = 'col-md-6 col-lg-4 mb-3';
        pageCard.innerHTML = `
            <div class="card h-100 ${isSelected ? 'border-primary' : ''}" onclick="togglePageSelection('${page.slug}')">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3">
                            <i class="${categoryIcon} fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0">${page.title}</h6>
                            <small class="text-muted">${getCategoryName(page.category)}</small>
                        </div>
                    </div>
                    <p class="card-text">${page.description}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge ${page.type === 'common' ? 'bg-primary' : 'bg-success'}">${page.type === 'common' ? 'Esencial' : 'Especializada'}</span>
                        <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); previewPage('${page.slug}')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        pagesGrid.appendChild(pageCard);
    });
}

// Obtener icono de categoría
function getCategoryIcon(category) {
    const icons = {
        'ecommerce': 'fas fa-shopping-cart',
        'business': 'fas fa-briefcase',
        'health': 'fas fa-heartbeat',
        'education': 'fas fa-graduation-cap',
        'creative': 'fas fa-palette',
        'events': 'fas fa-calendar-alt'
    };
    return icons[category] || 'fas fa-globe';
}

// Obtener nombre de categoría
function getCategoryName(category) {
    const names = {
        'ecommerce': '🛒 Tiendas Online',
        'business': '💼 Negocios y Servicios',
        'health': '🏥 Salud y Bienestar',
        'education': '🎓 Educación',
        'creative': '🎨 Creativos y Portfolio',
        'events': '🎪 Eventos y Entretenimiento'
    };
    return names[category] || '🌐 General';
}

// Alternar selección de página
function togglePageSelection(slug) {
    if (selectedPages.has(slug)) {
        selectedPages.delete(slug);
    } else {
        selectedPages.add(slug);
    }
    updateStats();
    renderPages();
}

// Vista previa de página
function previewPage(slug) {
    const previewUrl = `/creator/pages/preview/{{ $website->id }}/${slug}`;
    window.open(previewUrl, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}

// Actualizar estadísticas
function updateStats() {
    if (totalPagesSpan) totalPagesSpan.textContent = allPages.length;
    if (filteredPagesSpan) filteredPagesSpan.textContent = filteredPages.length;
    if (selectedPagesSpan) selectedPagesSpan.textContent = selectedPages.size;
}

// Importar páginas seleccionadas
function importSelected() {
    if (selectedPages.size === 0) {
        alert('Por favor selecciona al menos una página para importar.');
        return;
    }

    const selectedArray = Array.from(selectedPages);
    console.log('Páginas seleccionadas para importar:', selectedArray);
    
    alert(`Se importarán ${selectedArray.length} páginas seleccionadas.`);
    
    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('pagesNavigationModal'));
    if (modal) {
        modal.hide();
    }
}
</script>
@endpush