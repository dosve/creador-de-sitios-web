{{--
    Componente para cargar posts del blog dinámicamente
    
    @param int $websiteId - ID del sitio web
    @param string $websiteSlug - Slug del sitio web (opcional, se obtiene de window.websiteSlug)
--}}
@props(['websiteId' => '', 'websiteSlug' => ''])

<script id="blog-script-{{ $websiteId }}">
    // Prevenir ejecución múltiple del script usando un identificador único
    // Esta verificación debe estar FUERA de la IIFE para ejecutarse inmediatamente
    (function() {
        'use strict';

        // Verificar si ya se ejecutó este script (usando un identificador único por website)
        const scriptId = 'blog-script-loaded-{{ $websiteId }}';
        if (window[scriptId]) {
            console.warn('⚠️ Blog script ya fue cargado para website {{ $websiteId }}, omitiendo carga duplicada');
            return;
        }

        // Marcar como cargado inmediatamente
        window[scriptId] = true;
        console.log('📝 [BLOG SCRIPT] Inicializando (websiteId={{ $websiteId }})');

        document.addEventListener("DOMContentLoaded", function() {
            console.log('📝 [BLOG SCRIPT] DOMContentLoaded – buscando contenedores de blog…');

            // Buscar contenedores rápidamente para verificar si esta página tiene blog
            const hasAnyBlogContainer = document.querySelector("#blog-posts-container") ||
                document.querySelector("[data-dynamic-blog=\"true\"]") ||
                document.querySelector(".blog-list") ||
                document.querySelector(".blog-grid");

            if (!hasAnyBlogContainer) {
                console.debug('ℹ️ [BLOG SCRIPT] Esta página no tiene bloque de blog, desactivando carga de posts');
                return; // Salir silenciosamente si no hay blog en esta página
            }

            console.log('📝 [BLOG SCRIPT] ✅ Blog detectado, inicializando carga de posts…');

            // Variables globales para el scroll infinito
            let currentPage = 1;
            let isLoading = false;
            let hasMorePosts = true;
            let allPosts = [];

            // Función para mostrar indicador de carga
            function showLoadingIndicator(container) {
                container.innerHTML = `
            <div class="flex items-center justify-center py-12 col-span-full">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                    <p class="text-gray-600">Cargando artículos...</p>
                </div>
            </div>
        `;
            }

            // Función para cargar posts reales del blog
            function loadRealBlogPosts(page = 1, append = false) {
                if (isLoading) {
                    return;
                }

                isLoading = true;

                // Buscar contenedores de blog posts
                let blogContainers = document.querySelectorAll("#blog-posts-container");

                // Si no encuentra por ID, buscar por atributo data
                if (blogContainers.length === 0) {
                    blogContainers = document.querySelectorAll("[data-dynamic-blog=\"true\"] .grid");
                }

                // Si aún no encuentra, buscar por clase
                if (blogContainers.length === 0) {
                    blogContainers = document.querySelectorAll(".blog-list .grid, .blog-grid .grid");
                }

                // Búsqueda adicional: buscar sección con data-dynamic-blog y luego el grid dentro
                if (blogContainers.length === 0) {
                    const blogSections = document.querySelectorAll("[data-dynamic-blog=\"true\"]");

                    if (blogSections.length > 0) {
                        blogSections.forEach((section) => {
                            const grid = section.querySelector(".grid, #blog-posts-container");
                            if (grid && blogContainers.length === 0) {
                                blogContainers = [grid];
                            }
                        });
                    }
                }

                if (blogContainers.length === 0) {
                    // Silenciosamente salir si no hay contenedores de blog en esta página
                    // Esto es normal si la página no tiene bloque de blog
                    if (append) {
                        // Solo mostrar warning si estamos intentando agregar más posts (scroll infinito)
                        console.debug('ℹ️ [BLOG SCRIPT] No hay contenedores de blog para cargar más posts');
                    }
                    isLoading = false;
                    return;
                }
                if (!append) console.log('📡 [BLOG SCRIPT] Contenedores encontrados:', blogContainers.length, blogContainers);

                // Mostrar indicador de carga en todos los contenedores (solo en la primera carga)
                if (!append) {
                    blogContainers.forEach(container => {
                        showLoadingIndicator(container);
                    });
                }

                // Obtener el website ID del parámetro del componente
                const defaultWebsiteId = "{{ $websiteId }}";

                blogContainers.forEach((container) => {
                    // Obtener el website ID del atributo data o usar el parámetro
                    let containerWebsiteId = container.dataset.websiteId;

                    // Si el atributo está vacío o es "1" (valor por defecto), usar el ID del componente
                    if (!containerWebsiteId || containerWebsiteId === "" || containerWebsiteId === "1") {
                        containerWebsiteId = defaultWebsiteId;
                    }
                    console.log('📡 [BLOG SCRIPT] container websiteId:', container.dataset.websiteId, '→ usando:', containerWebsiteId);

                    // Guardar el website ID globalmente para usar en los enlaces
                    window.currentWebsiteId = containerWebsiteId;

                    // Si hay website ID válido (debe ser un número), cargar posts reales
                    if (containerWebsiteId && containerWebsiteId !== "" && !isNaN(containerWebsiteId) && parseInt(containerWebsiteId) > 0) {
                        const base = (typeof window.appBaseUrl !== 'undefined' && window.appBaseUrl) ? window.appBaseUrl : window.location.origin;
                        const apiUrl = `${base}/api/websites/${containerWebsiteId}/blog-posts?page=${page}&per_page=6`;
                        console.log('📡 [BLOG SCRIPT] Llamando a API:', apiUrl);
                        fetch(apiUrl, {
                                method: "GET",
                                headers: {
                                    "Accept": "application/json",
                                    "Content-Type": "application/json",
                                    "X-Requested-With": "XMLHttpRequest"
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    console.error("❌ [BLOG SCRIPT] Error en la respuesta:", response.status, response.statusText);
                                    throw new Error("Error en la respuesta de la API: " + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                let posts = [];
                                if (data && data.data && Array.isArray(data.data)) {
                                    posts = data.data;
                                } else if (data && Array.isArray(data)) {
                                    posts = data;
                                }
                                console.log('📡 [BLOG SCRIPT] API respondió OK. Posts recibidos:', posts.length, '| data.data:', data && data.data ? data.data.length : 'n/a');
                                if (posts.length > 0) {
                                    console.log('📋 [BLOG SCRIPT] Artículos:', posts.map(function(p) {
                                        return p.title || '(sin título)';
                                    }));
                                }

                                // Verificar si hay más posts
                                hasMorePosts = posts.length >= 6;

                                if (posts.length > 0) {
                                    console.log('✅ [BLOG SCRIPT] Renderizando', posts.length, 'artículos');
                                    if (append) {
                                        // Agregar posts a los existentes
                                        allPosts = allPosts.concat(posts);
                                        renderRealBlogPosts(container, allPosts, true);
                                    } else {
                                        // Primera carga
                                        allPosts = posts;
                                        renderRealBlogPosts(container, posts, false);
                                    }

                                    // Agregar buscador de posts
                                    addBlogSearch(container);

                                    // Actualizar enlace "Ver Todos los Artículos"
                                    updateBlogListLink();

                                    // Configurar scroll infinito
                                    if (hasMorePosts) {
                                        setupInfiniteScroll();
                                    }
                                } else {
                                    console.log('⚠️ [BLOG SCRIPT] No hay posts; mostrando "No hay artículos"');
                                    if (!append) {
                                        // Si no hay posts, mostrar mensaje en lugar de ejemplos
                                        container.innerHTML = `
                                <div class="py-12 text-center col-span-full">
                                    <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="mb-2 text-xl font-medium text-gray-900">No hay artículos disponibles</h3>
                                    <p class="text-gray-500">Aún no se han publicado artículos en este blog.</p>
                                </div>
                            `;
                                    }
                                }

                                isLoading = false;
                            })
                            .catch(error => {
                                console.error("❌ [BLOG SCRIPT] Error al cargar posts:", error.message || error);
                                if (!append) {
                                    // En caso de error, mostrar mensaje en lugar de ejemplos
                                    container.innerHTML = `
                            <div class="py-12 text-center col-span-full">
                                <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full">
                                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-medium text-gray-900">Error al cargar artículos</h3>
                                <p class="text-gray-500">No se pudieron cargar los artículos del blog. Por favor, intenta recargar la página.</p>
                            </div>
                        `;
                                }
                                isLoading = false;
                            });
                    } else {
                        console.warn('⚠️ [BLOG SCRIPT] websiteId inválido o vacío; mostrando "Configuración requerida". containerWebsiteId:', containerWebsiteId);
                        // Si no hay website ID válido, mostrar mensaje
                        container.innerHTML = `
                    <div class="py-12 text-center col-span-full">
                        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-medium text-gray-900">Configuración requerida</h3>
                        <p class="text-gray-500">El blog necesita estar configurado para mostrar artículos.</p>
                    </div>
                `;
                        isLoading = false;
                    }
                });
            }

            // Función para renderizar posts reales
            function renderRealBlogPosts(container, posts, append = false) {
                if (!append) {
                    container.innerHTML = "";
                }

                posts.forEach((post, index) => {
                    const postElement = createBlogPostElement(post);
                    container.appendChild(postElement);
                });
            }

            // Función auxiliar para obtener el slug del website
            function getWebsiteSlug() {
                // Prioridad 1: Variable global window.websiteSlug
                if (window.websiteSlug) {
                    return window.websiteSlug;
                }

                // Prioridad 2: Obtener desde la URL actual
                const path = window.location.pathname;
                const parts = path.split('/').filter(p => p && p !== 'public' && p !== 'creador-web-eme10');

                // Si estamos en una ruta como /sitio/pagina o /sitio/blog, el primer segmento es el slug
                if (parts.length > 0) {
                    return parts[0];
                }

                // Fallback: usar 'sitio' como default
                return 'sitio';
            }

            // Función para crear elemento HTML de un post
            function createBlogPostElement(post) {
                const postDiv = document.createElement('article');
                postDiv.className = 'bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow';

                // Calcular tiempo de lectura
                const readTime = calculateReadTime(post.content || '');

                // Crear excerpt
                const excerpt = post.excerpt || (stripHtmlTags(String(post.content || '')).substring(0, 150) + '...') || 'Sin extracto';

                // Crear categoría badge
                const categoryBadge = post.category ?
                    `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">${escapeHtml(post.category.name)}</span>` : '';

                // Crear tags
                let tagsHtml = '';
                if (post.tags && post.tags.length > 0) {
                    tagsHtml = '<div class="flex flex-wrap gap-1 mt-2">';
                    post.tags.slice(0, 3).forEach(tag => {
                        tagsHtml += `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">${escapeHtml(tag.name)}</span>`;
                    });
                    tagsHtml += '</div>';
                }

                // Formatear fecha
                const rawDate = post.created_at || post.published_at;
                const publishDate = rawDate ? new Date(rawDate).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) : 'Sin fecha';

                // Obtener el slug del website y del post
                const postWebsiteSlug = getWebsiteSlug();
                const postSlug = post.slug || post.id;

                const imageHtml = post.featured_image ?
                    `<img src="${escapeHtml(post.featured_image || '')}" alt="${escapeHtml(post.title || '')}" class="object-cover w-full h-full">` :
                    `<div class="flex items-center justify-center w-full h-full bg-gradient-to-br from-blue-100 to-purple-100">
                ${categoryBadge}
            </div>`;

                const categoryOverlay = post.featured_image && categoryBadge ?
                    `<div class="absolute top-4 left-4">${categoryBadge}</div>` :
                    '';

                postDiv.innerHTML = `
            <div class="relative w-full h-48 overflow-hidden">
                ${imageHtml}
                ${categoryOverlay}
            </div>
            <div class="p-6">
                <div class="flex items-center mb-2 text-sm text-gray-500">
                    <span>${publishDate}</span>
                    <span class="mx-2">•</span>
                    <span>${readTime} min lectura</span>
                </div>
                <h3 class="mb-2 text-xl font-bold text-gray-900 cursor-pointer hover:text-blue-600">
                    <a href="/${postWebsiteSlug}/blog/${postSlug}">${escapeHtml(post.title || '')}</a>
                </h3>
                <p class="mb-4 text-gray-600">${escapeHtml(excerpt)}</p>
                ${tagsHtml}
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 mr-2 bg-gray-300 rounded-full"></div>
                        <span class="text-sm text-gray-600">Autor</span>
                    </div>
                    <a href="/${postWebsiteSlug}/blog/${postSlug}" class="text-sm text-blue-600 hover:text-blue-800">Leer más →</a>
                </div>
            </div>
        `;

                return postDiv;
            }

            // Función para mostrar posts de ejemplo
            function showExampleBlogPosts(container) {
                const examplePosts = [{
                        id: 1,
                        title: "Guía Completa de Desarrollo Web",
                        excerpt: "Aprende los fundamentos del desarrollo web moderno con esta guía completa que cubre HTML, CSS, JavaScript y frameworks populares.",
                        date: "15 Enero, 2024",
                        readTime: "5",
                        category: {
                            name: "Tecnología"
                        },
                        tags: [{
                            name: "Web"
                        }, {
                            name: "Desarrollo"
                        }],
                        slug: "guia-desarrollo-web"
                    },
                    {
                        id: 2,
                        title: "Mejores Prácticas de SEO",
                        excerpt: "Descubre las estrategias más efectivas para optimizar tu sitio web y mejorar tu posicionamiento en los motores de búsqueda.",
                        date: "12 Enero, 2024",
                        readTime: "7",
                        category: {
                            name: "Marketing"
                        },
                        tags: [{
                            name: "SEO"
                        }, {
                            name: "Optimización"
                        }],
                        slug: "mejores-practicas-seo"
                    },
                    {
                        id: 3,
                        title: "Diseño UX/UI Moderno",
                        excerpt: "Explora las tendencias actuales en diseño de interfaces de usuario y experiencia de usuario para crear productos digitales atractivos.",
                        date: "10 Enero, 2024",
                        readTime: "4",
                        category: {
                            name: "Diseño"
                        },
                        tags: [{
                            name: "UX"
                        }, {
                            name: "UI"
                        }],
                        slug: "diseno-ux-ui-moderno"
                    }
                ];

                container.innerHTML = "";

                examplePosts.forEach(post => {
                    const postElement = createBlogPostElement(post);
                    container.appendChild(postElement);
                });

                // Agregar mensaje de ejemplo
                const messageDiv = document.createElement('div');
                messageDiv.className = 'col-span-full text-center py-4';
                messageDiv.innerHTML = '<p class="text-sm text-gray-500">Posts de ejemplo - Crea contenido real para ver tus artículos aquí</p>';
                container.appendChild(messageDiv);
            }

            // Función para agregar buscador de posts
            function addBlogSearch(container) {
                // Verificar si ya existe un buscador
                const existingSearch = container.parentElement.querySelector('.blog-search');
                if (existingSearch) {
                    return;
                }

                const searchDiv = document.createElement('div');
                searchDiv.className = 'blog-search mb-6 flex flex-col sm:flex-row gap-4';

                searchDiv.innerHTML = `
            <div class="flex-1">
                <input type="text" 
                       placeholder="Buscar artículos..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="recent">Más recientes</option>
                    <option value="oldest">Más antiguos</option>
                    <option value="title">Por título</option>
                    <option value="category">Por categoría</option>
                </select>
                <button class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    Buscar
                </button>
            </div>
        `;

                if (container && container.parentElement) {
                    container.parentElement.insertBefore(searchDiv, container);
                } else {
                    console.error('❌ No se puede insertar el buscador de blog: contenedor o parentElement no encontrado');
                }

                // Configurar eventos de búsqueda
                const searchInput = searchDiv.querySelector('input');
                const sortSelect = searchDiv.querySelector('select');
                const searchButton = searchDiv.querySelector('button');

                searchButton.addEventListener('click', () => {
                    searchBlogPosts(searchInput.value, sortSelect.value);
                });

                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        searchBlogPosts(searchInput.value, sortSelect.value);
                    }
                });
            }

            // Función para buscar posts
            function searchBlogPosts(query, sortBy) {
                const containerWebsiteId = document.querySelector("#blog-posts-container")?.dataset.websiteId || "{{ $websiteId }}";

                if (!containerWebsiteId) {
                    return;
                }

                isLoading = true;

                // Construir parámetros de búsqueda
                const searchParams = new URLSearchParams();
                searchParams.append('page', '1');
                searchParams.append('per_page', '12');

                if (query.trim()) {
                    searchParams.append('search', query.trim());
                }

                // Agregar ordenamiento
                switch (sortBy) {
                    case "oldest":
                        searchParams.append("sort", "created_at");
                        searchParams.append("order", "asc");
                        break;
                    case "title":
                        searchParams.append("sort", "title");
                        searchParams.append("order", "asc");
                        break;
                    case "category":
                        searchParams.append("sort", "category_id");
                        searchParams.append("order", "asc");
                        break;
                    default: // recent
                        searchParams.append("sort", "created_at");
                        searchParams.append("order", "desc");
                        break;
                }

                // Mostrar loading
                const container = document.querySelector("#blog-posts-container") ||
                    document.querySelector("[data-dynamic-blog=\"true\"] .grid") ||
                    document.querySelector(".blog-grid .grid");

                if (container) {
                    container.innerHTML = `
                <div class="flex items-center justify-center py-12 col-span-full">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                        <p class="text-gray-600">Buscando artículos...</p>
                    </div>
                </div>
            `;
                }

                const base = (typeof window.appBaseUrl !== 'undefined' && window.appBaseUrl) ? window.appBaseUrl : window.location.origin;
                const apiUrl = `${base}/api/websites/${containerWebsiteId}/blog-posts?${searchParams.toString()}`;
                console.log('📡 [BLOG SCRIPT] Buscando posts:', apiUrl);
                fetch(apiUrl, {
                        method: "GET",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let posts = [];

                        if (data && data.data && Array.isArray(data.data)) {
                            posts = data.data;
                        } else if (data && Array.isArray(data)) {
                            posts = data;
                        }

                        // Verificar si hay más posts
                        hasMorePosts = posts.length >= 12;

                        if (posts.length > 0) {
                            allPosts = posts;
                            renderRealBlogPosts(container, posts, false);
                        } else {
                            container.innerHTML = `
                    <div class="py-12 text-center col-span-full">
                        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-medium text-gray-900">No se encontraron artículos</h3>
                        <p class="text-gray-500">Intenta con otros términos de búsqueda.</p>
                    </div>
                `;
                        }

                        isLoading = false;
                    })
                    .catch(error => {
                        console.error("❌ Error al buscar posts:", error);
                        isLoading = false;
                    });
            }

            // Función para actualizar el enlace "Ver Todos los Artículos"
            function updateBlogListLink() {
                const blogListLink = document.querySelector('[data-blog-list-link]');
                if (blogListLink) {
                    const linkWebsiteSlug = getWebsiteSlug();
                    if (linkWebsiteSlug) {
                        blogListLink.href = `/${linkWebsiteSlug}/blog`;
                    }
                }
            }

            // Función para configurar scroll infinito
            function setupInfiniteScroll() {
                // Remover listener anterior si existe
                window.removeEventListener('scroll', handleInfiniteScroll);

                window.addEventListener('scroll', handleInfiniteScroll);
            }

            // Función para manejar scroll infinito
            function handleInfiniteScroll() {
                if (isLoading || !hasMorePosts) return;

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.offsetHeight;

                // Cargar más cuando esté cerca del final (100px antes)
                if (scrollTop + windowHeight >= documentHeight - 100) {
                    currentPage++;
                    loadRealBlogPosts(currentPage, true);
                }
            }

            // Funciones auxiliares
            function calculateReadTime(content) {
                const wordCount = content ? content.split(/\s+/).length : 0;
                return Math.max(1, Math.ceil(wordCount / 200)); // 200 palabras por minuto
            }

            function stripHtmlTags(html) {
                const div = document.createElement('div');
                div.innerHTML = html;
                return div.textContent || div.innerText || '';
            }

            function escapeHtml(text) {
                if (text == null) return '';
                const div = document.createElement('div');
                div.textContent = String(text);
                return div.innerHTML;
            }

            // Mostrar indicador de carga inmediatamente si hay contenedores
            function initializeBlogContainers() {
                let blogContainers = document.querySelectorAll("#blog-posts-container");

                if (blogContainers.length === 0) {
                    blogContainers = document.querySelectorAll("[data-dynamic-blog=\"true\"] .grid");
                }

                if (blogContainers.length === 0) {
                    blogContainers = document.querySelectorAll(".blog-list .grid, .blog-grid .grid");
                }

                if (blogContainers.length === 0) {
                    const blogSections = document.querySelectorAll("[data-dynamic-blog=\"true\"]");
                    if (blogSections.length > 0) {
                        blogSections.forEach((section) => {
                            const grid = section.querySelector(".grid, #blog-posts-container");
                            if (grid) {
                                blogContainers = [grid];
                            }
                        });
                    }
                }

                // Mostrar indicador de carga inmediatamente
                blogContainers.forEach(container => {
                    showLoadingIndicator(container);
                });
            }

            // Mostrar indicador de carga inmediatamente
            initializeBlogContainers();

            // Inicializar carga de posts - con delay para asegurar que el DOM esté listo
            setTimeout(() => {
                loadRealBlogPosts(1, false);
            }, 500);

            // También intentar cargar después de que la página esté completamente cargada
            if (document.readyState === 'loading') {
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        loadRealBlogPosts(1, false);
                    }, 300);
                });
            }
        });
    })(); // Fin de la IIFE - previene ejecución múltiple y aísla el scope
</script>