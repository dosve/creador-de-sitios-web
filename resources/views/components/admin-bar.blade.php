@props(['website'])

<!-- Barra de administración - ID: {{ uniqid() }} -->
<div class="admin-bar" data-admin-bar-id="{{ uniqid() }}">
    <div class="admin-bar-container">
        <!-- Lado izquierdo -->
        <div class="admin-bar-left">
            <div class="admin-bar-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span>{{ $website->name }}</span>
            </div>
            
            <div class="admin-bar-actions">
                <a href="{{ route('creator.dashboard') }}" class="admin-bar-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Panel de Administración
                </a>
                
                <a href="#" id="edit-current-page" class="admin-bar-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="m18.5 2.5 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Editar página actual
                </a>
                
                <div class="admin-bar-dropdown">
                    <a href="#" class="admin-bar-link" id="add-content-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Agregar contenido
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 4px;">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="admin-bar-dropdown-menu" id="add-content-menu">
                        <a href="{{ route('creator.pages.create') }}" class="admin-bar-dropdown-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            Nueva Página
                        </a>
                        <a href="{{ route('creator.blog.create') }}" class="admin-bar-dropdown-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Nueva Publicación
                        </a>
                        <a href="{{ route('creator.forms.create') }}" class="admin-bar-dropdown-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="9" x2="15" y2="9"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                            Nuevo Formulario
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lado derecho -->
        <div class="admin-bar-right">
            <span class="admin-bar-user">Hola, {{ auth()->user()->name }}</span>
            <div class="admin-bar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>
</div>

<style>
.admin-bar {
    background: #1f2937;
    color: white;
    font-size: 14px;
    position: relative;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 0;
}

.admin-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    height: 46px;
    max-width: 100%;
}

.admin-bar-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.admin-bar-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
}

.admin-bar-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.admin-bar-link {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #d1d5db;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    transition: all 0.2s ease;
    font-size: 13px;
}

.admin-bar-link:hover {
    background: #374151;
    color: white;
}

.admin-bar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.admin-bar-user {
    color: #d1d5db;
    font-size: 13px;
}

.admin-bar-avatar {
    width: 32px;
    height: 32px;
    background: #3b82f6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-bar-container {
        padding: 0 15px;
        height: 40px;
    }
    
    .admin-bar-logo span {
        display: none;
    }
    
    .admin-bar-user {
        display: none;
    }
    
    .admin-bar-actions {
        gap: 10px;
    }
    
    .admin-bar-link {
        padding: 4px 8px;
        font-size: 12px;
    }
    
    .admin-bar-link span {
        display: none;
    }
}

/* Dropdown menu styles */
.admin-bar-dropdown {
    position: relative;
}

.admin-bar-dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 8px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    min-width: 200px;
    padding: 8px 0;
    z-index: 10000;
}

.admin-bar-dropdown-menu.show {
    display: block;
}

.admin-bar-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    color: #374151;
    text-decoration: none;
    transition: background-color 0.2s ease-in-out;
}

.admin-bar-dropdown-item:hover {
    background-color: #F3F4F6;
}

.admin-bar-dropdown-item svg {
    flex-shrink: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dropdown menu toggle
    const addContentBtn = document.getElementById('add-content-btn');
    const addContentMenu = document.getElementById('add-content-menu');
    
    if (addContentBtn && addContentMenu) {
        addContentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            addContentMenu.classList.toggle('show');
        });
        
        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!addContentBtn.contains(e.target) && !addContentMenu.contains(e.target)) {
                addContentMenu.classList.remove('show');
            }
        });
        
        // Cerrar el menú al hacer clic en un elemento
        const dropdownItems = addContentMenu.querySelectorAll('.admin-bar-dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                addContentMenu.classList.remove('show');
            });
        });
    }
    
    // Edit current page button
    const editCurrentPageBtn = document.getElementById('edit-current-page');
    
    if (editCurrentPageBtn) {
        editCurrentPageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Obtener la URL actual
            const currentUrl = window.location.pathname;
            
            // Obtener el website del objeto
            const website = @json($website);
            if (!website || !website.id) {
                alert('No se pudo detectar el sitio web actual');
                return;
            }
            
            // Determinar la ruta de edición basada en la URL actual
            let editUrl = '';
            
            // Obtener el slug del sitio web de la URL
            const urlParts = currentUrl.split('/');
            const websiteSlug = urlParts[1]; // El primer segmento después del /
            
            if (currentUrl.includes('/blog/') && currentUrl !== '/blog') {
                // Es un post del blog individual - ir a la lista de blogs
                editUrl = `/creator/blog`;
            } else if (currentUrl.endsWith('/blog') || currentUrl.includes('/blog')) {
                // Es la lista del blog - ir a la lista de blogs
                editUrl = `/creator/blog`;
            } else if (currentUrl === '/' || currentUrl === `/${websiteSlug}`) {
                // Es la página de inicio - buscar la página de inicio
                fetch('/creator/api/current-page', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        url: currentUrl,
                        website_slug: websiteSlug
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.page_id) {
                        window.open(`/creator/pages/${data.page_id}/editor`, '_blank');
                    } else {
                        window.open('/creator/pages', '_blank');
                    }
                })
                .catch(() => {
                    window.open('/creator/pages', '_blank');
                });
                return;
            } else {
                // Es una página específica - buscar por slug
                const pageSlug = urlParts[urlParts.length - 1]; // El último segmento de la URL
                
                fetch('/creator/api/current-page', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        url: currentUrl,
                        website_slug: websiteSlug,
                        page_slug: pageSlug
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.page_id) {
                        window.open(`/creator/pages/${data.page_id}/editor`, '_blank');
                    } else {
                        window.open('/creator/pages', '_blank');
                    }
                })
                .catch(() => {
                    window.open('/creator/pages', '_blank');
                });
                return;
            }
            
            // Para blogs, abrir la lista
            window.open(editUrl, '_blank');
        });
    }
});
</script>
