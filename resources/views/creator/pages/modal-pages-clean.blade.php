<!-- Modal de Navegación de Páginas -->
<div class="fixed inset-0 z-50 hidden overflow-y-auto" id="pagesNavigationModal" aria-labelledby="pagesNavigationModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo oscuro -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
        
        <!-- Modal -->
        <div class="inline-block w-full max-w-6xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold flex items-center" id="pagesNavigationModalLabel">
                        <i class="fas fa-compass mr-3 text-2xl"></i>
                        Navegador de Páginas
                    </h3>
                    <button type="button" class="text-white hover:text-gray-200 text-2xl" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-6">
                <!-- Filtros -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                               id="pageSearch" 
                               placeholder="Buscar páginas...">
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                        <select class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white" id="categoryFilter">
                            <option value="">Todas las categorías</option>
                            <option value="ecommerce">🛒 Tiendas Online</option>
                            <option value="business">💼 Negocios y Servicios</option>
                            <option value="health">🏥 Salud y Bienestar</option>
                            <option value="education">🎓 Educación</option>
                            <option value="creative">🎨 Creativos y Portfolio</option>
                            <option value="events">🎪 Eventos y Entretenimiento</option>
                        </select>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600" id="totalPages">0</div>
                            <div class="text-sm text-blue-700 font-medium">Total Páginas</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600" id="filteredPages">0</div>
                            <div class="text-sm text-green-700 font-medium">Mostradas</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600" id="selectedPages">0</div>
                            <div class="text-sm text-purple-700 font-medium">Seleccionadas</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border border-orange-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">6</div>
                            <div class="text-sm text-orange-700 font-medium">Categorías</div>
                        </div>
                    </div>
                </div>

                <!-- Lista de páginas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="pagesGrid">
                    <!-- Las páginas se cargarán aquí -->
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" 
                        class="px-6 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500" 
                        onclick="closeModal()">
                    <i class="fas fa-times mr-2"></i>
                    Cerrar
                </button>
                <button type="button" 
                        class="px-6 py-2 text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:ring-2 focus:ring-indigo-500" 
                        id="importSelectedPages">
                    <i class="fas fa-download mr-2"></i>
                    Importar Seleccionadas
                </button>
            </div>
        </div>
    </div>
</div>
