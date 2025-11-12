<!-- Hero Section - Vista Previa del Navegador -->
<div class="relative py-20 mb-8 overflow-hidden">
    <!-- Imagen de fondo -->
    <div class="absolute inset-0">
        <img src="https://picsum.photos/1920/1080?random=hero" 
             alt="Hero Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/90 to-purple-600/90"></div>
    </div>
    
    <!-- Elementos decorativos -->
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-white opacity-5 rounded-full"></div>
    
    <div class="max-w-6xl mx-auto px-4 text-center relative z-10">
        <div class="mb-6">
            <span class="inline-block bg-white bg-opacity-20 text-white px-4 py-2 rounded-full text-sm font-medium mb-4">
                🎉 Oferta Especial
            </span>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
            {{ $block['title'] ?? 'Descubre Productos Increíbles' }}
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-indigo-100 max-w-3xl mx-auto leading-relaxed">
            {{ $block['subtitle'] ?? 'Encuentra la mejor selección de productos con envío gratis y garantía de satisfacción' }}
        </p>
        
        <!-- Características destacadas -->
        <div class="flex flex-wrap justify-center gap-6 mb-10 text-sm">
            <div class="flex items-center">
                <i class="fas fa-shipping-fast mr-2 text-yellow-300"></i>
                <span>Envío Gratis</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-shield-alt mr-2 text-yellow-300"></i>
                <span>Compra Segura</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-undo mr-2 text-yellow-300"></i>
                <span>30 Días Devolución</span>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button class="bg-white text-indigo-600 px-10 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-shopping-cart mr-2"></i>
                {{ $block['primary_button'] ?? 'Ver Productos' }}
            </button>
            <button class="border-2 border-white text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-indigo-600 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-play mr-2"></i>
                {{ $block['secondary_button'] ?? 'Ver Video' }}
            </button>
        </div>
    </div>
</div>
