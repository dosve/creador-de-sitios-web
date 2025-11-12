// Navegador de Páginas - JavaScript
(function() {
    'use strict';
    
    // Datos de sitios web con páginas organizadas jerárquicamente
    const websites = {
        'tienda-virtual': {
            name: '🛒 Tienda Virtual',
            description: 'Tienda online completa con carrito y checkout',
            category: 'ecommerce',
            icon: 'shopping-cart',
            color: 'orange',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Página principal con productos destacados y ofertas', type: 'common', example: 'Tienda de ropa, electrónicos, etc.' },
                { slug: 'productos', title: 'Productos', description: 'Catálogo completo con filtros y búsqueda', type: 'common', example: 'Lista de todos los productos disponibles' },
                { slug: 'categorias', title: 'Categorías', description: 'Navegación por categorías de productos', type: 'specialized', example: 'Ropa, Calzado, Accesorios' },
                { slug: 'carrito', title: 'Carrito', description: 'Carrito de compras con resumen de productos', type: 'specialized', example: 'Productos seleccionados para comprar' },
                { slug: 'ofertas', title: 'Ofertas', description: 'Productos en descuento y promociones', type: 'specialized', example: 'Black Friday, Descuentos especiales' },
                { slug: 'contacto', title: 'Contacto', description: 'Formulario de contacto y datos de la tienda', type: 'common', example: 'Formulario, dirección, horarios' }
            ]
        },
        'tienda-minimalista': {
            name: '⚫ Tienda Minimalista',
            description: 'Diseño ultra minimalista inspirado en Apple',
            category: 'ecommerce',
            icon: 'apple',
            color: 'gray',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Página principal minimalista con productos destacados', type: 'common', example: 'Diseño limpio y elegante' },
                { slug: 'productos', title: 'Productos', description: 'Catálogo con diseño minimalista', type: 'common', example: 'Productos cuidadosamente seleccionados' },
                { slug: 'categorias', title: 'Categorías', descripbtion: 'Navegación simple por categorías', type: 'specialized', example: 'Hogar, Oficina, Moda' },
                { slug: 'sobre-nosotros', title: 'Sore Nosotros', description: 'Historia de la marca minimalista', type: 'common', example: 'Filosofía de diseño' },
                { slug: 'contacto', title: 'Contacto', description: 'Formulario de contacto minimalista', type: 'common', example: 'Contacto directo y simple' }
            ]
        },
        'moda-boutique': {
            name: '👗 Moda Boutique',
            description: 'Tienda elegante para ropa y accesorios de moda',
            category: 'fashion',
            icon: 'tshirt',
            color: 'pink',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Página principal con lookbook y colecciones', type: 'common', example: 'Tendencias de moda actuales' },
                { slug: 'mujer', title: 'Mujer', description: 'Sección de moda femenina', type: 'common', example: 'Ropa, accesorios y calzado para mujer' },
                { slug: 'hombre', title: 'Hombre', description: 'Sección de moda masculina', type: 'common', example: 'Ropa y accesorios para hombre' },
                { slug: 'accesorios', title: 'Accesorios', description: 'Bolsas, zapatos, joyería', type: 'specialized', example: 'Completa tu look' },
                { slug: 'colecciones', title: 'Colecciones', description: 'Ediciones especiales y limitadas', type: 'specialized', example: 'Colecciones por temporada' },
                { slug: 'sobre-nosotros', title: 'Sobre Nosotros', description: 'Historia de la boutique', type: 'common', example: 'Nuestra pasión por la moda' },
                { slug: 'contacto', title: 'Contacto', description: 'Información de contacto y ubicación', type: 'common', example: 'Visítanos en nuestra tienda' }
            ]
        },
        'consultoria-corporativa': {
            name: '💼 Consultoría Corporativa',
            description: 'Sitio web profesional para consultoras y empresas',
            category: 'business',
            icon: 'briefcase',
            color: 'blue',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Presentación de la consultora y servicios', type: 'common', example: 'Consultoría estratégica y empresarial' },
                { slug: 'servicios', title: 'Servicios', description: 'Lista detallada de servicios de consultoría', type: 'common', example: 'Estrategia, Operaciones, Finanzas' },
                { slug: 'casos-exito', title: 'Casos de Éxito', description: 'Proyectos completados y resultados', type: 'specialized', example: 'Transformaciones empresariales' },
                { slug: 'equipo', title: 'Nuestro Equipo', description: 'Consultores y especialistas', type: 'specialized', example: 'Expertos en diferentes áreas' },
                { slug: 'contacto', title: 'Contacto', description: 'Formulario de contacto profesional', type: 'common', example: 'Solicita una consulta' }
            ]
        },
        'clinica-medica': {
            name: '🏥 Clínica Médica',
            description: 'Sitio web para clínicas y centros médicos',
            category: 'health',
            icon: 'heartbeat',
            color: 'red',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Presentación de la clínica y servicios médicos', type: 'common', example: 'Atención médica de calidad' },
                { slug: 'servicios', title: 'Servicios', description: 'Servicios médicos y tratamientos', type: 'common', example: 'Consultas, tratamientos, cirugías' },
                { slug: 'especialidades', title: 'Especialidades', description: 'Áreas médicas especializadas', type: 'specialized', example: 'Cardiología, Dermatología, Odontología' },
                { slug: 'doctores', title: 'Doctores', description: 'Equipo médico y especialistas', type: 'specialized', example: 'Dr. García, Dra. López, especialistas' },
                { slug: 'citas', title: 'Citas', description: 'Sistema de agendamiento de citas', type: 'specialized', example: 'Reservar consulta médica online' },
                { slug: 'contacto', title: 'Contacto', description: 'Información de contacto y ubicación', type: 'common', example: 'Dirección, teléfonos, horarios' }
            ]
        },
        'academia-online': {
            name: '🎓 Academia Online',
            description: 'Plataforma educativa para cursos y capacitaciones',
            category: 'education',
            icon: 'graduation-cap',
            color: 'green',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Presentación de la academia y cursos', type: 'common', example: 'Aprende desde cualquier lugar' },
                { slug: 'cursos', title: 'Cursos', description: 'Catálogo de cursos y programas', type: 'common', example: 'Inglés, Programación, Diseño' },
                { slug: 'instructores', title: 'Instructores', description: 'Profesores y tutores especializados', type: 'specialized', example: 'Profesores certificados, expertos' },
                { slug: 'mi-aprendizaje', title: 'Mi Aprendizaje', description: 'Panel del estudiante', type: 'specialized', example: 'Mis cursos, certificados, progreso' },
                { slug: 'planes', title: 'Planes', description: 'Planes de estudio y precios', type: 'specialized', example: 'Básico, Intermedio, Avanzado' },
                { slug: 'blog', title: 'Blog', description: 'Artículos educativos y recursos', type: 'specialized', example: 'Tips, tutoriales, noticias' }
            ]
        },
        'portafolio-creativo': {
            name: '🎨 Portafolio Creativo',
            description: 'Sitio web para diseñadores, fotógrafos y creativos',
            category: 'creative',
            icon: 'palette',
            color: 'purple',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Portfolio principal con trabajos destacados', type: 'common', example: 'Diseñador, Fotógrafo, Artista' },
                { slug: 'portfolio', title: 'Portfolio', description: 'Galería completa de trabajos', type: 'common', example: 'Proyectos de diseño, fotografía' },
                { slug: 'servicios', title: 'Servicios', description: 'Servicios creativos ofrecidos', type: 'common', example: 'Diseño web, branding, fotografía' },
                { slug: 'galeria', title: 'Galería', description: 'Colección de imágenes y trabajos', type: 'specialized', example: 'Fotos, diseños, ilustraciones' },
                { slug: 'sobre-mi', title: 'Sobre Mí', description: 'Biografía y experiencia', type: 'specialized', example: 'Mi historia, experiencia, premios' },
                { slug: 'contacto', title: 'Contacto', description: 'Formulario para solicitar servicios', type: 'common', example: 'Presupuestos, consultas, proyectos' }
            ]
        },
        'eventos-conferencias': {
            name: '🎪 Eventos y Conferencias',
            description: 'Sitio web para eventos, conferencias y entretenimiento',
            category: 'events',
            icon: 'calendar-alt',
            color: 'yellow',
            pages: [
                { slug: 'inicio', title: 'Inicio', description: 'Próximos eventos y información general', type: 'common', example: 'Conciertos, conferencias, festivales' },
                { slug: 'eventos', title: 'Eventos', description: 'Lista de eventos programados', type: 'common', example: 'Calendario de eventos, fechas' },
                { slug: 'reservas', title: 'Reservas', description: 'Sistema de reserva de entradas', type: 'specialized', example: 'Comprar entradas online' },
                { slug: 'galeria', title: 'Galería', description: 'Fotos y videos de eventos pasados', type: 'specialized', example: 'Memorias de eventos anteriores' },
                { slug: 'patrocinadores', title: 'Patrocinadores', description: 'Información de patrocinadores', type: 'specialized', example: 'Marcas que apoyan el evento' },
                { slug: 'contacto', title: 'Contacto', description: 'Información de contacto para eventos', type: 'common', example: 'Organizadores, ubicación' }
            ]
        }
    };

    let allPages = [];
    let filteredPages = [];
    let selectedPages = new Set();
    let selectedWebsite = null;
    let allowedSlugs = new Set(); // Slugs disponibles en la plantilla actual del sitio
    let existingSlugs = new Set(); // Slugs ya existentes en el sitio

    // Elementos del DOM
    let searchInput, categoryFilter, pagesGrid, totalPagesSpan, filteredPagesSpan, selectedPagesSpan, importSelectedBtn;

    // Inicializar cuando se abre el modal
    function init() {
        console.log('Inicializando navegador de páginas...');
        
        // Obtener elementos del DOM
        searchInput = document.getElementById('pageSearch');
        categoryFilter = document.getElementById('categoryFilter');
        pagesGrid = document.getElementById('pagesGrid');
        totalPagesSpan = document.getElementById('totalPages');
        filteredPagesSpan = document.getElementById('filteredPages');
        selectedPagesSpan = document.getElementById('selectedPages');
        importSelectedBtn = document.getElementById('importSelectedPages');
        
        // Cargar todos los sitios web
        loadWebsites();
        // Cargar slugs permitidos por la plantilla del sitio actual
        loadAllowedSlugs();
        // Cargar slugs existentes del sitio
        if (Array.isArray(window.existingPageSlugs)) {
            existingSlugs = new Set(window.existingPageSlugs);
        }
        
        // Inicializar
        updateStats();
        renderWebsites();
        
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
    }

    // Cargar slugs permitidos desde el backend para la plantilla asignada al website
    function loadAllowedSlugs() {
        const websiteId = window.websiteId;
        if (!websiteId) return;
        fetch(`/creator/pages/template-pages/${websiteId}`)
            .then(r => r.ok ? r.json() : [])
            .then(pages => {
                try {
                    const list = Array.isArray(pages) ? pages : [];
                    allowedSlugs = new Set(list.map(p => p.slug));
                    // Re-render para aplicar estilos de disponibilidad
                    renderWebsites();
                } catch (e) {
                    console.warn('No se pudieron cargar slugs permitidos:', e);
                }
            })
            .catch(() => {
                // Silencioso; se permitirá importar aunque el backend filtre
            });
    }
    
    // Cargar todos los sitios web
    function loadWebsites() {
        allPages = [];
        Object.keys(websites).forEach(websiteKey => {
            const website = websites[websiteKey];
            website.pages.forEach(page => {
                allPages.push({
                    ...page,
                    websiteKey: websiteKey,
                    websiteName: website.name,
                    websiteDescription: website.description,
                    websiteCategory: website.category,
                    websiteIcon: website.icon,
                    websiteColor: website.color
                });
            });
        });
        filteredPages = [...allPages];
    }

    // Filtrar páginas
    function filterPages() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;

        filteredPages = allPages.filter(page => {
            const matchesSearch = page.title.toLowerCase().includes(searchTerm) ||
                                page.description.toLowerCase().includes(searchTerm);
            const matchesCategory = !selectedCategory || page.websiteCategory === selectedCategory;
            
            return matchesSearch && matchesCategory;
        });

        updateStats();
        // Mantener la visualización agrupada por sitio web
        renderWebsites();
    }

    // Renderizar sitios web
    function renderWebsites() {
        console.log('Renderizando sitios web...');
        
        if (!pagesGrid) return;
        
        pagesGrid.innerHTML = '';

        // Agrupar por sitios web
        const websitesData = {};
        filteredPages.forEach(page => {
            if (!websitesData[page.websiteKey]) {
                websitesData[page.websiteKey] = {
                    ...websites[page.websiteKey],
                    pages: []
                };
            }
            websitesData[page.websiteKey].pages.push(page);
        });

        // Renderizar cada sitio web
        Object.keys(websitesData).forEach(websiteKey => {
            const website = websitesData[websiteKey];
            const websiteColor = getWebsiteColor(website.color);
            
            // Header del sitio web
            const websiteHeader = document.createElement('div');
            websiteHeader.className = 'col-span-full mb-6';
            websiteHeader.innerHTML = `
                <div class="bg-gradient-to-r ${websiteColor.bg} border border-gray-200 rounded-xl p-6 cursor-pointer hover:shadow-lg transition-all duration-200" onclick="PagesNavigator.toggleWebsite('${websiteKey}')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 ${websiteColor.bg} rounded-xl flex items-center justify-center mr-6">
                                <i class="fas fa-${website.icon} text-2xl ${websiteColor.text}"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">${website.name}</h3>
                                <p class="text-gray-600 mb-2">${website.description}</p>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-gray-700">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        ${website.pages.length} páginas
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-gray-700">
                                        <i class="fas fa-${getCategoryIcon(website.category)} mr-2"></i>
                                        ${getCategoryName(website.category)}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="text-gray-600 hover:text-gray-800 text-2xl transition-colors">
                                <i class="fas fa-chevron-down" id="chevron-${websiteKey}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            pagesGrid.appendChild(websiteHeader);

            // Páginas del sitio web (inicialmente ocultas)
            const pagesContainer = document.createElement('div');
            pagesContainer.className = 'col-span-full mb-8 hidden';
            pagesContainer.id = `pages-${websiteKey}`;
            pagesContainer.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    ${website.pages.map(page => {
                        const key = `${websiteKey}--${page.slug}`;
                        const isSelected = selectedPages.has(key);
                        const isAllowed = allowedSlugs.size === 0 ? true : allowedSlugs.has(page.slug);
                        const isExisting = existingSlugs.has(page.slug);
                        return `
                            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 border-2 ${isSelected ? 'border-indigo-500 ring-2 ring-indigo-200' : 'border-gray-200 hover:border-gray-300'} ${( !isAllowed || isExisting) ? 'opacity-50 pointer-events-none' : 'cursor-pointer'} group" onclick="PagesNavigator.togglePageSelection('${key}')">
                                <div class="p-6">
                                    <!-- Header con título -->
                                    <div class="mb-4">
                                        <h6 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">${page.title}</h6>
                                    </div>
                                    
                                    <!-- Descripción -->
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">${page.description}</p>
                                    
                                    <!-- Ejemplo -->
                                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                        <div class="flex items-start">
                                            <i class="fas fa-lightbulb text-yellow-500 mr-2 mt-0.5 text-sm"></i>
                                            <div>
                                                <p class="text-xs font-medium text-gray-700 mb-1">Ejemplo:</p>
                                                <p class="text-xs text-gray-600">${page.example}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Footer con badge y botón -->
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${page.type === 'common' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                            <i class="fas fa-${page.type === 'common' ? 'star' : 'puzzle-piece'} mr-1"></i>
                                            ${page.type === 'common' ? 'Esencial' : 'Especializada'}
                                        </span>
                                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium ${isExisting ? 'text-gray-400 bg-gray-100 cursor-not-allowed' : 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100'} rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" ${isExisting ? 'disabled' : ''} onclick="event.stopPropagation(); ${isExisting ? 'void(0);' : `PagesNavigator.previewPage('${key}')`}">
                                            <i class="fas fa-eye mr-2"></i>
                                            ${isExisting ? 'Ya existe' : 'Vista Previa'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
            pagesGrid.appendChild(pagesContainer);
        });
    }

    // Renderizar páginas (función original para compatibilidad)
    function renderPages() {
        console.log('Renderizando páginas...', filteredPages.length);
        
        if (!pagesGrid) return;
        
        pagesGrid.innerHTML = '';

        if (filteredPages.length === 0) {
            pagesGrid.innerHTML = `
                <div class="col-span-full">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-info-circle text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">No se encontraron páginas</h3>
                            <p class="text-blue-700">Intenta ajustar los filtros de búsqueda o categoría.</p>
                        </div>
                    </div>
                </div>
            `;
            return;
        }

        // Agrupar páginas por categoría
        const groupedPages = {};
        filteredPages.forEach(page => {
            if (!groupedPages[page.category]) {
                groupedPages[page.category] = [];
            }
            groupedPages[page.category].push(page);
        });

        // Renderizar cada grupo
        Object.keys(groupedPages).forEach(category => {
            const pages = groupedPages[category];
            const categoryName = getCategoryName(category);
            const categoryIcon = getCategoryIcon(category);
            const categoryColor = getCategoryColor(category);

            // Header del grupo
            const groupHeader = document.createElement('div');
            groupHeader.className = 'col-span-full mb-6';
            groupHeader.innerHTML = `
                <div class="bg-gradient-to-r ${categoryColor.bg} border border-gray-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 ${categoryColor.bg} rounded-lg flex items-center justify-center mr-4">
                            <i class="${categoryIcon} text-xl ${categoryColor.text}"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">${categoryName}</h3>
                            <p class="text-sm text-gray-600">${pages.length} páginas disponibles</p>
                        </div>
                    </div>
                </div>
            `;
            pagesGrid.appendChild(groupHeader);

            // Páginas del grupo
            pages.forEach(page => {
                const key = `${page.websiteKey}--${page.slug}`;
                const isSelected = selectedPages.has(key);
                
                const pageCard = document.createElement('div');
                pageCard.className = 'col-span-1';
                pageCard.innerHTML = `
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 border-2 ${isSelected ? 'border-indigo-500 ring-2 ring-indigo-200' : 'border-gray-200 hover:border-gray-300'} cursor-pointer group" onclick="PagesNavigator.togglePageSelection('${key}')">
                        <div class="p-6">
                            <!-- Header con título -->
                            <div class="mb-4">
                                <h6 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">${page.title}</h6>
                            </div>
                            
                            <!-- Descripción -->
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">${page.description}</p>
                            
                            <!-- Ejemplo -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-yellow-500 mr-2 mt-0.5 text-sm"></i>
                                    <div>
                                        <p class="text-xs font-medium text-gray-700 mb-1">Ejemplo:</p>
                                        <p class="text-xs text-gray-600">${page.example}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Footer con badge y botón -->
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${page.type === 'common' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                    <i class="fas fa-${page.type === 'common' ? 'star' : 'puzzle-piece'} mr-1"></i>
                                    ${page.type === 'common' ? 'Esencial' : 'Especializada'}
                                </span>
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors" onclick="event.stopPropagation(); PagesNavigator.previewPage('${key}')">
                                    <i class="fas fa-eye mr-2"></i>
                                    Vista Previa
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                pagesGrid.appendChild(pageCard);
            });
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

    // Obtener colores de categoría
    function getCategoryColor(category) {
        const colors = {
            'ecommerce': { bg: 'bg-orange-100', text: 'text-orange-600' },
            'business': { bg: 'bg-blue-100', text: 'text-blue-600' },
            'health': { bg: 'bg-red-100', text: 'text-red-600' },
            'education': { bg: 'bg-green-100', text: 'text-green-600' },
            'creative': { bg: 'bg-purple-100', text: 'text-purple-600' },
            'events': { bg: 'bg-pink-100', text: 'text-pink-600' }
        };
        return colors[category] || { bg: 'bg-gray-100', text: 'text-gray-600' };
    }

    // Obtener colores de sitio web
    function getWebsiteColor(color) {
        const colors = {
            'orange': { bg: 'bg-gradient-to-r from-orange-500 to-orange-600', text: 'text-white' },
            'gray': { bg: 'bg-gradient-to-r from-gray-800 to-gray-900', text: 'text-white' },
            'pink': { bg: 'bg-gradient-to-r from-pink-500 to-pink-600', text: 'text-white' },
            'blue': { bg: 'bg-gradient-to-r from-blue-500 to-blue-600', text: 'text-white' },
            'red': { bg: 'bg-gradient-to-r from-red-500 to-red-600', text: 'text-white' },
            'green': { bg: 'bg-gradient-to-r from-green-500 to-green-600', text: 'text-white' },
            'purple': { bg: 'bg-gradient-to-r from-purple-500 to-purple-600', text: 'text-white' },
            'yellow': { bg: 'bg-gradient-to-r from-yellow-500 to-yellow-600', text: 'text-white' }
        };
        return colors[color] || { bg: 'bg-gradient-to-r from-gray-500 to-gray-600', text: 'text-white' };
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
        // Usar la nueva ruta de vista previa limpia
        const previewUrl = `/creator/pages/preview/${slug}`;
        window.open(previewUrl, '_blank');
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

        const websiteId = window.websiteId;
        if (!websiteId) {
            alert('No se encontró el sitio web seleccionado. Recarga la página e inténtalo de nuevo.');
            return;
        }

        // Extraer template y slug (formato clave: template--slug)
        let selectedArray = Array.from(selectedPages).map(key => {
            const parts = String(key).split('--');
            if (parts.length > 1) {
                return { template: parts[0], slug: parts[1] };
            }
            return { template: '', slug: key };
        });

        // Filtrar a slugs permitidos por la plantilla actual
        if (allowedSlugs.size > 0) {
            selectedArray = selectedArray.filter(obj => allowedSlugs.has(obj.slug));
        }
        // Excluir los que ya existen en el sitio
        selectedArray = selectedArray.filter(obj => !existingSlugs.has(obj.slug));
        if (selectedArray.length === 0) {
            alert('Las páginas seleccionadas ya existen en tu sitio o no están disponibles en la plantilla actual.');
            return;
        }

        // Crear y enviar un formulario POST tradicional para respetar el flujo de Laravel (redirect con flash)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/creator/pages/import/${websiteId}`;

        // CSRF token
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfMeta) {
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfMeta.getAttribute('content');
            form.appendChild(tokenInput);
        }

        // Campos pages[n][template] y pages[n][slug]
        selectedArray.forEach((obj, idx) => {
            const t = document.createElement('input');
            t.type = 'hidden';
            t.name = `pages[${idx}][template]`;
            t.value = obj.template;
            form.appendChild(t);

            const s = document.createElement('input');
            s.type = 'hidden';
            s.name = `pages[${idx}][slug]`;
            s.value = obj.slug;
            form.appendChild(s);
        });

        // Añadir al DOM y enviar
        document.body.appendChild(form);
        form.submit();
    }

    // Funciones para abrir y cerrar el modal
    function openModal() {
        const modal = document.getElementById('pagesNavigationModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            init();
        }
    }

    function closeModal() {
        const modal = document.getElementById('pagesNavigationModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Alternar sitio web
    function toggleWebsite(websiteKey) {
        const pagesContainer = document.getElementById(`pages-${websiteKey}`);
        const chevron = document.getElementById(`chevron-${websiteKey}`);
        
        if (pagesContainer.classList.contains('hidden')) {
            pagesContainer.classList.remove('hidden');
            chevron.classList.remove('fa-chevron-down');
            chevron.classList.add('fa-chevron-up');
        } else {
            pagesContainer.classList.add('hidden');
            chevron.classList.remove('fa-chevron-up');
            chevron.classList.add('fa-chevron-down');
        }
    }

    // API pública
    window.PagesNavigator = {
        init: init,
        openModal: openModal,
        closeModal: closeModal,
        togglePageSelection: togglePageSelection,
        toggleWebsite: toggleWebsite,
        previewPage: previewPage
    };

    // Hacer las funciones globales para los onclick
    window.openModal = openModal;
    window.closeModal = closeModal;

    // No auto-inicializar, solo cuando se abra el modal
})();
