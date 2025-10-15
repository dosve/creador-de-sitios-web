{{--
    Componente para cargar posts del blog dinámicamente
    
    @param int $websiteId - ID del sitio web
--}}
@props(['websiteId' => ''])

<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("📝 Vista previa de página cargada, buscando posts del blog...");
    
    // Variables globales para el scroll infinito
    let currentPage = 1;
    let isLoading = false;
    let hasMorePosts = true;
    let allPosts = [];
    
    // Función para cargar posts reales del blog
    function loadRealBlogPosts(page = 1, append = false) {
        if (isLoading) return;
        
        isLoading = true;
        console.log("🚀 Iniciando carga de posts del blog... (Página " + page + ")");
        
        // Buscar contenedores de blog posts
        let blogContainers = document.querySelectorAll("#blog-posts-container");
        console.log("📝 Contenedores por ID encontrados:", blogContainers.length);
        
        // Si no encuentra por ID, buscar por atributo data
        if (blogContainers.length === 0) {
            blogContainers = document.querySelectorAll("[data-dynamic-blog=\"true\"] .grid");
            console.log("📝 Contenedores por atributo data encontrados:", blogContainers.length);
        }
        
        // Si aún no encuentra, buscar por clase
        if (blogContainers.length === 0) {
            blogContainers = document.querySelectorAll(".blog-grid .grid");
            console.log("📝 Contenedores por clase .blog-grid .grid:", blogContainers.length);
        }
        
        if (blogContainers.length === 0) {
            console.log("❌ No se encontraron contenedores de posts del blog");
            isLoading = false;
            return;
        }
        
        console.log("✅ Encontrados", blogContainers.length, "contenedores de posts del blog");
        
        blogContainers.forEach((container, index) => {
            console.log("📝 Procesando contenedor", index + 1);
            
        // Obtener el website ID del atributo data o usar el parámetro
        const containerWebsiteId = container.dataset.websiteId || "{{ $websiteId }}";
        console.log("🌐 Website ID:", containerWebsiteId);
        
        // Guardar el website ID globalmente para usar en los enlaces
        window.currentWebsiteId = containerWebsiteId;

            // Si hay website ID, cargar posts reales
            if (containerWebsiteId) {
                console.log("✅ Website ID encontrado, cargando posts del blog...");
                
                fetch(`/api/websites/${containerWebsiteId}/blog-posts?page=${page}&per_page=6`, {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => {
                    console.log("📡 Respuesta de la API:", response.status);
                    if (!response.ok) {
                        throw new Error("Error en la respuesta de la API: " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("📝 Datos recibidos:", data);
                    
                    let posts = [];
                    if (data && data.data && Array.isArray(data.data)) {
                        posts = data.data;
                    } else if (data && Array.isArray(data)) {
                        posts = data;
                    }
                    
                    // Verificar si hay más posts
                    hasMorePosts = posts.length >= 6;
                    
                    if (posts.length > 0) {
                        if (append) {
                            // Agregar posts a los existentes
                            allPosts = allPosts.concat(posts);
                            console.log("📝 Total posts acumulados:", allPosts.length);
                            renderRealBlogPosts(container, allPosts, true);
                        } else {
                            // Primera carga
                            allPosts = posts;
                            console.log("📝 Primera carga, posts:", allPosts.length);
                            renderRealBlogPosts(container, posts, false);
                        }
                        
                        // Agregar buscador de posts
                        addBlogSearch(container);
                        
                        // Actualizar enlace "Ver Todos los Artículos"
                        updateBlogListLink();
                        
                        // Configurar scroll infinito
                        if (hasMorePosts) {
                            setupInfiniteScroll();
                        } else {
                            console.log("🏁 No hay más posts disponibles, scroll infinito desactivado");
                        }
                    } else {
                        if (!append) {
                            console.log("⚠️ No se encontraron posts, mostrando posts de ejemplo");
                            showExampleBlogPosts(container);
                        }
                    }
                    
                    isLoading = false;
                })
                .catch(error => {
                    console.error("❌ Error al cargar posts del blog:", error);
                    if (!append) {
                        showExampleBlogPosts(container);
                    }
                    isLoading = false;
                });
            } else {
                console.log("⚠️ No hay Website ID configurado, mostrando posts de ejemplo");
                showExampleBlogPosts(container);
                isLoading = false;
            }
        });
    }
    
    // Función para renderizar posts reales
    function renderRealBlogPosts(container, posts, append = false) {
        console.log("🎨 Renderizando", posts.length, "posts del blog");
        
        if (!append) {
            container.innerHTML = "";
        }
        
        posts.forEach((post, index) => {
            const postElement = createBlogPostElement(post);
            container.appendChild(postElement);
        });
        
        console.log("✅ Posts del blog renderizados correctamente");
    }
    
    // Función para crear elemento HTML de un post
    function createBlogPostElement(post) {
        console.log("📝 Creando elemento para post:", post);
        
        const postDiv = document.createElement('article');
        postDiv.className = 'bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow';
        
        // Calcular tiempo de lectura
        const readTime = calculateReadTime(post.content || '');
        
        // Crear excerpt
        const excerpt = post.excerpt || stripHtmlTags(post.content || '').substring(0, 150) + '...';
        
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
        const publishDate = new Date(post.created_at || post.published_at).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Usar slug como fallback si no hay ID
        const postId = post.id || post.slug || 'sin-id';
        
        postDiv.innerHTML = `
            <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                ${categoryBadge}
            </div>
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>${publishDate}</span>
                    <span class="mx-2">•</span>
                    <span>${readTime} min lectura</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">
                    <a href="/creator/websites/${window.currentWebsiteId || '1'}/preview/blog/${post.id}">${escapeHtml(post.title)}</a>
                </h3>
                <p class="text-gray-600 mb-4">${escapeHtml(excerpt)}</p>
                ${tagsHtml}
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Autor</span>
                    </div>
                    <a href="/creator/websites/${window.currentWebsiteId || '1'}/preview/blog/${post.id}" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
                </div>
            </div>
        `;
        
        return postDiv;
    }
    
    // Función para mostrar posts de ejemplo
    function showExampleBlogPosts(container) {
        console.log("📝 Mostrando posts de ejemplo");
        
        const examplePosts = [
            {
                id: 1,
                title: "Guía Completa de Desarrollo Web",
                excerpt: "Aprende los fundamentos del desarrollo web moderno con esta guía completa que cubre HTML, CSS, JavaScript y frameworks populares.",
                date: "15 Enero, 2024",
                readTime: "5",
                category: { name: "Tecnología" },
                tags: [{ name: "Web" }, { name: "Desarrollo" }],
                slug: "guia-desarrollo-web"
            },
            {
                id: 2,
                title: "Mejores Prácticas de SEO",
                excerpt: "Descubre las estrategias más efectivas para optimizar tu sitio web y mejorar tu posicionamiento en los motores de búsqueda.",
                date: "12 Enero, 2024",
                readTime: "7",
                category: { name: "Marketing" },
                tags: [{ name: "SEO" }, { name: "Optimización" }],
                slug: "mejores-practicas-seo"
            },
            {
                id: 3,
                title: "Diseño UX/UI Moderno",
                excerpt: "Explora las tendencias actuales en diseño de interfaces de usuario y experiencia de usuario para crear productos digitales atractivos.",
                date: "10 Enero, 2024",
                readTime: "4",
                category: { name: "Diseño" },
                tags: [{ name: "UX" }, { name: "UI" }],
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
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Buscar
                </button>
            </div>
        `;
        
        container.parentElement.insertBefore(searchDiv, container);
        
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
        console.log("🔍 Buscando posts:", { query, sortBy });
        
        const containerWebsiteId = document.querySelector("#blog-posts-container")?.dataset.websiteId || "{{ $websiteId }}";
        
        if (!containerWebsiteId) {
            console.log("❌ No hay Website ID para buscar posts");
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
        switch(sortBy) {
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
        
        // Hacer petición a la API con filtros
        fetch(`/api/websites/${containerWebsiteId}/blog-posts?${searchParams.toString()}`, {
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
                    <div class="col-span-full text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No se encontraron artículos</h3>
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
        if (blogListLink && window.currentWebsiteId) {
            blogListLink.href = `/creator/websites/${window.currentWebsiteId}/preview/blog`;
            console.log("🔗 Enlace 'Ver Todos los Artículos' actualizado:", blogListLink.href);
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
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Inicializar carga de posts
    loadRealBlogPosts(1, false);
});
</script>
