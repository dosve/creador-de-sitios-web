<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Creador') - Creador de Sitios Web</title>
    @vite('resources/js/app.js')
    @stack('styles')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="flex-shrink-0 hidden overflow-hidden transition-all duration-300 transform bg-white border-r border-gray-200 md:flex md:flex-col md:w-64">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center justify-between flex-shrink-0 px-4">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sidebar-text">
                            <h1 class="text-lg font-semibold text-gray-900">Creador Web</h1>
                            <p class="text-xs text-gray-500">Panel Creador</p>
                        </div>
                    </div>
                    <!-- Desktop toggle button -->
                    <button type="button" id="desktop-sidebar-toggle" class="hidden p-1 text-gray-400 rounded-md md:block hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <div class="flex flex-col flex-grow mt-8">
                    <nav class="flex-1 px-2 space-y-1">
                    <!-- Inicio -->
                        <a href="{{ route('creator.dashboard') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.dashboard') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            <span class="sidebar-text">Inicio</span>
                    </a>

                        <!-- Diseño y Contenido -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <div class="space-y-1">
                                    <button type="button" class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="toggleSubmenu('design')">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                        </svg>
                                        <span class="sidebar-text">Diseño y Contenido</span>
                                        <svg class="w-5 h-5 ml-auto transition-transform transform sidebar-text" id="design-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="space-y-1 pl-11 {{ request()->routeIs('creator.templates.*') || request()->routeIs('creator.pages.*') || request()->routeIs('creator.media.*') ? '' : 'hidden' }}" id="design-submenu">
                                        <a href="{{ route('creator.templates.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.templates.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                            </svg>
                                            Plantillas
                                        </a>
                                        <a href="{{ route('creator.pages.index', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.pages.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Páginas
                                        </a>
                                        <a href="{{ route('creator.media.index', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.media.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Biblioteca Multimedia
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Blog -->
                        @if(session('selected_website_id'))
                        <div class="space-y-1">
                            <button type="button" class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="toggleSubmenu('blog')">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Blog
                                <svg class="w-5 h-5 ml-auto transition-transform transform" id="blog-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="space-y-1 pl-11 {{ request()->routeIs('creator.blog.*') || request()->routeIs('creator.comments.*') ? '' : 'hidden' }}" id="blog-submenu">
                                @if(session('selected_website_id'))
                                    @php
                                        $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                                    @endphp
                                    @if($selectedWebsite)
                                        <a href="{{ route('creator.blog.index', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.blog.index') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                            Artículos
                                        </a>
                                        <a href="{{ route('creator.categories.index', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.categories.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categorías
                                </a>
                                        <a href="{{ route('creator.comments.index', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.comments.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Comentarios
                                </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endif


                        <!-- SEO -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <a href="{{ route('creator.seo.index', $selectedWebsite) }}"
                                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.seo.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            SEO & Analytics
                        </a>
                            @endif
                        @endif

                        <!-- Formularios -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <a href="{{ route('creator.forms.index', $selectedWebsite) }}"
                                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.forms.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Formularios
                        </a>
                            @endif
                        @endif

                        <!-- Tienda en Línea -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <div class="space-y-1">
                                    <button type="button" class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="toggleSubmenu('store')">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Tienda en Línea
                                        <svg class="w-5 h-5 ml-auto transition-transform transform" id="store-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="space-y-1 pl-11 {{ request()->routeIs('creator.store.*') ? '' : 'hidden' }}" id="store-submenu">
                                        <a href="{{ route('creator.store.products', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.store.products*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Productos
                                        </a>
                                        <a href="{{ route('creator.store.categories', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.store.categories*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Categorías
                                        </a>
                                        <a href="{{ route('creator.store.orders', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.store.orders*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            Pedidos
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Usuarios -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <a href="{{ route('creator.users.index', $selectedWebsite) }}"
                                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.users.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg"" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19.75c0-2.09-1.67-5.068-4-5.727m-2 5.727c0-2.651-2.686-6-6-6s-6 3.349-6 6m9-12.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0m3 3a3 3 0 1 0 0-6"/></svg>
                                    Usuarios
                                </a>
                            @endif
                        @endif

                        <!-- Integraciones -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <div class="space-y-1">
                                    <button type="button" class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="toggleSubmenu('integrations')">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        Integraciones
                                        <svg class="w-5 h-5 ml-auto transition-transform transform" id="integrations-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="space-y-1 pl-11 {{ request()->routeIs('creator.integrations.*') ? '' : 'hidden' }}" id="integrations-submenu">
                                        <a href="{{ route('creator.integrations.epayco', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.integrations.epayco*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            Epayco - Pagos
                                        </a>
                                        <a href="{{ route('creator.integrations.admin-negocios', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.integrations.admin-negocios*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Admin Negocios - Inventarios
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif


                        <!-- Configuración -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <div class="space-y-1">
                                    <button type="button" class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="toggleSubmenu('config')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Configuración
                                        <svg class="w-5 h-5 ml-auto transition-transform transform" id="config-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="space-y-1 pl-11 {{ request()->routeIs('creator.websites.edit') || request()->routeIs('creator.config.*') ? '' : 'hidden' }}" id="config-submenu">
                                        <a href="{{ route('creator.websites.edit', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.websites.edit') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Información General
                                        </a>
                                        <a href="{{ route('creator.config.domain', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.config.domain*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" viewBox="0 0 1024 999"><path fill="currentColor" d="M858 758q31-94 39-194h127q-13 102-66 194zm0-517h100q53 92 66 194H897q-8-100-39-194M750 42q55 29 102 70h-52q-24-40-50-70M577 435V241h158q27 91 33 194zm0-435q59 30 105 112H577zM289 758q-27-91-33-194h191v194zm0-517h158v194H256q6-103 33-194M447 0v112H342Q388 30 447 0M172 112q47-41 102-70q-26 30-50 70zM0 435q13-102 66-194h100q-31 94-39 194zm166 323H66Q13 666 0 564h127q8 100 39 194m58 129q24 40 50 70q-55-29-102-70zm223 0v112q-59-31-105-112zm130-323h191q-6 103-33 194H577zm105 323q-46 81-105 112V887zm170 0q-46 41-102 70q26-30 50-70z"/></svg>
                                            Dominio Personalizado
                                        </a>
                                        <a href="{{ route('creator.config.security', $selectedWebsite) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('creator.config.security*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            SSL y Seguridad
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif


                    </nav>
                </div>

                <!-- User Menu -->
                <div class="flex flex-shrink-0 p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full">
                                <span class="text-sm font-medium text-gray-700">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button type="button" id="mobile-menu-button" class="md:hidden -ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
                            <span class="sr-only">Abrir sidebar</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Desktop sidebar toggle button (shown when sidebar is collapsed) -->
                        <button type="button" id="desktop-sidebar-toggle-header" class="hidden p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <div>
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Panel de Creador')</h1>
                            @if(session('selected_website_id'))
                                @php
                                    $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                                @endphp
                                @if($selectedWebsite)
                                    <div class="flex items-center mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            {{ $selectedWebsite->name }}
                                        </span>
                                        <a href="{{ route('creator.select-website') }}" class="ml-2 text-xs text-blue-600 hover:text-blue-800">
                                            Cambiar sitio
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Quick Actions -->
                        @if(request()->routeIs('creator.media.*'))
                        <button onclick="openUploadModal()" class="px-3 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Subir Archivos
                        </button>
                        @endif

                        <!-- Vista Previa -->
                        @if(session('selected_website_id'))
                            @php
                                $selectedWebsite = \App\Models\Website::find(session('selected_website_id'));
                            @endphp
                            @if($selectedWebsite)
                                <a href="{{ route('creator.preview.index', $selectedWebsite) }}" 
                                   target="_blank" 
                                   class="flex items-center px-3 py-1 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Vista Previa
                                </a>
                            @endif
                        @endif


                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-50 w-48 py-1 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                                
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                                
                                <a href="{{ route('creator.select-website') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                    </svg>
                                    Ver Mis Sitios Web
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        @if(session('success'))
                        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                            {{ session('error') }}
                        </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId + '-submenu');
            const arrow = document.getElementById(menuId + '-arrow');

            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Sidebar toggle functionality
       document.addEventListener('DOMContentLoaded', function () {
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const desktopToggleButton = document.getElementById('desktop-sidebar-toggle');          // el de la barra lateral
  const desktopToggleHeaderButton = document.getElementById('desktop-sidebar-toggle-header'); // el del header
  const sidebar = document.getElementById('sidebar');

  // estado inicial desde localStorage
  const isClosed = localStorage.getItem('sidebar-closed') === 'true';
  if (isClosed) closeSidebar(); else openSidebar();

  function closeSidebar() {
    // oculta en desktop: desplaza fuera de vista
    sidebar.classList.add('-ml-64');
    // opcional: quitar el borde para que no se vea una línea
    sidebar.classList.remove('border-r');
    localStorage.setItem('sidebar-closed', 'true');

    // muestra el botón hamburguesa del header para abrir
    if (desktopToggleHeaderButton) desktopToggleHeaderButton.classList.remove('hidden');
  }

  function openSidebar() {
    sidebar.classList.remove('-ml-64');
    sidebar.classList.add('border-r');
    localStorage.setItem('sidebar-closed', 'false');

    if (desktopToggleHeaderButton) desktopToggleHeaderButton.classList.add('hidden');
  }

  function toggleSidebar() {
    if (sidebar.classList.contains('-ml-64')) openSidebar();
    else closeSidebar();
  }

  // Mobile: abre/cierra mostrando el elemento (en móvil usamos hidden)
  if (mobileMenuButton && sidebar) {
    mobileMenuButton.addEventListener('click', function () {
      // en móvil, simplemente mostramos/ocultamos
      sidebar.classList.toggle('hidden');
      // por si estaba desplazado de un estado previo de desktop
      sidebar.classList.remove('-ml-64');
    });
  }

  if (desktopToggleButton) {
    desktopToggleButton.addEventListener('click', toggleSidebar);
  }

  if (desktopToggleHeaderButton) {
    desktopToggleHeaderButton.addEventListener('click', openSidebar);
  }

  // Resize: en desktop (>= md) asegúrate que NO esté hidden
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      sidebar.classList.remove('hidden'); // visible (abierto o cerrado off-canvas)
    } else {
      // en móvil, si estaba cerrado, mantenlo escondido
      if (localStorage.getItem('sidebar-closed') === 'true') {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('-ml-64');
      }
    }
  });
});

    </script>

    @stack('scripts')
</body>

</html>