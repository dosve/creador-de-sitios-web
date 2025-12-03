<?php

return [
    

    'items' => [
        // Inicio / Dashboard
        [
            'title' => 'Inicio',
            'route' => 'creator.dashboard',
            'icon_svg' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
            'active_routes' => ['creator.dashboard'],
            'requires_website' => false,
        ],

        // ============================================
        // DROPDOWN: Diseño y Contenido
        // ============================================
        // Este es un ejemplo de DROPDOWN con sub-items
        // Tiene 'id' y 'items' en lugar de 'route'
        [
            'title' => 'Diseño y Contenido',
            'id' => 'design',  // ID único para el toggle (onclick="toggleSubmenu('design')")
            'icon_svg' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z',
            'active_routes' => ['creator.templates.*', 'creator.pages.*', 'creator.media.*', 'creator.menus.*'],
            'requires_website' => true,
            'items' => [  // IMPORTANTE: Si tiene 'items', es un DROPDOWN
                [
                    'title' => 'Plantillas',
                    'route' => 'creator.templates.index',
                    'icon_svg' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z',
                    'active_routes' => ['creator.templates.*'],
                ],
                [
                    'title' => 'Páginas',
                    'route' => 'creator.pages.index',
                    'icon_svg' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'active_routes' => ['creator.pages.*'],
                ],
                [
                    'title' => 'Biblioteca Multimedia',
                    'route' => 'creator.media.index',
                    'icon_svg' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'active_routes' => ['creator.media.*'],
                    'params_session' => true, // Usa session('selected_website_id')
                ],
                [
                    'title' => 'Menús',
                    'route' => 'creator.menus.index',
                    'icon_svg' => 'M4 6h16M4 12h16M4 18h16',
                    'active_routes' => ['creator.menus.*'],
                ],
            ],
        ],

        // ============================================
        // DROPDOWN: Blog
        // ============================================
        [
            'title' => 'Blog',
            'id' => 'blog',  // ID único para el toggle
            'icon_svg' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
            'active_routes' => ['creator.blog.*', 'creator.categories.*', 'creator.comments.*'],
            'requires_website' => true,
            'items' => [  // DROPDOWN con sub-items
                [
                    'title' => 'Artículos',
                    'route' => 'creator.blog.index',
                    'icon_svg' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                    'active_routes' => ['creator.blog.index'],
                ],
                [
                    'title' => 'Categorías',
                    'route' => 'creator.categories.index',
                    'icon_svg' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    'active_routes' => ['creator.categories.*'],
                ],
                [
                    'title' => 'Comentarios',
                    'route' => 'creator.comments.index',
                    'icon_svg' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                    'active_routes' => ['creator.comments.*'],
                    'params_session' => true,
                ],
            ],
        ],

        // ============================================
        // DROPDOWN: Tienda
        // ============================================
        [
            'title' => 'Tienda',
            'id' => 'store',  // ID para toggle
            'icon_svg' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
            'active_routes' => ['creator.store.*'],
            'requires_website' => true,
            'items' => [  // DROPDOWN
                [
                    'title' => 'Productos',
                    'route' => 'creator.store.products',
                    'icon_svg' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                    'active_routes' => ['creator.store.products*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Categorías',
                    'route' => 'creator.store.categories',
                    'icon_svg' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    'active_routes' => ['creator.store.categories*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Pedidos',
                    'route' => 'creator.store.orders',
                    'icon_svg' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    'active_routes' => ['creator.store.orders*'],
                    // Sin params_session - usa sesión internamente
                ],
            ],
        ],

        // ============================================
        // ITEM SIMPLE: Formularios
        // ============================================
        [
            'title' => 'Formularios',
            'route' => 'creator.forms.index',  // SIMPLE (no dropdown)
            'icon_svg' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'active_routes' => ['creator.forms.*'],
            'requires_website' => true,
            // Sin params_session - usa sesión internamente
        ],

        // Usuarios
        [
            'title' => 'Usuarios',
            'route' => 'creator.users.index',
            'icon_svg' => null, // SVG personalizado en la vista
            'icon_custom' => '<svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19.75c0-2.09-1.67-5.068-4-5.727m-2 5.727c0-2.651-2.686-6-6-6s-6 3.349-6 6m9-12.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0m3 3a3 3 0 1 0 0-6"/></svg>',
            'active_routes' => ['creator.users.*'],
            'requires_website' => true,
            'params_session' => true,
        ],

        // ============================================
        // ITEM SIMPLE: SEO & Analytics
        // ============================================
        [
            'title' => 'SEO & Analytics',
            'route' => 'creator.seo.index',
            'icon_svg' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            'active_routes' => ['creator.seo.*'],
            'requires_website' => true,
        ],

        // ============================================
        // DROPDOWN: Integraciones
        // ============================================
        [
            'title' => 'Integraciones',
            'id' => 'integrations',  // ID para toggle
            'icon_svg' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'active_routes' => ['creator.integrations.*'],
            'requires_website' => true,
            'items' => [  // DROPDOWN
                [
                    'title' => 'Epayco - Pagos',
                    'route' => 'creator.integrations.epayco',
                    'icon_svg' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                    'active_routes' => ['creator.integrations.epayco*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Admin Negocios',
                    'route' => 'creator.integrations.admin-negocios',
                    'icon_svg' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                    'active_routes' => ['creator.integrations.admin-negocios*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Wompi - Pagos',
                    'route' => 'creator.integrations.wompi',
                    'icon_svg' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'active_routes' => ['creator.integrations.wompi*'],
                    // Sin params_session - usa sesión internamente
                ],
            ],
        ],

        // ============================================
        // DROPDOWN: Configuración
        // ============================================
        [
            'title' => 'Configuración',
            'id' => 'config',  // ID para toggle
            'icon_svg' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
            'active_routes' => ['creator.config.*'],
            'requires_website' => true,
            'items' => [  // DROPDOWN
                [
                    'title' => 'Información General',
                    'route' => 'creator.config.general',
                    'icon_svg' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                    'active_routes' => ['creator.config.general*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Dominio Personalizado',
                    'route' => 'creator.config.domain',
                    'icon_custom' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" viewBox="0 0 1024 999"><path fill="currentColor" d="M858 758q31-94 39-194h127q-13 102-66 194zm0-517h100q53 92 66 194H897q-8-100-39-194M750 42q55 29 102 70h-52q-24-40-50-70M577 435V241h158q27 91 33 194zm0-435q59 30 105 112H577zM289 758q-27-91-33-194h191v194zm0-517h158v194H256q6-103 33-194M447 0v112H342Q388 30 447 0M172 112q47-41 102-70q-26 30-50 70zM0 435q13-102 66-194h100q-31 94-39 194zm166 323H66Q13 666 0 564h127q8 100 39 194m58 129q24 40 50 70q-55-29-102-70zm223 0v112q-59-31-105-112zm130-323h191q-6 103-33 194H577zm105 323q-46 81-105 112V887zm170 0q-46 41-102 70q26-30 50-70z"/></svg>',
                    'active_routes' => ['creator.config.domain*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Seguridad y SSL',
                    'route' => 'creator.config.security',
                    'icon_svg' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'active_routes' => ['creator.config.security*'],
                    // Sin params_session - usa sesión internamente
                ],
                [
                    'title' => 'Métodos de Pago',
                    'route' => 'creator.config.payment-methods',
                    'icon_svg' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                    'active_routes' => ['creator.config.payment-methods*'],
                    // Sin params_session - usa sesión internamente
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menú de Usuario (Dropdown en Header)
    |--------------------------------------------------------------------------
    */
    'user_dropdown' => [
        [
            'title' => 'Ver Mis Sitios Web',
            'route' => 'creator.select-website',
            'icon_svg' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        ],
        [
            'type' => 'divider',
        ],
        [
            'title' => 'Cerrar Sesión',
            'route' => 'logout',
            'icon_svg' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
            'method' => 'POST',
        ],
    ],

   
];
