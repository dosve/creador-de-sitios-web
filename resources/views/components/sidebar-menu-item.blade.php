@props(['item'])

@php
    $selectedWebsite = session('selected_website_id') ? \App\Models\Website::find(session('selected_website_id')) : null;
    
    // Verificar si este item requiere un sitio web seleccionado
    if (($item['requires_website'] ?? false) && !$selectedWebsite) {
        return; // No mostrar este item
    }
    
    // Determinar si es un dropdown (tiene sub-items)
    $isDropdown = isset($item['items']) && is_array($item['items']);
    
    // Verificar si está activo
    $isActive = false;
    if (isset($item['active_routes'])) {
        foreach ($item['active_routes'] as $route) {
            if (request()->routeIs($route)) {
                $isActive = true;
                break;
            }
        }
    }
@endphp

@if($isDropdown)
    {{-- DROPDOWN MENU --}}
    <div class="space-y-1">
        <button type="button" 
                class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500" 
                onclick="toggleSubmenu('{{ $item['id'] }}')">
            {{-- Icon --}}
            @if(isset($item['icon_custom']))
                {!! $item['icon_custom'] !!}
            @elseif(isset($item['icon_svg']))
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon_svg'] }}"></path>
                </svg>
            @endif
            
            <span class="sidebar-text">{{ $item['title'] }}</span>
            
            {{-- Arrow --}}
            <svg class="w-5 h-5 ml-auto transition-transform transform sidebar-text" 
                 id="{{ $item['id'] }}-arrow" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        {{-- Submenu items --}}
        <div class="space-y-1 pl-11 {{ $isActive ? '' : 'hidden' }}" id="{{ $item['id'] }}-submenu">
            @foreach($item['items'] as $subItem)
                @php
                    $isSubActive = false;
                    if (isset($subItem['active_routes'])) {
                        foreach ($subItem['active_routes'] as $route) {
                            if (request()->routeIs($route)) {
                                $isSubActive = true;
                                break;
                            }
                        }
                    }
                @endphp
                
                <a href="{{ route($subItem['route']) }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ $isSubActive ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{-- Sub-item Icon --}}
                    @if(isset($subItem['icon_custom']))
                        {!! $subItem['icon_custom'] !!}
                    @elseif(isset($subItem['icon_svg']))
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $subItem['icon_svg'] }}"></path>
                        </svg>
                    @endif
                    
                    {{ $subItem['title'] }}
                </a>
            @endforeach
        </div>
    </div>
@else
    {{-- SIMPLE MENU ITEM --}}
    <a href="{{ route($item['route']) }}" 
       @if(isset($item['target'])) target="{{ $item['target'] }}" @endif
       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ $isActive ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        {{-- Icon --}}
        @if(isset($item['icon_custom']))
            {!! $item['icon_custom'] !!}
        @elseif(isset($item['icon_svg']))
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon_svg'] }}"></path>
            </svg>
        @endif
        
        <span class="sidebar-text">{{ $item['title'] }}</span>
    </a>
@endif


