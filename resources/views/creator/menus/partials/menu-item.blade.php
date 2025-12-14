<div class="menu-item p-4 hover:bg-gray-50" data-item-id="{{ $item->id }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="text-gray-400 cursor-move">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                </svg>
            </div>
            
            @if($item->icon)
                <span class="text-lg">{{ $item->icon }}</span>
            @endif
            
            <div>
                <h3 class="font-medium text-gray-900">{{ $item->title }}</h3>
                <p class="text-sm text-gray-600 flex items-center">
                    @if($item->page)
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ $item->page->title }}
                    @elseif($item->url)
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        {{ $item->url }}
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Sin enlace
                    @endif
                </p>
                @if($item->description)
                    <p class="text-xs text-gray-500 mt-1">{{ $item->description }}</p>
                @endif
            </div>
        </div>
        
        <div class="flex items-center space-x-2">
            @if($item->is_active)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Activo
                </span>
            @else
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Inactivo
                </span>
            @endif
            
            <div class="flex space-x-1">
                <button onclick="showEditItemModal(
                    {{ $item->id }}, 
                    '{{ addslashes($item->title) }}', 
                    '{{ $item->page ? 'page' : ($item->url ? 'custom' : 'external') }}', 
                    {{ $item->page_id ?? 'null' }}, 
                    '{{ addslashes($item->url ?? '') }}', 
                    '{{ $item->target }}', 
                    '{{ addslashes($item->icon ?? '') }}',
                    {{ $item->is_active ? 'true' : 'false' }}
                )" 
                class="text-blue-600 hover:text-blue-800 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>
                <button onclick="deleteItem({{ $item->id }})" 
                        class="text-red-600 hover:text-red-800 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    @if($item->children->count() > 0)
        <div class="ml-8 mt-3 space-y-2">
            @foreach($item->children as $child)
                @include('creator.menus.partials.menu-item', ['item' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
