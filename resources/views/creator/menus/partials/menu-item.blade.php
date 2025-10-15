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
                <p class="text-sm text-gray-600">
                    @if($item->page)
                        📄 {{ $item->page->title }}
                    @elseif($item->url)
                        🔗 {{ $item->url }}
                    @else
                        ⚠️ Sin enlace
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
                class="text-blue-600 hover:text-blue-800 text-sm">
                    ✏️
                </button>
                <button onclick="deleteItem({{ $item->id }})" 
                        class="text-red-600 hover:text-red-800 text-sm">
                    🗑️
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
