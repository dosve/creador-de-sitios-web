@props(['pagination', 'showPerPageSelector' => true, 'perPageOptions' => [12, 24, 48, 96], 'label' => 'elementos'])

@if($pagination && $pagination['last_page'] > 1)
    <div class="flex items-center justify-between mt-6">
        <div class="flex items-center space-x-1">
            <div class="text-sm text-gray-700">
                Mostrando {{ $pagination['from'] }} a 
            </div>
            <!-- Selector de elementos por página integrado -->
            @if($showPerPageSelector)
                <select id="per_page" onchange="changePerPage(this.value)" 
                        class="px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($perPageOptions as $option)
                        <option value="{{ $option }}" {{ request('per_page', 12) == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            @else
                <span class="text-sm text-gray-700">{{ $pagination['to'] }}</span>
            @endif
            <div class="text-sm text-gray-700">
                de {{ $pagination['total'] }} {{ $label }}
            </div>
        </div>
        
        <div class="flex items-center space-x-4">

            <!-- Controles de paginación -->
            <div class="flex items-center space-x-2">
                <!-- Página anterior -->
                @if($pagination['current_page'] > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}" 
                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Anterior
                    </a>
                @endif

                <!-- Números de página -->
                @php
                    $start = max(1, $pagination['current_page'] - 2);
                    $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" 
                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">1</a>
                    @if($start > 2)
                        <span class="px-3 py-2 text-sm text-gray-500">...</span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" 
                       class="px-3 py-2 text-sm font-medium {{ $i == $pagination['current_page'] ? 'text-blue-600 bg-blue-50 border-blue-500' : 'text-gray-500 bg-white border-gray-300' }} border rounded-md hover:bg-gray-50">
                        {{ $i }}
                    </a>
                @endfor

                @if($end < $pagination['last_page'])
                    @if($end < $pagination['last_page'] - 1)
                        <span class="px-3 py-2 text-sm text-gray-500">...</span>
                    @endif
                    <a href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page']]) }}" 
                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $pagination['last_page'] }}</a>
                @endif

                <!-- Página siguiente -->
                @if($pagination['current_page'] < $pagination['last_page'])
                    <a href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}" 
                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Siguiente
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif

<script>
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to page 1 when changing per_page
    window.location.href = url.toString();
}
</script>
