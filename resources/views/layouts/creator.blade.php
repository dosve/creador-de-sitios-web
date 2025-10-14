<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Creador') - Creador de Sitios Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        {{-- Menú dinámico desde configuración --}}
                        @foreach(config('creator-menu.items') as $menuItem)
                            <x-sidebar-menu-item :item="$menuItem" />
                        @endforeach
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
                                <a href="{{ route('website.show', $selectedWebsite->slug) }}" 
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
                                
                                {{-- Items del dropdown del usuario desde configuración --}}
                                @foreach(config('creator-menu.user_dropdown') as $dropdownItem)
                                    @if(isset($dropdownItem['type']) && $dropdownItem['type'] === 'divider')
                                        <div class="border-t border-gray-200"></div>
                                    @elseif(isset($dropdownItem['method']) && $dropdownItem['method'] === 'POST')
                                        <form method="POST" action="{{ route($dropdownItem['route']) }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                @if(isset($dropdownItem['icon_svg']))
                                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $dropdownItem['icon_svg'] }}"></path>
                                                    </svg>
                                                @endif
                                                {{ $dropdownItem['title'] }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route($dropdownItem['route']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            @if(isset($dropdownItem['icon_svg']))
                                                <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $dropdownItem['icon_svg'] }}"></path>
                                                </svg>
                                            @endif
                                            {{ $dropdownItem['title'] }}
                                        </a>
                                    @endif
                                @endforeach
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