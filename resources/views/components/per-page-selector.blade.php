@props(['perPageOptions' => [12, 24, 48, 96], 'label' => 'Por página:'])

<div class="flex items-center space-x-2">
    <label for="per_page" class="text-sm text-gray-700">{{ $label }}</label>
    <select id="per_page" onchange="changePerPage(this.value)" 
            class="text-sm border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @foreach($perPageOptions as $option)
            <option value="{{ $option }}" {{ request('per_page', 12) == $option ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
</div>

<script>
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to page 1 when changing per_page
    window.location.href = url.toString();
}
</script>
