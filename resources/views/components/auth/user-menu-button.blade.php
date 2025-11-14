{{--
    Componente de menú de usuario descentralizado
    
    Este componente muestra el botón de usuario que cambia automáticamente entre:
    - Menú de invitado (no autenticado) con botón de login
    - Menú de usuario autenticado con dropdown
    
    El JavaScript que maneja la lógica está en: components/auth/user-auth-script.blade.php
    
    Uso:
    <x-auth.user-menu-button :website="$website" />
    
    Opcional - personalizar clases:
    <x-auth.user-menu-button :website="$website" buttonClass="text-white" />
--}}

@props([
'website',
'buttonClass' => 'text-gray-600 hover:text-gray-900',
'dropdownClass' => 'bg-white rounded-lg shadow-lg border border-gray-200',
'showName' => true
])

<div class="relative" id="user-menu-container">
  {{-- Menú de invitado (no autenticado) --}}
  <div id="guest-menu" class="hidden">
    <button id="login-button" class="p-2 transition-colors {{ $buttonClass }}">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
      </svg>
    </button>
  </div>

  {{-- Menú de usuario autenticado --}}
  <div id="user-menu" class="hidden">
    <button id="user-menu-button" class="flex items-center space-x-2 p-2 transition-colors {{ $buttonClass }}">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
      </svg>
      @if($showName)
      <span id="user-name" class="hidden text-sm font-medium md:inline"></span>
      @endif
    </button>

    {{-- Dropdown de usuario --}}
    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 py-1 {{ $dropdownClass }}">
      <a href="/{{ $website->slug ?? '' }}/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Mi Perfil
      </a>
      <a href="/{{ $website->slug ?? '' }}/my-orders" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
        Mis Órdenes
      </a>
      <div class="border-t border-gray-200 my-1"></div>
      <button id="logout-button" class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Cerrar Sesión
      </button>
    </div>
  </div>
</div>
