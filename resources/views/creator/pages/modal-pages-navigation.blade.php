<!-- Modal de Navegación de Páginas -->
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
                <!-- Filtros y búsqueda -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="search-box">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="pageSearch" placeholder="Buscar páginas...">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="filter-box">
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
                </div>

                <!-- Estadísticas -->
                <div class="stats-bar mb-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number" id="totalPages">0</div>
                                <div class="stat-label">Total Páginas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number" id="filteredPages">0</div>
                                <div class="stat-label">Mostradas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number" id="selectedPages">0</div>
                                <div class="stat-label">Seleccionadas</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number" id="categoriesCount">6</div>
                                <div class="stat-label">Categorías</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de páginas -->
                <div class="pages-container">
                    <div class="row" id="pagesGrid">
                        <!-- Indicador de carga -->
                        <div class="col-12 text-center py-5" id="loadingIndicator">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-3 text-muted">Cargando páginas disponibles...</p>
                        </div>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="pagination-container mt-4">
                    <nav aria-label="Paginación de páginas">
                        <ul class="pagination justify-content-center" id="pagesPagination">
                            <!-- La paginación se generará dinámicamente -->
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div class="selection-actions">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="selectAllPages">
                            <i class="fas fa-check-square me-1"></i>
                            Seleccionar Todas
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelection">
                            <i class="fas fa-square me-1"></i>
                            Limpiar
                        </button>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-primary" id="importSelectedPages">
                            <i class="fas fa-download me-1"></i>
                            Importar Seleccionadas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Vista Previa de Página -->
<div class="modal fade" id="pagePreviewModal" tabindex="-1" aria-labelledby="pagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pagePreviewModalLabel">
                    <i class="fas fa-eye me-2"></i>
                    Vista Previa de Página
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pagePreviewContent">
                <!-- El contenido de la vista previa se cargará aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cerrar
                </button>
                <button type="button" class="btn btn-success" id="importThisPage">
                    <i class="fas fa-download me-1"></i>
                    Importar Esta Página
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el modal de navegación */
.modal-xl {
    max-width: 95vw;
}

.search-box .input-group-text {
    background: #f8f9ff;
    border-color: #e2e8f0;
    color: #667eea;
}

.search-box .form-control {
    border-color: #e2e8f0;
}

.search-box .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.filter-box .form-select {
    border-color: #e2e8f0;
}

.filter-box .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.stats-bar {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    border-radius: 15px;
    padding: 20px;
    border: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
}

.pages-container {
    max-height: 500px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #fafbfc;
}

.page-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.page-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.page-card.selected {
    border-color: #667eea;
    background: #f8f9ff;
}

.page-card.selected::before {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    background: #667eea;
    color: white;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.page-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.page-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 1.2rem;
    color: white;
}

.page-icon.ecommerce { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.page-icon.business { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.page-icon.health { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.page-icon.education { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
.page-icon.creative { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
.page-icon.events { background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%); }

.page-info h6 {
    margin: 0;
    font-weight: 600;
    color: #2d3748;
}

.page-category {
    font-size: 0.8rem;
    color: #718096;
    margin-top: 2px;
}

.page-description {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.4;
}

.page-actions {
    display: flex;
    gap: 10px;
}

.btn-page-action {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    border: none;
    transition: all 0.2s ease;
}

.btn-preview {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-preview:hover {
    background: #667eea;
    color: white;
}

.btn-select {
    background: #667eea;
    color: white;
}

.btn-select:hover {
    background: #5a67d8;
}

.btn-selected {
    background: #48bb78;
    color: white;
}

.btn-selected:hover {
    background: #38a169;
}

.pagination-container .pagination {
    margin: 0;
}

.pagination .page-link {
    color: #667eea;
    border-color: #e2e8f0;
}

.pagination .page-link:hover {
    color: #5a67d8;
    background-color: #f8f9ff;
    border-color: #667eea;
}

.pagination .page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
}

.selection-actions .btn {
    margin-right: 10px;
}

.modal-actions .btn {
    margin-left: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .modal-xl {
        max-width: 95vw;
        margin: 10px;
    }
    
    .stats-bar .row {
        gap: 10px;
    }
    
    .stat-item {
        margin-bottom: 15px;
    }
    
    .page-actions {
        flex-direction: column;
    }
    
    .modal-footer .d-flex {
        flex-direction: column;
        gap: 15px;
    }
    
    .selection-actions,
    .modal-actions {
        width: 100%;
        display: flex;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allPages = [];
    let filteredPages = [];
    let selectedPages = new Set();
    let currentPage = 1;
    const itemsPerPage = 12;

    // Elementos del DOM
    const searchInput = document.getElementById('pageSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const pagesGrid = document.getElementById('pagesGrid');
    const totalPagesSpan = document.getElementById('totalPages');
    const filteredPagesSpan = document.getElementById('filteredPages');
    const selectedPagesSpan = document.getElementById('selectedPages');
    const selectAllBtn = document.getElementById('selectAllPages');
    const clearSelectionBtn = document.getElementById('clearSelection');
    const importSelectedBtn = document.getElementById('importSelectedPages');

    // Cargar todas las páginas al abrir el modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('pagesNavigationModal');
        if (modal) {
            modal.addEventListener('show.bs.modal', function() {
                console.log('Modal abierto, cargando páginas...');
                // Mostrar indicador de carga
                document.getElementById('loadingIndicator').style.display = 'block';
                // Cargar páginas estáticas directamente
                loadStaticPages();
            });
        }
    });

    // Cargar todas las páginas disponibles
    async function loadAllPages() {
        try {
            console.log('Cargando páginas...');
            
            // Intentar cargar desde la API primero
            try {
                const response = await fetch('/creator/api/pages/all-available');
                console.log('Respuesta recibida:', response);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Datos recibidos:', data);
                    
                    if (data.success) {
                        allPages = data.pages || [];
                        filteredPages = [...allPages];
                        console.log('Páginas cargadas desde API:', allPages.length);
                        
                        // Ocultar indicador de carga
                        document.getElementById('loadingIndicator').style.display = 'none';
                        
                        updateStats();
                        renderPages();
                        return;
                    }
                }
            } catch (apiError) {
                console.log('Error con API, usando datos estáticos:', apiError);
            }
            
            // Si la API falla, usar datos estáticos
            loadStaticPages();
            
        } catch (error) {
            console.error('Error loading pages:', error);
            document.getElementById('loadingIndicator').style.display = 'none';
            showError('Error de conexión: ' + error.message);
        }
    }

    // Cargar páginas estáticas como fallback
    function loadStaticPages() {
        console.log('Cargando páginas estáticas...');
        
        allPages = [
            // E-commerce
            { slug: 'inicio', title: 'Inicio', description: 'Página principal de la tienda', category: 'ecommerce', type: 'common', category_name: 'Tiendas Online' },
            { slug: 'productos', title: 'Productos', description: 'Catálogo de productos', category: 'ecommerce', type: 'common', category_name: 'Tiendas Online' },
            { slug: 'categorias', title: 'Categorías', description: 'Categorías de productos', category: 'ecommerce', type: 'specialized', category_name: 'Tiendas Online' },
            { slug: 'carrito', title: 'Carrito', description: 'Carrito de compras', category: 'ecommerce', type: 'specialized', category_name: 'Tiendas Online' },
            { slug: 'checkout', title: 'Checkout', description: 'Proceso de compra', category: 'ecommerce', type: 'specialized', category_name: 'Tiendas Online' },
            { slug: 'ofertas', title: 'Ofertas', description: 'Página de ofertas especiales', category: 'ecommerce', type: 'specialized', category_name: 'Tiendas Online' },
            
            // Business
            { slug: 'servicios', title: 'Servicios', description: 'Nuestros servicios', category: 'business', type: 'common', category_name: 'Negocios y Servicios' },
            { slug: 'sobre-nosotros', title: 'Sobre Nosotros', description: 'Información de la empresa', category: 'business', type: 'common', category_name: 'Negocios y Servicios' },
            { slug: 'contacto', title: 'Contacto', description: 'Información de contacto', category: 'business', type: 'common', category_name: 'Negocios y Servicios' },
            { slug: 'equipo', title: 'Equipo', description: 'Nuestro equipo de trabajo', category: 'business', type: 'specialized', category_name: 'Negocios y Servicios' },
            { slug: 'testimonios', title: 'Testimonios', description: 'Testimonios de clientes', category: 'business', type: 'specialized', category_name: 'Negocios y Servicios' },
            
            // Health
            { slug: 'especialidades', title: 'Especialidades', description: 'Especialidades médicas', category: 'health', type: 'specialized', category_name: 'Salud y Bienestar' },
            { slug: 'doctores', title: 'Doctores', description: 'Equipo médico', category: 'health', type: 'specialized', category_name: 'Salud y Bienestar' },
            { slug: 'citas', title: 'Citas', description: 'Agendar cita médica', category: 'health', type: 'specialized', category_name: 'Salud y Bienestar' },
            
            // Education
            { slug: 'cursos', title: 'Cursos', description: 'Catálogo de cursos', category: 'education', type: 'specialized', category_name: 'Educación' },
            { slug: 'instructores', title: 'Instructores', description: 'Nuestros instructores', category: 'education', type: 'specialized', category_name: 'Educación' },
            
            // Creative
            { slug: 'portfolio', title: 'Portfolio', description: 'Nuestro trabajo', category: 'creative', type: 'specialized', category_name: 'Creativos y Portfolio' },
            { slug: 'galeria', title: 'Galería', description: 'Galería de trabajos', category: 'creative', type: 'specialized', category_name: 'Creativos y Portfolio' },
            
            // Events
            { slug: 'eventos', title: 'Eventos', description: 'Próximos eventos', category: 'events', type: 'specialized', category_name: 'Eventos y Entretenimiento' },
            { slug: 'reservas', title: 'Reservas', description: 'Reservar entrada', category: 'events', type: 'specialized', category_name: 'Eventos y Entretenimiento' }
        ];
        
        filteredPages = [...allPages];
        console.log('Páginas estáticas cargadas:', allPages.length);
        
        // Ocultar indicador de carga
        document.getElementById('loadingIndicator').style.display = 'none';
        
        updateStats();
        renderPages();
    }

    // Mostrar error
    function showError(message) {
        pagesGrid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${message}
                </div>
            </div>
        `;
    }

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

        currentPage = 1;
        updateStats();
        renderPages();
    }

    // Renderizar páginas
    function renderPages() {
        console.log('Renderizando páginas...', filteredPages.length);
        
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pagesToShow = filteredPages.slice(startIndex, endIndex);

        console.log('Páginas a mostrar:', pagesToShow.length);

        pagesGrid.innerHTML = '';

        if (pagesToShow.length === 0) {
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

        pagesToShow.forEach(page => {
            const pageCard = createPageCard(page);
            pagesGrid.appendChild(pageCard);
        });

        renderPagination();
    }

    // Crear tarjeta de página
    function createPageCard(page) {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4';

        const isSelected = selectedPages.has(page.slug);
        const categoryIcon = getCategoryIcon(page.category);

        col.innerHTML = `
            <div class="page-card ${isSelected ? 'selected' : ''}" data-page-slug="${page.slug}">
                <div class="page-header">
                    <div class="page-icon ${page.category}">
                        <i class="${categoryIcon}"></i>
                    </div>
                    <div class="page-info">
                        <h6>${page.title}</h6>
                        <div class="page-category">${getCategoryName(page.category)}</div>
                    </div>
                </div>
                <div class="page-description">${page.description}</div>
                <div class="page-actions">
                    <button class="btn-page-action btn-preview" onclick="previewPageInModal('${page.slug}', '${page.category}')">
                        <i class="fas fa-eye me-1"></i>
                        Vista Previa
                    </button>
                    <button class="btn-page-action ${isSelected ? 'btn-selected' : 'btn-select'}" 
                            onclick="togglePageSelection('${page.slug}')">
                        <i class="fas fa-${isSelected ? 'check' : 'plus'} me-1"></i>
                        ${isSelected ? 'Seleccionada' : 'Seleccionar'}
                    </button>
                </div>
            </div>
        `;

        return col;
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

    // Renderizar paginación
    function renderPagination() {
        const totalPages = Math.ceil(filteredPages.length / itemsPerPage);
        const pagination = document.getElementById('pagesPagination');
        
        if (totalPages <= 1) {
            pagination.innerHTML = '';
            return;
        }

        let paginationHTML = '';
        
        // Botón anterior
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Anterior</a>
            </li>
        `;

        // Números de página
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Botón siguiente
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Siguiente</a>
            </li>
        `;

        pagination.innerHTML = paginationHTML;
    }

    // Cambiar página
    window.changePage = function(page) {
        const totalPages = Math.ceil(filteredPages.length / itemsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderPages();
        }
    };

    // Actualizar estadísticas
    function updateStats() {
        totalPagesSpan.textContent = allPages.length;
        filteredPagesSpan.textContent = filteredPages.length;
        selectedPagesSpan.textContent = selectedPages.size;
    }

    // Alternar selección de página
    window.togglePageSelection = function(slug) {
        if (selectedPages.has(slug)) {
            selectedPages.delete(slug);
        } else {
            selectedPages.add(slug);
        }
        updateStats();
        renderPages();
    };

    // Vista previa de página en modal
    window.previewPageInModal = function(slug, category) {
        // Cerrar modal de navegación
        const modal = bootstrap.Modal.getInstance(document.getElementById('pagesNavigationModal'));
        if (modal) {
            modal.hide();
        }
        
        // Abrir modal de vista previa
        setTimeout(() => {
            const previewUrl = `/creator/pages/preview/{{ $website->id }}/${slug}`;
            window.open(previewUrl, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
        }, 300);
    };

    // Seleccionar todas las páginas
    selectAllBtn.addEventListener('click', function() {
        filteredPages.forEach(page => {
            selectedPages.add(page.slug);
        });
        updateStats();
        renderPages();
    });

    // Limpiar selección
    clearSelectionBtn.addEventListener('click', function() {
        selectedPages.clear();
        updateStats();
        renderPages();
    });

    // Importar páginas seleccionadas
    importSelectedBtn.addEventListener('click', function() {
        if (selectedPages.size === 0) {
            alert('Por favor selecciona al menos una página para importar.');
            return;
        }

        const selectedArray = Array.from(selectedPages);
        
        // Aquí puedes implementar la lógica de importación
        console.log('Páginas seleccionadas para importar:', selectedArray);
        
        // Por ahora, mostramos un mensaje
        alert(`Se importarán ${selectedArray.length} páginas seleccionadas.`);
        
        // Cerrar modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('pagesNavigationModal'));
        if (modal) {
            modal.hide();
        }
    });

    // Event listeners para filtros
    if (searchInput) {
        searchInput.addEventListener('input', filterPages);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterPages);
    }
</script>
