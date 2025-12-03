<!-- Media Selector Modal -->
<div id="mediaSelectorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4 pb-3 border-b">
            <h3 class="text-lg font-medium text-gray-900">Seleccionar Imagen de la Biblioteca</h3>
            <button onclick="closeMediaSelector()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Media Grid -->
        <div id="mediaGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4 max-h-96 overflow-y-auto">
            <!-- Las imágenes se cargarán aquí dinámicamente -->
            <div class="col-span-full text-center py-8 text-gray-500">
                Cargando imágenes...
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center pt-3 border-t">
            <a href="{{ route('creator.media.index') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                Ir a Biblioteca Multimedia
            </a>
            <button onclick="closeMediaSelector()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                Cancelar
            </button>
        </div>
    </div>
</div>

<style>
.media-item {
    cursor: pointer;
    transition: all 0.2s;
}
.media-item:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.media-item.selected {
    ring: 2px;
    ring-color: #3B82F6;
    ring-offset: 2px;
}
</style>

<script>
let mediaSelectCallback = null;
let selectedMediaUrl = null;

function openMediaSelector(callback) {
    mediaSelectCallback = callback;
    document.getElementById('mediaSelectorModal').classList.remove('hidden');
    loadMediaLibrary();
}

function closeMediaSelector() {
    document.getElementById('mediaSelectorModal').classList.add('hidden');
    mediaSelectCallback = null;
    selectedMediaUrl = null;
}

function loadMediaLibrary() {
    const grid = document.getElementById('mediaGrid');
    
    fetch('{{ route("creator.media.api.list") }}')
        .then(response => response.json())
        .then(data => {
            if (!data.success || data.files.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No hay imágenes en la biblioteca</p>
                        <a href="{{ route('creator.media.index') }}" target="_blank" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                            Subir imágenes
                        </a>
                    </div>
                `;
                return;
            }
            
            let gridHTML = '';
            data.files.forEach((file) => {
                const url = file.url;
                const alt = file.alt_text || file.filename;
                
                gridHTML += `
                    <div class="media-item bg-white border border-gray-200 rounded-lg p-2 hover:shadow-lg transition-shadow" onclick="selectMedia('${url}', this)">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-2">
                            <img src="${url}" alt="${alt}" class="w-full h-full object-cover" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><text x=%2250%%22 y=%2250%%22 text-anchor=%22middle%22 dy=%22.3em%22>❌</text></svg>'">
                        </div>
                        <p class="text-xs text-gray-600 truncate" title="${alt}">${alt}</p>
                        <div class="mt-2">
                            <button type="button" class="w-full bg-blue-600 text-white text-xs py-1 px-2 rounded hover:bg-blue-700">
                                Seleccionar
                            </button>
                        </div>
                    </div>
                `;
            });
            
            grid.innerHTML = gridHTML;
        })
        .catch(error => {
            console.error('Error al cargar la biblioteca:', error);
            grid.innerHTML = `
                <div class="col-span-full text-center py-8 text-red-500">
                    <p>Error al cargar las imágenes</p>
                    <button onclick="loadMediaLibrary()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                        Reintentar
                    </button>
                </div>
            `;
        });
}

function selectMedia(url, element) {
    selectedMediaUrl = url;
    
    // Remover la clase 'selected' de todos los elementos
    document.querySelectorAll('.media-item').forEach(item => {
        item.classList.remove('selected', 'ring-2', 'ring-blue-500');
    });
    
    // Agregar la clase 'selected' al elemento clicado
    element.classList.add('selected', 'ring-2', 'ring-blue-500');
    
    // Ejecutar el callback con la URL seleccionada
    if (mediaSelectCallback) {
        mediaSelectCallback(url);
        closeMediaSelector();
    }
}
</script>

